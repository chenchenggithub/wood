<?php
/**
 * production
 */
return array(
    'default'     => 'mysql',

    'connections' => array(
        'mysql'    => array(
            'read'      => array(
                'host' => '10.0.1.77',
            ),
            'write'     => array(
                'host' => '10.0.1.77'
            ),
            'driver'    => 'mysql',
            'database'  => 'db_toushibao_main',
            'username'  => 'root',
            'password'  => '123456',
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
            'port'      => '3307',
            'prefix'    => '',
        ),
    ),

);