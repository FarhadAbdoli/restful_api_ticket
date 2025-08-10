<?php

namespace App\Classes\enum;

enum constant: string
{

    case LINK_TICKET = 'files/Ticket/';


    case ROLE_MAIN_MANAGER  = 'مدیرکل';

    case TICKET_OPENED = 'ثبت تیکت';
    case TICKET_PROGRESS = 'درحال بررسی';
    case TICKET_ANSWERED = 'پاسخ داده شده';
    case TICKET_CLOSED = 'بسته شده';
}
