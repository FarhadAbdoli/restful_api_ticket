<?php

use App\Http\Controllers\panel\AdminController;
use App\Http\Controllers\panel\AuthController;
use App\Http\Controllers\panel\RoleController;
use App\Http\Controllers\panel\TicketController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\user\TicketController as UserTicketController;
use App\Http\Controllers\user\AuthenticationController as UserAuthenticationController;


Route::prefix('manager')->group(function ()
{
    // AuthController
    Route::post('login', [AuthController::class, 'Login']);

    // RoleController
    Route::post('addRole', [RoleController::class, 'AddRole']);
    Route::post('editRole', [RoleController::class, 'EditRole']);
    Route::post('deleteRole', [RoleController::class, 'DeleteRole']);
    Route::get('showRole', [RoleController::class, 'ShowRole']);
    Route::get('listRole', [RoleController::class, 'ListRole']);
    Route::get('listAbility', [RoleController::class, 'ListAbility']);

    // AdminController
    Route::post('addAdmin', [AdminController::class, 'AddAdmin']);
    Route::post('editAdmin', [AdminController::class, 'EditAdmin']);
    Route::post('deleteAdmin', [AdminController::class, 'DeleteAdmin']);
    Route::get('showAdmin', [AdminController::class, 'ShowAdmin']);
    Route::get('listAdmin', [AdminController::class, 'ListAdmin']);

    // TicketController
    Route::get('listTickets', [TicketController::class, 'Lists']);
    Route::post('replyTickets', [TicketController::class, 'Reply']);
    Route::get('showTicket', [TicketController::class, 'Show']);
    Route::post('changeStatusTicket', [TicketController::class, 'ChangeStatus']);
});

Route::prefix('user')->group(function ()
{

    // UserAuthController
    Route::post('login', [UserAuthenticationController::class, 'Login']);

    // UserTicketController
    Route::get('listUserTicket', [UserTicketController::class, 'Lists']);
    Route::post('addUserTicket', [UserTicketController::class, 'Add']);
    Route::get('showUserTicket', [UserTicketController::class, 'Show']);
    Route::post('replyUserTicket', [UserTicketController::class, 'Reply']);
    Route::post('changeStatusUserTicket', [UserTicketController::class, 'ChangeStatus']);
});
