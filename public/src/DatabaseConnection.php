<?php

final class DatabaseConnection
{
    private static DatabaseConnection|null $instance = null;
    private static PDO $connection;

    public static function getInstance(): DatabaseConnection
    {
        if (is_null(self::$instance)) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    private function __construct() {}

    private function __clone() {}

    public function __wakeup() {}

    public static function connect($host, $dbName, $user, $password): void
    {
        self::$connection = new PDO("mysql:dbname=$dbName;host=$host", $user, $password);
    }

    public static function getConnection(): PDO
    {
        return self::$connection;
    }
}