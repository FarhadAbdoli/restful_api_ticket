<?php

namespace App\Run\manager\admin;

use App\Classes\Base as BaseClass;
use App\Models\Manager;
use App\Models\Role;

class Lists extends BaseClass\Model
{
    public $manager;
    public $output = 'empty';

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
            $managers = Manager::get();
            $role = Role::whereIn('id',$managers->pluck('roleId'))->get()->keyBy('id');
            if(count($managers) != 0)
            {
                $this->output = [];
                foreach($managers as $item)
                {
                    $this->output[] =
                    [
                        'id' => $item->id,
                        'fullName' => $item->fullName,
                        'mobile' => $item->mobile,
                        'roleId' => $item->roleId,
                        'roleName' => $role[$item->roleId]['title'],
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
