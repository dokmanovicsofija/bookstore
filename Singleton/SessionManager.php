<?php

/**
 * Class SessionManager
 *
 * A singleton class for managing PHP sessions.
 */
class SessionManager
{
    /**
     * @var SessionManager|null The single instance of SessionManager.
     */
    private static ?SessionManager $instance = null;

    /**
     * SessionManager constructor.
     *
     * Initializes the session if it is not already started.
     */
    private function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

    }

    /**
     * Gets the single instance of SessionManager.
     *
     * @return SessionManager|null The single instance of SessionManager.
     */
    public static function getInstance(): ?SessionManager
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Sets a session value.
     *
     * @param string $key The key of the session value.
     * @param mixed $value The value to be set in the session.
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Gets a session value.
     *
     * @param string $key The key of the session value.
     * @return mixed|null The session value, or null if the key does not exist.
     */
    public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * Removes a session value.
     *
     * @param string $key The key of the session value to be removed.
     * @return void
     */
    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Destroys the session and clears all session data.
     *
     * @return void
     */
    public function destroy(): void
    {
        session_destroy();
        $_SESSION = [];
    }
}
