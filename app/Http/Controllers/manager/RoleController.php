<?php

namespace App\Http\Controllers\panel;

use App\Classes\enum\ability;
use App\Classes\enum\level;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Run\manager\role as role;

class RoleController extends Controller
{
    public function AddRole(Request $request)
    {
        $model = new role\Add;

        $model->manager = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_MANAGMENT->value);

        if(empty($model->manager))
            return $model->Unauthorized();

        if(!accessCheck($model->manager->roleId,ability::NEW_ROLE->value))
            return $model->Inaccessibility();

        if(!$model->Validate($request))
            return $model->UnSuccess();

        if(!$model->Verify($request))
            return $model->UnSuccess();

        if(!$model->Run())
            return $model->UnSuccess();

        return $model->Success();
    }

    public function EditRole(Request $request)
    {
        $model = new role\Edit;

        $model->manager = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_MANAGMENT->value);

        if(empty($model->manager))
            return $model->Unauthorized();

        if(!accessCheck($model->manager->roleId,ability::EDIT_ROLE->value))
            return $model->Inaccessibility();

        if(!$model->Validate($request))
            return $model->UnSuccess();

        if(!$model->Verify($request))
            return $model->UnSuccess();

        if(!$model->Run())
            return $model->UnSuccess();

        return $model->Success();
    }

    public function DeleteRole(Request $request)
    {
        $model = new role\Delete;

        $model->manager = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_MANAGMENT->value);

        if(empty($model->manager))
            return $model->Unauthorized();

        if(!accessCheck($model->manager->roleId,ability::DELETE_ROLE->value))
            return $model->Inaccessibility();

        if(!$model->Validate($request))
            return $model->UnSuccess();

        if(!$model->Verify($request))
            return $model->UnSuccess();

        if(!$model->Run())
            return $model->UnSuccess();

        return $model->Success();
    }

    public function ShowRole(Request $request)
    {
        $model = new role\Show;

        $model->manager = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_MANAGMENT->value);

        if(empty($model->manager))
            return $model->Unauthorized();

        if(!accessCheck($model->manager->roleId,ability::SHOW_ROLE->value))
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

    public function ListRole(Request $request)
    {
        $model = new role\Lists;

        $model->manager = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_MANAGMENT->value);

        if(empty($model->manager))
            return $model->Unauthorized();

        if(!accessCheck($model->manager->roleId,ability::SHOW_ROLE->value))
            return $model->Inaccessibility();

        if(!$model->Verify($request))
            return $model->UnSuccess();

        $output = $model->Run();

        if(!$output)
            return $model->UnSuccess();

        return $model->Success(['output'=>$output]);
    }

    public function ListAbility(Request $request)
    {
        $model = new role\ListAbility;

        $model->manager = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_MANAGMENT->value);

        if(empty($model->manager))
            return $model->Unauthorized();

        $output = $model->Run();

        if(!$output)
            return $model->UnSuccess();

        return $model->Success(['output'=>$output]);
    }
}
