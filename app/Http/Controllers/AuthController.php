<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class AuthController extends Controller
{
    use HttpResponses;
    public function login(LoginUserRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->validated($request->all());

        if(!Auth::attempt($request->only(['email','password']))){
            return $this->error('','Credentials do not match',401);
        }
        $user= User::Where('email',$request['email'])->first();
        $roles = $user->roles()->get()->makeHidden('pivot');
        $user["roles"]=$roles;
        return $this->success([
            'user'=>$user,
            'token'=>$user->createToken('Api Token of'.$user->name)->plainTextToken
        ]);
    }

    public function register(StoreUserRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->validated($request->all());

        $user = User::create([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'password'=>Hash::make($request['password'])
        ]);
        $user->roles()->attach(1);
        // hide the pivote object from the query
        $roles = $user->roles()->get()->makeHidden('pivot');
        $user["roles"]=$roles;
        $user['profilePicture']=null;
        return $this->success([
            'user'=>$user,
            'token'=>$user->createToken('API Token of'.$user->name)->plainTextToken,
        ], );
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();
        return $this->success([
            'message'=>'You have successfully been logged out.'
        ]);
    }

    public function verifyToken(Request $request){
        $user=$request->user('sanctum');

        if($request->user('sanctum')== null){
            return response('unauthorized',401);
        }
            $roles = $user->roles()->get()->makeHidden('pivot');
            $user["roles"]=$roles;
            return $user;
    }

    public function changePassword(Request $request){
        $request->validate([
            'old_password'=>'required',
            'new_password'=>'required'
        ]);
        $user=User::find(Auth::user()->id);
        if($user){
            if(Hash::check($request['old_password'],$user->password)){
                $user->password=bcrypt($request->new_password);
                $user->update();
                return 'password changed';
            }else{
                return response()->json(['error' => 'old password not match !'], 401);
            }
        }
        return 'user not found';
    }
}
