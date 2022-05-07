<?php

return [
    // Supported: "smtp", "sendmail", "mailgun", "ses", "postmark", "log", "array"
    'driver' => env('MAIL_DRIVER', 'log'),

    // SMTP
    'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
    'port' => env('MAIL_PORT', 587),
    'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    'username' => env('MAIL_USERNAME'),
    'password' => env('MAIL_PASSWORD'),

    // Sendmail System Path
    'sendmail' => '/usr/sbin/sendmail -bs',

    // From (default from for all email, can be changed runtime)
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'uaatreq@uw.edu'),
        'name' => env('MAIL_FROM_NAME', 'TREQ'),
    ],

    // To (if to['address'] is not null all mail will be sent here, runtime To, Cc, Bcc will be ignored)
    'to' => [
        'address' => env('MAIL_TO_OVERRIDE', null),
        'name' => env('MAIL_TO_OVERRIDE_NAME', '')
    ],

    // Log Channel
    'log_channel' => env('MAIL_LOG_CHANNEL', 'email'),

    // Markdown Mail Settings
    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],
];
