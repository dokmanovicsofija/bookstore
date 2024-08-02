<?php

namespace Bookstore\Infrastructure;

use Bookstore\Infrastructure\Utility\GlobalWrapper;
use Bookstore\Infrastructure\Utility\SingletonAbstract;

/**
 * Class SessionManager
 *
 * A singleton class for managing PHP sessions.
 * This class ensures that there is only one instance of the session manager
 * and provides methods for managing session data.
 */
class SessionManager extends SingletonAbstract
{
    /**
     * @var static|null The single instance of the class.
     * Holds the single instance of the SessionManager class.
     */
    private static ?self $instance = null;

    /**
     * SessionManager constructor.
     *
     * Initializes the session if it is not already started.
     * The constructor is protected to prevent direct instantiation.
     */
    private function __construct()
    {
        parent::__construct();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        GlobalWrapper::getInstanceForType('session');
    }

    /**
     * Sets a session value.
     *
     * Stores a value in the session using the provided key.
     * The value is associated with the specified key and can be retrieved later
     * using the same key. The type of the value is not restricted and can be
     * any valid PHP data type.
     *
     * @param string $key The key under which the value will be stored in the session.
     *                    This key is used to identify and retrieve the stored value.
     * @param $value The value to be stored in the session. Can be any valid PHP data type.
     * @return void This method does not return any value.
     */
    public function set(string $key, $value): void
    {
        GlobalWrapper::getInstanceForType('session')->set($key, $value);
    }

    /**
     * Gets a session value.
     *
     * Retrieves a value from the session using the provided key.
     * Returns null if the key does not exist in the session.
     * The type of the returned value depends on what was stored in the session.
     *
     * @param string $key The key for which the value is retrieved.
     *                    This key identifies the value in the session.
     * @return The value stored in the session, or null if the key does not exist.
     *         The type of the returned value can vary depending on what was stored.
     */
    public function get(string $key): mixed
    {
        return GlobalWrapper::getInstanceForType('session')->get($key);
    }

    /**
     * Removes a session value.
     *
     * Deletes a value from the session using the provided key.
     *
     * @param string $key The key of the session value to be removed.
     * @return void
     */
    public function remove(string $key): void
    {
        GlobalWrapper::getInstanceForType('session')->remove($key);
    }

    /**
     * Destroys the session and clears all session data.
     *
     * Ends the current session and removes all session data.
     *
     * @return void
     */
    public function destroy(): void
    {
        GlobalWrapper::getInstanceForType('session')->destroySession();
    }
}
