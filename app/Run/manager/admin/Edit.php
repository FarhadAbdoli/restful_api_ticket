<?php

namespace App\Run\manager\admin;

use App\Classes\Base as BaseClass;
use App\Classes\enum\constant;
use App\Models\Manager;
use App\Models\Role as Role;

class Edit extends BaseClass\Model
{
    public $manager;
    public $admin;

    public $managerId;
    public $fullName;
    public $mobile;
    public $roleId;

    public function AttributesLabel()
    {
        return
        [
            'managerId' => textLabel(7,'attributes'),
            'fullName' => textLabel(6,'attributes'),
            'mobile' => textLabel(0,'attributes'),
            'roleId' => textLabel(5,'attributes'),
        ];
    }

    public function Rules()
    {
        return
        [
            'managerId' => ['required','integer'],
            'fullName' => ['required','string','max:250'],
            'mobile' => ['required','string','regex:/(09)[0-9]{9}/'],
            'roleId' => ['required','integer'],
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

        $error = true;
        foreach(Role::get() as $item)
        {
            if($item->id == $this->admin->roleId)
            {
                if($item->title == constant::ROLE_MAIN_MANAGER->value)
                    return $this->AddRuntimeError('inaccessibility',textLabel(4,'errors'));
            }

            if($item->id == $this->roleId)
            {
                $error = false;
                if($item->title == constant::ROLE_MAIN_MANAGER->value)
                    return $this->AddRuntimeError('inaccessibility',textLabel(4,'errors'));
            }
        }

        if($error)
            return $this->AddRuntimeError('notExistRole',textLabel(7,'errors'));

        if($this->admin->mobile != $this->mobile)
        {
            if(Manager::where('mobile', '=', $this->mobile)->exists())
                return $this->AddRuntimeError('duplicateMobile',textLabel(11,'errors'));
        }

        return true;
    }

    public function Run()
    {
       try
       {
            $this->admin->fullName = $this->fullName;
            $this->admin->mobile = $this->mobile;
            $this->admin->roleId = $this->roleId;
            $this->admin->update();

       } catch (\Exception $e)
       {
            return $this->AddRuntimeError('serverNotConnected',textLabel(2,'errors'));
       }

       return true;
    }
}
