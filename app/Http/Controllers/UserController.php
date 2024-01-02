<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfilePictureRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use HttpResponses;

    public function changeProfilePicture(Request $request)
    {
        if($request->hasFile('image')){
            $user=User::find(Auth::user()->id);

            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $image_path = $request->file('image')->storeAs('public',  'images/'.$imageName);

            if($user->profilePicture=== null){
                $user->profilePicture = $image_path;
                $user->update();

                return $this->success($user,'profile picture uploaded 1',201);
            }else{
                $oldImage=$user->profilePicture;
                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
                $user->profilePicture = $image_path;
                $user->update();
                return $this->success($user,'profile picture updated ',200);
            }

//            return  $user;
        }else{
            return $this->error('','The image field is required.',400);
        }


//        return $request->all();
    }
}
