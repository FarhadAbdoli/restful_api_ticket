<?php

namespace App\Run\manager\authentication;

use App\Classes\Base as BaseClass;
use App\Models\Manager;
use Illuminate\Support\Facades\Hash;

class Login extends BaseClass\Model
{
    public $manager;

    public $mobile;
    public $password;

    public function AttributesLabel()
    {
        return 
        [
            'mobile' => textLabel(0,'attributes'),
            'password' => textLabel(1,'attributes'),
        ];
    }

    public function Rules()
    {
        return 
        [
            'mobile' => ['required','string','regex:/(09)[0-9]{9}/'],
            'password' => ['required','string','max:100'],
        ];
    }

    public function Verify()
    {
        $this->manager = Manager::where('mobile', $this->mobile)->first();

        if(empty($this->manager))
            return $this->AddRuntimeError('mobileNotExist',textLabel(0,'errors'));

        if(!Hash::check($this->password, $this->manager->password)) 
            return $this->AddRuntimeError('wrongPassword',textLabel(1,'errors'));

        return true;
    }

    public function Run()
    {
       try 
       {
            $this->manager->token = setToken();
            $this->manager->ip = getIP();
            $this->manager->save();
       } catch (\Exception $e) 
       {
            return $this->AddRuntimeError('serverNotConnected',textLabel(2,'errors'));
       }

       return $output = 
        [
            'token' => $this->manager->token,
            'roleName' => roleName($this->manager->roleId),
            'roleId' => $this->manager->roleId,
        ];
    }
}
