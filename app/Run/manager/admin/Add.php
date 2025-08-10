<?php

namespace App\Run\manager\admin;

use App\Classes\Base as BaseClass;
use App\Classes\enum\constant;
use App\Models\Manager;
use App\Models\Role as Role;
use Illuminate\Support\Facades\Hash;

class Add extends BaseClass\Model
{
    public $manager;

    public $fullName;
    public $mobile;
    public $roleId;
    public $password;

    public function AttributesLabel()
    {
        return 
        [
            'fullName' => textLabel(6,'attributes'),
            'mobile' => textLabel(0,'attributes'),
            'roleId' => textLabel(5,'attributes'),
            'password' => textLabel(1,'attributes'),
        ];
    }

    public function Rules()
    {
        return 
        [
            'fullName' => ['required','string','max:250'],
            'mobile' => ['required','unique:managers','string','regex:/(09)[0-9]{9}/'],
            'roleId' => ['required','integer'],
            'password' => ['required','min:4','max:50'],
        ];
    }

    public function Verify()
    {

        $role = Role::where('id',$this->roleId)->first();

        if(empty($role))
            return $this->AddRuntimeError('notExistRole',textLabel(7,'errors'));

        if($role->title == constant::ROLE_MAIN_MANAGER->value)
            return $this->AddRuntimeError('inaccessibility',textLabel(4,'errors'));

        return true;
    }

    public function Run()
    {
        try 
        {
            $admin = new Manager();
            $admin->fullName = $this->fullName;
            $admin->password = Hash::make($this->password);
            $admin->mobile = $this->mobile;
            $admin->roleId = $this->roleId;
            $admin->save();       
        } catch (\Exception $e) 
        {
            return $this->AddRuntimeError('serverNotConnected',textLabel(2,'errors'));
        }

       return true;
    }
}