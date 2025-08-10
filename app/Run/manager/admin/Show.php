<?php

namespace App\Run\manager\admin;

use App\Classes\Base as BaseClass;
use App\Models\Manager;

class Show extends BaseClass\Model
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

        return true;
    }

    public function Run()
    {
        $output = [];
        $output =
        [
            'id' => $this->admin->id,
            'fullName' => $this->admin->fullName,
            'mobile' => $this->admin->mobile,
            'roleId' => $this->admin->roleId,
            'roleName' => roleName($this->admin->roleId),
        ];

        return $output;
    }
}
