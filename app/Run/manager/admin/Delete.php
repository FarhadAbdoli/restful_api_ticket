<?php

namespace App\Run\manager\admin;

use App\Classes\Base as BaseClass;
use App\Classes\enum\constant;
use App\Models\Manager;
use App\Models\Role as Role;

class Delete extends BaseClass\Model
{
    public $manager;
    public $admin;

    public $managerId;

    public function AttributesLabel()
    {
        return
        [
            'managerId' => textLabel(7,'attributes'),
        ];
    }

    public function Rules()
    {
        return
        [
            'managerId' => ['required','integer'],
        ];
    }

    public function Verify()
    {
        $this->admin = Manager::where('id',$this->managerId)->First();

        if(empty($this->admin))
            return $this->AddRuntimeError('notExistManager',textLabel(5,'errors'));

        $role = Role::where('id',$this->admin->roleId)->First();

        if($role->title == constant::ROLE_MAIN_MANAGER->value)
            return $this->AddRuntimeError('inaccessibility',textLabel(4,'errors'));

        return true;
    }

    public function Run()
    {
       try
       {
            $this->admin->delete();

       } catch (\Throwable $th)
       {
            return $this->AddRuntimeError('serverNotConnected',textLabel(2,'errors'));
       }

       return true;
    }
}
