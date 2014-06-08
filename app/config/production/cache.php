<?php
/**
 * production
 */
return array(

    'driver'     => 'redis',

    'path'       => storage_path() . '/cache',

    'connection' => NULL,

    'table'      => 'cache',

    'memcached'  => array(

        array('host' => '127.0.0.1', 'port' => 11211, 'weight' => 100),

    ),

    'prefix'     => 'tsb',

);
