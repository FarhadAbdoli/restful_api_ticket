<?php

namespace App\Run\manager\role;

use App\Classes\Base as BaseClass;
use App\Classes\enum\constant;
use App\Models\Manager;
use App\Models\Role as Role;

class Delete extends BaseClass\Model
{
    public $manager;
    public $role;

    public $roleId;

    public function AttributesLabel()
    {
        return 
        [
            'roleId' => textLabel(5,'attributes'),
        ];
    }

    public function Rules()
    {
        return 
        [
            'roleId' => ['required','integer'],
        ];
    }

    public function Verify()
    {
        $this->role = Role::where('id', $this->roleId)->first();

        if(empty($this->role))
            return $this->AddRuntimeError('notExistRole',textLabel(7,'errors'));

        if($this->role->title == constant::ROLE_MAIN_MANAGER)    
            return $this->AddRuntimeError('inaccessibility',textLabel(4,'errors'));

        if(Manager::where('roleId', $this->roleId)->exists())
            return $this->AddRuntimeError('undeletable',textLabel(8,'errors'));

        return true;
    }

    public function Run()
    {
       try 
       {
            $this->role->delete();

       } catch (\Exception $e) 
       {
            return $this->AddRuntimeError('serverNotConnected',textLabel(2,'errors'));
       }

       return true;
    }
}