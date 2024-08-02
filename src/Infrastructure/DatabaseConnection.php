<?php

namespace Bookstore\Infrastructure;

use PDO;
use PDOException;

/**
 * Class DatabaseConnection
 *
 * Handles the connection to the database using PDO.
 */
class DatabaseConnection
{
    /**
     * @var PDO|null The PDO instance for database connection.
     */
    private static ?PDO $connectionInstance = null;

    /**
     * DatabaseConnection constructor.
     *
     * Private to prevent multiple instances.
     */
    private function __construct()
    {
    }

    /**
     * Gets the singleton instance of the database connection.
     *
     * @return PDO
     * @throws PDOException
     */
    public static function getInstance(): PDO
    {
        if (self::$connectionInstance === null) {
            self::connect();
        }

        return self::$connectionInstance;
    }

    /**
     * Establishes the database connection.
     *
     * @throws PDOException
     */
    private static function connect(): void
    {
        $host = getenv('DB_HOST');
        $db = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASS');
        $charset = getenv('DB_CHARSET');

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            self::$connectionInstance = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}
