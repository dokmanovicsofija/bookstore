<?php

namespace src\Infrastructure\Utility;

/**
 * Abstract SingletonAbstract class.
 *
 * Provides the base implementation for the Singleton design pattern.
 */
abstract class SingletonAbstract
{
    /**
     * @var static|null The single instance of the class.
     */
    private static ?self $instance = null;

    /**
     * Prevents direct object creation.
     *
     * The constructor is protected to ensure that instances cannot be created directly from outside the class.
     */
    protected function __construct(){}

    /**
     * Returns the single instance of the class.
     *
     * This method ensures that only one instance of the class is created and provides access to that instance.
     *
     * @return static The single instance of the class.
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * Prevents cloning of the object.
     *
     * This method is private to prevent cloning of the singleton instance.
     */
    private function __clone(){}

    /**
     * Prevents unserialization of the object.
     *
     * This method is private to prevent unserialization of the singleton instance.
     */
    public function __wakeup(){}
}
