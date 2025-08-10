<?php

namespace App\Run\manager\role;

use App\Classes\Base as BaseClass;
use App\Models\Role as Role;

class Lists extends BaseClass\Model
{
    public $manager;
    public $output;

    public function AttributesLabel()
    {

    }

    public function Rules()
    {

    }

    public function Verify()
    {
        try 
        {
            $roles = Role::get();

            if(count($roles) != 0)
            {
                foreach($roles as $item)
                {
                    $this->output[] = 
                    [
                        'id' => $item->id,
                        'title' => $item->title,
                        'colorCode' => $item->colorCode,
                    ];
                }
            }
        } catch (\Exception $e) 
        {
            return $this->AddRuntimeError('serverNotConnected',textLabel(2,'errors'));
        }

        return true;
    }

    public function Run()
    {
        return $this->output;
    }
}