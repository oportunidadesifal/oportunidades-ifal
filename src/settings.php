<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        /* localhost
       / 'db' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'oportunista',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci'
*/      
        'db' => [   // heroku
            'driver' => 'mysql',
            'host' => 'us-cdbr-iron-east-04.cleardb.net',
            'port' => '3306',
            'database' => 'oportunista',
            'username' => 'b45cc372dbb5ce',
            'password' => '943fe5a3',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci'
        ]
    ]
];
