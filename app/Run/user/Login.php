<?php

namespace App\Run\user;

use App\Classes\Base as BaseClass;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Login extends BaseClass\Model
{
    public $user;

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
        $this->user = User::where('mobile', $this->mobile)->first();

        if(empty($this->user))
            return $this->AddRuntimeError('mobileNotExist',textLabel(0,'errors'));

        if(!Hash::check($this->password, $this->user->password)) 
            return $this->AddRuntimeError('wrongPassword',textLabel(1,'errors'));

        return true;
    }

    public function Run()
    {
       try 
       {
            $this->user->token = setToken();
            $this->user->ip = getIP();
            $this->user->save();
       } catch (\Exception $e) 
       {
            return $this->AddRuntimeError('serverNotConnected',textLabel(2,'errors'));
       }

       return $output = 
        [
            'token' => $this->user->token,
        ];
    }
}
