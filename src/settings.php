<?php
$heroku = true; //heroku =true, localhost=false
if ($heroku == true) {
    $dbstr = getenv('CLEARDB_DATABASE_URL');

    $dbstr = substr("$dbstr", 8);
    $dbstrarruser = explode(":", $dbstr);

    $dbstrarrhost = explode("@", $dbstrarruser[1]);
    $dbstrarrrecon = explode("?", $dbstrarrhost[1]);
    $dbstrarrport = explode("/", $dbstrarrrecon[0]);

    $dbpassword = $dbstrarrhost[0];
    $dbhost = $dbstrarrport[0];
    $dbport = $dbstrarrport[0];
    $dbuser = $dbstrarruser[0];
    $dbname = $dbstrarrport[1];

    unset($dbstrarrrecon);
    unset($dbstrarrport);
    unset($dbstrarruser);
    unset($dbstrarrhost);

    unset($dbstr);

    $db = [   // heroku
        'driver' => 'mysql',
        'host' => $dbhost,
        //'port' => '3306',   
        'database' =>  $dbname,
        'username' => $dbuser,
        'password' => $dbpassword,
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci'
    ];
} else
    $db = [   // localhost
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' =>  'oportunista',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci'
    ];


return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'db' => $db
    ]
];