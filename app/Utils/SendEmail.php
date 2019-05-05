<?php

namespace App\Utils;

use Illuminate\Support\Facades\Mail;

class SendEmail
{

    public static function sendError($exception)
    {
        Mail::send('error', compact('exception'), function ($mail) {
            $mail->to(env('MAIL_WEBMASTER'))
                ->from(env('MAIL_NO_REPLY'))
                ->subject('Website Error');
        });
    }
}