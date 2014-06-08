<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-13 下午1:57
 *
 *
 * php-redis-ext
 * https://github.com/nicolasff/phpredis.git
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
