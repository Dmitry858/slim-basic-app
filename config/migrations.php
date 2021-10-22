<?php

return [
    'paths' => [
        'migrations' => database_path('migrations'),
        'seeds' => database_path('seeders')
    ],
   'environments' => [
       'default_migration_table' => 'migrations_log',
       'default_database' => 'slim-app',
       'slim-app' => [
           'adapter' => 'mysql',
            'host' => 'localhost',
            'port' => '3306',
            'name' => 'slim-app',
            'user' => 'root',
            'pass' => 'root',
            'charset' => 'utf8'
       ]
   ]
];