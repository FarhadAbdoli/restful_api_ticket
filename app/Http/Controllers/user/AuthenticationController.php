<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Run\user as auth;

class AuthenticationController extends Controller
{
    public function Login(Request $request)
    {
        $model = new auth\Login;

        if(!$model->Validate($request))
            return $model->UnSuccess();

        if(!$model->Verify($request))
            return $model->UnSuccess();

        $output = $model->Run();

        if(!$output)
            return $model->UnSuccess();

        return $model->Success(['output'=>$output]);
    } 
}
