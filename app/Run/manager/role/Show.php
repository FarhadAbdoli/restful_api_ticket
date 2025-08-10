<?php

namespace App\Run\manager\role;

use App\Classes\Base as BaseClass;
use App\Models\Role as Role;

class Show extends BaseClass\Model
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

        return true;
    }

    public function Run()
    {
        try 
        {
            $output['id'] = $this->role->id;
            $output['title'] = $this->role->title;
            $output['colorCode'] = $this->role->colorCode;
            $output['abilities'] = $this->role->abilities;
            
        } catch (\Exception $e) 
        {
            return $this->AddRuntimeError('serverNotConnected',textLabel(2,'errors'));
        }

        return $output;
    }
}