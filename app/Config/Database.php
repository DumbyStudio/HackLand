<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
    /**
     * The directory that holds the Migrations
     * and Seeds directories.
     *
     * @var string
     */
    public $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    /**
     * Lets you choose which connection group to
     * use if no other is specified.
     *
     * @var string
     */
    public $defaultGroup = 'auth';

    /**
     * The default database connection.
     *
     * @var array
     */
    public $auth = [
        'DSN'      => 'mysql:host=localhost;dbname=RpgOnline;charset=utf8',
        'hostname' => 'localhost',
        'username' => 'authRpg',
        'password' => 'k4t2RjNwC4N8t8Bi9Tc5',
        'database' => 'RpgOnline',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];

    /**
     * The website admin database connection.
     *
     * @var array
     */
    public $admin = [
        'DSN'      => 'mysql:host=localhost;dbname=RpgOnline;charset=utf8',
        'hostname' => 'localhost',
        'username' => 'adminRpg',
        'password' => 'UzFx5pq4T6xZp7A9Z5t7',
        'database' => 'RpgOnline',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];

    /**
     * This database connection is used when
     * running PHPUnit database tests.
     *
     * @var array
     */
    public $tests = [
        'DSN'      => 'mysql:host=localhost;dbname=RpgOnline;charset=utf8',
        'hostname' => 'localhost',
        'username' => 'authRpg',
        'password' => 'k4t2RjNwC4N8t8Bi9Tc5',
        'database' => 'RpgOnline',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];

    public function __construct()
    {
        parent::__construct();

        // Ensure that we always set the database group to 'tests' if
        // we are currently running an automated test suite, so that
        // we don't overwrite live data on accident.
        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}
