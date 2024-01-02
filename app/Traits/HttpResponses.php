<?php

namespace App\Traits;

trait HttpResponses{
    protected function success($data,$message=null,$code=200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status'=>'Request success',
            "message"=>$message,
            "data"=>$data
        ],$code);
    }

    protected function error($data,$message=null,$code=200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status'=>'Request success',
            "message"=>$message,
            "data"=>$data
        ],$code);
    }
}
