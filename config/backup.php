<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Database backup / restore
    |--------------------------------------------------------------------------
    |
    | Credentials for the mysqldump-based backup used by DashboardController.
    | These default to the application's primary database connection so the
    | backup keeps working without extra configuration.
    |
    */

    'db' => [
        'host'     => env('BACKUP_DB_HOST', env('DB_HOST', '127.0.0.1')),
        'database' => env('BACKUP_DB_DATABASE', env('DB_DATABASE')),
        'username' => env('BACKUP_DB_USERNAME', env('DB_USERNAME')),
        'password' => env('BACKUP_DB_PASSWORD', env('DB_PASSWORD')),
    ],

    // Where the dump is written before upload, relative to storage/app.
    'dump_file' => env('BACKUP_DUMP_FILE', 'backup.sql'),

    /*
    |--------------------------------------------------------------------------
    | Offsite FTP target
    |--------------------------------------------------------------------------
    |
    | Leave BACKUP_FTP_HOST empty to disable the offsite upload entirely.
    | Prefer FTPS (BACKUP_FTP_SSL=true) — plain FTP sends credentials in clear
    | text over the network.
    |
    */

    'ftp' => [
        'host'        => env('BACKUP_FTP_HOST'),
        'username'    => env('BACKUP_FTP_USERNAME'),
        'password'    => env('BACKUP_FTP_PASSWORD'),
        'remote_path' => env('BACKUP_FTP_REMOTE_PATH'),
        'ssl'         => env('BACKUP_FTP_SSL', true),
        'timeout'     => env('BACKUP_FTP_TIMEOUT', 30),
    ],

];
