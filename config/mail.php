<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send any email
    | messages sent by your application. Alternative mailers may be setup
    | and used as needed; however, this mailer will be used by default.
    |
    */

    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the mailers used by your application plus
    | their respective settings. Several examples have been configured for
    | you and you are free to add your own as your application requires.
    |
    | Laravel supports a variety of mail "transport" drivers to be used while
    | sending an e-mail. You will specify which one you are using for your
    | mailers below. You are free to add additional mailers as required.
    |
    | Supported: "smtp", "sendmail", "mailgun", "ses", "ses-v2",
    |            "postmark", "log", "array", "failover", "roundrobin"
    |
    */

    'mailers' => array(
        'smtp' => array(
            'transport' => 'smtp',
            'url' => env('MAIL_URL'),
            'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN'),
        ),

        'ses' => array(
            'transport' => 'ses',
        ),

        'postmark' => array(
            'transport' => 'postmark',
            // 'message_stream_id' => null,
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ),

        'mailgun' => array(
            'transport' => 'mailgun',
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ),

        'sendmail' => array(
            'transport' => 'sendmail',
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
        ),

        'log' => array(
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ),

        'array' => array(
            'transport' => 'array',
        ),

        'failover' => array(
            'transport' => 'failover',
            'mailers' => array(
                'smtp',
                'log',
            ),
        ),

        'roundrobin' => array(
            'transport' => 'roundrobin',
            'mailers' => array(
                'ses',
                'postmark',
            ),
        ),
    ),

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all e-mails sent by your application to be sent from
    | the same address. Here, you may specify a name and address that is
    | used globally for all e-mails that are sent by your application.
    |
    */

    'from' => array(
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ),

    /*
    |--------------------------------------------------------------------------
    | Markdown Mail Settings
    |--------------------------------------------------------------------------
    |
    | If you are using Markdown based email rendering, you may configure your
    | theme and component paths here, allowing you to customize the design
    | of the emails. Or, you may simply stick with the Laravel defaults!
    |
    */

    'markdown' => array(
        'theme' => 'default',

        'paths' => array(
            resource_path('views/vendor/mail'),
        ),
    ),

);
