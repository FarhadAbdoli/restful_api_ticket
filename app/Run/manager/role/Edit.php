<?php

namespace App\Run\manager\role;

use App\Classes\Base as BaseClass;
use App\Classes\enum\constant;
use App\Models\Abilities;
use App\Models\Role;

class Edit extends BaseClass\Model
{
    public $manager;
    public $role;

    public $roleId;
    public $title;
    public $colorCode;
    public $abilities;

    public function AttributesLabel()
    {
        return 
        [
            'roleId' => textLabel(5,'attributes'),
            'title' => textLabel(2,'attributes'),
            'colorCode' => textLabel(3,'attributes'),
            'abilities' => textLabel(4,'attributes'),
        ];
    }

    public function Rules()
    {
        return 
        [
            'roleId' => ['required','integer'],
            'title' => ['required','string','max:256'],
            'colorCode' => ['nullable','string','max:20'],
            'abilities' => ['required','array'],
        ];
    }

    public function Verify()
    {
        $this->role = Role::where('id', $this->roleId)->first();

        if(empty($this->role))
            return $this->AddRuntimeError('notExistRole',textLabel(7,'errors'));

        if($this->role->title == constant::ROLE_MAIN_MANAGER || $this->title ==  constant::ROLE_MAIN_MANAGER)    
            return $this->AddRuntimeError('inaccessibility',textLabel(4,'errors'));

        if($this->role->title != $this->title)
        {
            if(Role::where('title', '=', $this->title)->exists()) 
                return $this->AddRuntimeError('duplicateTitle',textLabel(9,'errors'));
        }

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
            $this->role->title = $this->title;
            $this->role->colorCode = empty($this->colorCode) ? '' : $this->colorCode;
            $this->role->abilities = $this->abilities;
            $this->role->update();
       } catch (\Exception $e) 
       {
            return $this->AddRuntimeError('serverNotConnected',textLabel(2,'errors'));
       }

       return true;
    }
}
