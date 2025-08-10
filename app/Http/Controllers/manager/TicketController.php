<?php

namespace App\Http\Controllers\panel;

use App\Classes\enum\ability;
use App\Classes\enum\level;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Run\manager\ticket as ticket;

class TicketController extends Controller
{
    public function Lists(Request $request)
    {
        $model = new ticket\Lists;

        $model->manager = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_MANAGMENT->value);

        if(empty($model->manager))
            return $model->Unauthorized();

        if(!accessCheck($model->manager->roleId,ability::SHOW_SUPPORT->value))
            return $model->Inaccessibility();

        if(!$model->Validate($request))
            return $model->UnSuccess();

        if(!$model->Verify($request))
            return $model->UnSuccess();

        $output = $model->Run();

        if(!$output)
            return $model->UnSuccess();

        return $model->Success(['output'=>$output]);
    }

    public function Reply(Request $request)
    {
        $model = new ticket\Reply;

        $model->manager = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_MANAGMENT->value);

        if(empty($model->manager))
            return $model->Unauthorized();

        if(!accessCheck($model->manager->roleId,ability::NEW_SUPPORT->value))
            return $model->Inaccessibility();

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

        $model->manager = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_MANAGMENT->value);

        if(empty($model->manager))
            return $model->Unauthorized();

        if(!accessCheck($model->manager->roleId,ability::SHOW_SUPPORT->value))
            return $model->Inaccessibility();

        if(!$model->Validate($request))
            return $model->UnSuccess();

        if(!$model->Verify($request))
            return $model->UnSuccess();

        $output = $model->Run();

        if(!$output)
            return $model->UnSuccess();

        return $model->Success(['output'=>$output]);
    }

    public function ChangeStatus(Request $request)
    {
        $model = new ticket\ChangeStatus;

        $model->manager = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_MANAGMENT->value);

        if(empty($model->manager))
            return $model->Unauthorized();

        if(!accessCheck($model->manager->roleId,ability::EDIT_SUPPORT->value))
            return $model->Inaccessibility();

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


