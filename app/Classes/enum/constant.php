<?php

namespace App\Classes\enum;

enum constant: string
{
    case ADDRESS_WEBSITE = 'https://atrarzhang.com';
    case MEDIA = 'https://storage.atrarzhang.com/';
    case UPLOAD_FTP_ADDRESS = 'domains/pz20937.parspack.net/public_html/';
    //case TOKEN_SMS = '99BF18C9-E783-47C9-A904-269CBBE0CA23';
    //case ADDRESS_SMS = 'https://sms.parsgreen.ir/Apiv2/Message/SendSms';

    case LINK_IMAGE_PRODUCT = 'images/Product/';
    case LINK_IMAGE_USER = 'images/User/';
    case LINK_VIDEO_PRODUCT = 'videos/Product/';
    case LINK_TICKET = 'files/Ticket/';
    case LINK_IMAGE_BLOG_SLIDER = 'images/BlogSlider/';
    case LINK_IMAGE_BLOG = 'images/Blog/';
    case LINK_COVER_BLOG = 'images/BlogCover/';

    case ROLE_MAIN_MANAGER  = 'مدیرکل';

    case GENDER_MAN = 'مردانه';
    case GENDER_WOMAN = 'زنانه';
    case GENDER_UNISEX = 'بدون جنسیت';

    case SCENT_BITTER =  'تلخ';
    case SCENT_COOL = 'خنک';
    case SCENT_SWEET = 'شیرین';
    case SCENT_WARM = 'گرم';

    case PLACE_OFFICE_MEETING = 'جلسات اداری';
    case PLACE_CASUAL_DAILY = 'روزانه کژوال';
    case PLACE_FORMAL_PARTY = 'مهمانی رسمی';
    case PLACE_ROMANTIC_DATE = 'قرار عاشقانه';
    case PLACE_FRIENDS_MEETING = 'قرار دوستانه';

    case SEASON_SPRING = 'بهار';
    case SEASON_SUMMER = 'تابستان';
    case SEASON_AUTUMN = 'پاییز';
    case SEASON_WINTER = 'زمستان';
    case SEASON_ALL_SEASON = 'چهارفصل';

    case TIME_DAY = 'روز';
    case TIME_NIGHT = 'شب';
    case TIME_ALL = 'هردو';

    case STRENGTH_EAUDE_PARFUM = 'ادو پرفیوم';
    case STRENGTH_PARFUM = 'پرفیوم';
    case STRENGTH_EAUDE_TOILETTE = 'ادوتویلت';
    case STRENGTH_EXTREME = 'اکستریم';
    case STRENGTH_EXTRA_PARFUM = 'اکسترا پارفوم';
    case STRENGTH_EXTRAIT_PARFUM = 'اکستریت پارفوم';

    case LONGEVITY_HIGH = 'بالا';
    case LONGEVITY_MEDIUM_HIGH = 'متوسط رو به بالا';
    case LONGEVITY_MEDIUM_LOW = 'متوسط رو به پایین';
    case LONGEVITY_LOW = 'پایین';

    case PROJECTION_STRONG = 'قوی';
    case PROJECTION_MEDIUM = 'متوسط';
    case PROJECTION_LOW = 'کم';

    case ML_10 = '۱۰ میل';
    case ML_30 = '۳۰ میل';
    case ML_50 = '۵۰ میل';
    case ML_100 = '۱۰۰ میل';
    case ML_200 = '۲۰۰ میل';

    case PROPERTY_TYPE_OLFACTORY = 'olfactory';
    case PROPERTY_TYPE_NOTES = 'note';

    case TICKET_OPENED = 'ثبت تیکت';
    case TICKET_PROGRESS = 'درحال بررسی';
    case TICKET_ANSWERED = 'پاسخ داده شده';
    case TICKET_CLOSED = 'بسته شده';

    case DISPLAY_MODE_SINGLE = 'singleMode';
    case DISPLAY_MODE_SLIDER = 'sliderMode';

    case INVOICE_STATUS_PAID = 'پرداخت شده';
    case INVOICE_STATUS_PENDING = 'در حال پرداخت';
    case INVOICE_STATUS_SENT = 'ارسال شده';
}
