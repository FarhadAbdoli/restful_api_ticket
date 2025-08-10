<?php

namespace App\Run\manager\role;

use App\Classes\Base as BaseClass;
use App\Models\Abilities;

class ListAbility extends BaseClass\Model
{
    public $manager;

    public function AttributesLabel()
    {

    }

    public function Rules()
    {

    }

    public function Verify()
    {

        return true;
    }

    public function Run()
    {
        $output = [];
        $sub = [];

        $data = Abilities::where('visible', '=', true)->get();
        try
        {
            foreach($data as $item)
            {
                $sub[$item->typeId][] =
                [
                    'id' => $item->id,
                    'title' => $item->title,
                ];
            }

            foreach($data as $item)
            {
                $output[$item->typeId] =
                [
                    'typeId' => $item->typeId,
                    'typeName' => $item->type,
                    'items' => $sub[$item->typeId]
                ];
            }

            $output = array_reverse($output);

        } catch (\Exception $e)
        {
            return $this->AddRuntimeError('serverNotConnected',textLabel(2,'errors'));
        }

        return $output;
    }
}
