<?php

declare(strict_types = 1);

global $INSTALLER09;
$INSTALLER09['sitecache']['driver'] = 'memory'; // Choices are memory, file, redis, memcached, apcu
$INSTALLER09['sitecache']['prefix'] = 'u232_';

// Redis Settings
$INSTALLER09['redis']['host'] = '127.0.0.1';
$INSTALLER09['redis']['port'] = 6379;
$INSTALLER09['redis']['database'] = 1;
$INSTALLER09['redis']['socket'] = '/dev/shm/redis.sock';
$INSTALLER09['redis']['use_socket'] = false;

// Memcached Settings
$INSTALLER09['memcached']['host'] = '127.0.0.1';
$INSTALLER09['memcached']['port'] = 11211;
$INSTALLER09['memcached']['socket'] = '/dev/shm/memcached.sock';
$INSTALLER09['memcached']['use_socket'] = false;

$INSTALLER09['files']['path'] = '/dev/shm/u232';
