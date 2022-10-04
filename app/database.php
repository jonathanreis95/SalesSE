<?php

return [
        /**
         * Options (mysql, sqlite)
         * 
         */
        'driver' => 'postgree',
        'sqlite' => [
            'host'=> 'databse.db',
            'charset'=> 'utf8',
            'collation'=> 'utf8_unicode_ci',
        ],

        'mysql' =>[
            'host' => 'localhost',
            'database' => 'sales',
            'user' => 'root',
            'pass' => '',
            'charset' => 'utf8',
            'collation'=> 'utf8_unicode_ci',
        ],

        'postgree' =>[
            'host' => 'localhost',
            'port' => '5432',
            'database' => 'sales',
            'user' => 'postgres',
            'pass' => '123'
        ]

    ];