<?php

namespace App\Http\Controllers\panel;

use App\Classes\enum\ability;
use App\Classes\enum\level;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Run\manager\admin as admin;
class AdminController extends Controller
{
    public function AddAdmin(Request $request)
    {
        $model = new admin\Add;

        $model->manager = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_MANAGMENT->value);

        if(empty($model->manager))
            return $model->Unauthorized();
    
        if(!accessCheck($model->manager->roleId,ability::NEW_MANAGER->value))
            return $model->Inaccessibility();

        if(!$model->Validate($request))
            return $model->UnSuccess();

        if(!$model->Verify($request))
            return $model->UnSuccess();

        if(!$model->Run())
            return $model->UnSuccess();
        
        return $model->Success();
    }   

    public function EditAdmin(Request $request)
    {
        $model = new admin\Edit;

        $model->manager = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_MANAGMENT->value);

        if(empty($model->manager))
            return $model->Unauthorized();

        if(!accessCheck($model->manager->roleId,ability::EDIT_MANAGER->value))
            return $model->Inaccessibility();

        if(!$model->Validate($request))
            return $model->UnSuccess();

        if(!$model->Verify($request))
            return $model->UnSuccess();

        if(!$model->Run())
            return $model->UnSuccess();
        
        return $model->Success();
    } 

    public function DeleteAdmin(Request $request)
    {
        $model = new admin\Delete;

        $model->manager = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_MANAGMENT->value);
        
        if(empty($model->manager))
            return $model->Unauthorized();

        if(!accessCheck($model->manager->roleId,ability::DELETE_MANAGER->value))
            return $model->Inaccessibility();

        if(!$model->Validate($request))
            return $model->UnSuccess();

        if(!$model->Verify($request))
            return $model->UnSuccess();

        if(!$model->Run())
            return $model->UnSuccess();
        
        return $model->Success();
    }  

    public function ShowAdmin(Request $request)
    {
        $model = new admin\Show;

        $model->manager = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_MANAGMENT->value);

        if(empty($model->manager))
            return $model->Unauthorized();

        if(!accessCheck($model->manager->roleId,ability::SHOW_MANAGER->value))
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

    public function ListAdmin(Request $request)
    {
        $model = new admin\Lists;

        $model->manager = checkToken($request->bearerToken(),$request->ip(),level::LEVEL_MANAGMENT->value);

        if(empty($model->manager))
            return $model->Unauthorized();

        if(!accessCheck($model->manager->roleId,ability::SHOW_MANAGER->value))
            return $model->Inaccessibility();

        if(!$model->Verify($request))
            return $model->UnSuccess();
        
        $output = $model->Run();

        if(!$output)
            return $model->UnSuccess();
        
        return $model->Success(['output'=>$output]); 
    } 
}
