<?php

namespace App\Run\manager\role;

use App\Classes\Base as BaseClass;
use App\Classes\enum\constant;
use App\Models\Abilities;
use App\Models\Role;

class Add extends BaseClass\Model
{
    public $manager;

    public $title;
    public $colorCode;
    public $abilities;

    public function AttributesLabel()
    {
        return 
        [
            'title' => textLabel(2,'attributes'),
            'colorCode' => textLabel(3,'attributes'),
            'abilities' => textLabel(4,'attributes'),
        ];
    }

    public function Rules()
    {
        return 
        [
            'title' => ['required','unique:roles','string','max:256'],
            'colorCode' => ['nullable','string','max:20'],
            'abilities' => ['required','array'],
        ];
    }

    public function Verify()
    {
        if($this->title == constant::ROLE_MAIN_MANAGER->value)
            return $this->AddRuntimeError('inaccessibility',textLabel(4,'errors'));

        $data = Abilities::where('visible', '=', true)->get()->keyBy('id');

        foreach($this->abilities as $item)
        {
            if(empty($data[$item]))
                return $this->AddRuntimeError('notExistAbility',textLabel(6,'errors'));
        }
        
        return true;
    }

    public function Run()
    {
       try 
       {
            $role = new Role();
            $role->title = $this->title;
            $role->colorCode = empty($this->colorCode) ? '' : $this->colorCode;
            $role->abilities = $this->abilities;
            $role->save();
       } catch (\Exception $e) 
       {
            return $this->AddRuntimeError('serverNotConnected',textLabel(2,'errors'));
       }

       return true;
    }
}
