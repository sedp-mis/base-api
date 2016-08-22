<?php

class PdoExec
{
    public $config = [
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'username'  => 'homestead',
        'password'  => 'secret',
    ];

    public function execute($sql)
    {
        $driver   = $this->config['driver'];
        $host     = $this->config['host'];
        $username = $this->config['username'];
        $password = $this->config['password'];

        $pdo = new PDO("{$driver}:host={$host}", "{$username}", "{$password}");
        $pdo->exec($sql);
    }
}