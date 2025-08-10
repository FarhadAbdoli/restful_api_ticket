<?php

use App\Classes\enum\constant;
use App\Models\Role;
use App\Classes\enum\level;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

function setToken()
{
    $token = Crypt::encryptString(time());
    return $token;
}

function checkToken($token,$ip,$level)
{
    if($level == level::LEVEL_MANAGMENT->value)
    {
        $admin = Manager::where([
            ['token', '=', $token]
        ])->first();

        if(empty($admin) || !$admin->status)
            return false;

        return $admin;

    }elseif($level == level::LEVEL_USER->value)
    {
        if(empty($token))
            return false;

        $user = User::where([
            ['token', '=', $token]
        ])->first();

        if(empty($user) || !$user->status)
            return false;

        return $user;
    }

    return false;
}

function getIP():string
{
    if(!empty($_SERVER['HTTP_CLIENT_IP']))
    {
        return $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else
    {
        return $_SERVER['REMOTE_ADDR'];
    }
}

function textLabel($key, $fileName,$lang = 'fa')
{
    if(empty($lang))
        $lang = 'fa';

    $file =  require(app_path().'/../lang/'.$lang.'/'.$fileName.'.php');
    return $file[$key];
}

function roleName($id)
{
    $role = Role::where('id',$id)->first();
    return $role->title;
}

function accessCheck($roleId,$abilityId) : bool
{
    $role = Role::where('id',$roleId)->first();

    if(empty($role))
        return false;

    if(!in_array($abilityId,$role->abilities))
        return false;

    return true;
}

function convertToTimestamp(string $time, string $type = 'none'): int
{
    $carbon = Jalalian::fromFormat('Y/m/d', $time)
        ->toCarbon()
        ->setTimezone('Asia/Tehran');

    return match ($type) {
        'start' => $carbon->startOfDay()->timestamp,
        'end'   => $carbon->endOfDay()->timestamp,
        default => $carbon->timestamp,
    };
}

function convertToPersianDate($timestamp) : string
{
    $jalaliDate = Jalalian::fromCarbon(
        \Carbon\Carbon::createFromTimestamp($timestamp)->setTimezone('Asia/Tehran')
    )->format('H:i - Y/m/d');
    return $jalaliDate;
}



