<?php

namespace App\Http\Controllers\user;

use App\Classes\enum\level;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Run\user as ticket;

class TicketController extends Controller
{
    public function Lists(Request $request)
    {
        $model = new ticket\Lists;

        $model->user = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_USER->value);

        if(empty($model->user))
            return $model->Unauthorized();

        if(!$model->Validate($request))
            return $model->UnSuccess();
        
        if(!$model->Verify($request))
            return $model->UnSuccess();

        $output = $model->Run();

        if(!$output)
            return $model->UnSuccess();

        return $model->Success($output == 'empty' ? ['output'=>[]] : ['output'=>$output]);
    }

    public function Add(Request $request)
    {
        $model = new ticket\Add;

        $model->user = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_USER->value);

        if(empty($model->user))
            return $model->Unauthorized();

        if(!$model->Validate($request))
            return $model->UnSuccess();

        if(!$model->Verify($request))
            return $model->UnSuccess();

        $output = $model->Run();

        if(!$output)
            return $model->UnSuccess();

        return $model->Success();
    }

    public function Show(Request $request)
    {
        $model = new ticket\Show;

        $model->user = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_USER->value);

        if(empty($model->user))
            return $model->Unauthorized();

        if(!$model->Validate($request))
            return $model->UnSuccess();
        
        if(!$model->Verify($request))
            return $model->UnSuccess();

        $output = $model->Run();

        if(!$output)
            return $model->UnSuccess();

        return $model->Success($output == 'empty' ? ['output'=>[]] : ['output'=>$output]);
    }

    public function Reply(Request $request)
    {
        $model = new ticket\Reply;

        $model->user = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_USER->value);

        if(empty($model->user))
            return $model->Unauthorized();

        if(!$model->Validate($request))
            return $model->UnSuccess();

        if(!$model->Verify($request))
            return $model->UnSuccess();

        $output = $model->Run();

        if(!$output)
            return $model->UnSuccess();

        return $model->Success();
    }

    public function ChangeStatus(Request $request)
    {
        $model = new ticket\ChangeStatus;

        $model->user = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_USER->value);

        if(empty($model->user))
            return $model->Unauthorized();

        if(!$model->Validate($request))
            return $model->UnSuccess();

        if(!$model->Verify($request))
            return $model->UnSuccess();

        $output = $model->Run();

        if(!$output)
            return $model->UnSuccess();

        return $model->Success();
    }
}
