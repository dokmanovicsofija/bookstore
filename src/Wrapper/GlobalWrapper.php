<?php

namespace src\Wrapper;

use src\Infrastructure\SingletonAbstract;

/**
 * Class GlobalWrapper
 *
 * A wrapper class that provides access to and manipulation of global variables such as $_SESSION, $_GET, and $_POST
 * through a unified interface. This class allows interacting with different global variables based on the type provided
 * during instantiation. It supports setting, getting, removing values, and destroying the session.
 */
class GlobalWrapper extends  SingletonAbstract
{
    /**
     * @var array An array of instances for each type.
     */
    private static array $instances = [];

    /**
     * @var string The type of global variable to use ('session', 'get', or 'post').
     */
    private string $type;

    /**
     * GlobalWrapper constructor.
     *
     * @param string $type The type of global variable ('session', 'get', 'post', 'server').
     */
    private function __construct(string $type)
    {
        parent::__construct();
        $this->type = $type;
    }

    /**
     * Gets the single instance of the GlobalWrapper class for the given type.
     *
     * @param string $type The type of global variable ('session', 'get', 'post', 'server').
     * @return GlobalWrapper The single instance of the GlobalWrapper class.
     */
    public static function getInstanceForType(string $type): self
    {
        if (!isset(self::$instances[$type])) {
            self::$instances[$type] = new self($type);
        }

        return self::$instances[$type];
    }

    /**
     * Sets a value in the global variable.
     *
     * @param string $key The key under which the value will be stored.
     * @param mixed $value The value to store.
     */
    public function set(string $key, $value): void
    {
        switch ($this->type) {
            case 'session':
                $_SESSION[$key] = $value;
                break;
            case 'server':
                $_SERVER[$key] = $value;
                break;
            case 'get':
                $_GET[$key] = $value;
                break;
            case 'post':
                $_POST[$key] = $value;
                break;
            default:
                throw new \InvalidArgumentException('Invalid global type');
        }
    }

    /**
     * Gets a value from the global variable.
     *
     * @param string $key The key to retrieve.
     * @param mixed $default Default value if the key is not found.
     * @return mixed The value of the key or default value if not found.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        switch ($this->type) {
            case 'session':
                return $_SESSION[$key] ?? $default;
            case 'server':
                return $_SERVER[$key] ?? $default;
            case 'get':
                return $_GET[$key] ?? $default;
            case 'post':
                return $_POST[$key] ?? $default;
            default:
                throw new \InvalidArgumentException('Invalid global type');
        }
    }

    /**
     * Removes a value from the global variable.
     *
     * @param string $key The key to remove.
     */
    public function remove(string $key): void
    {
        switch ($this->type) {
            case 'session':
                unset($_SESSION[$key]);
                break;
            case 'server':
                unset($_SERVER[$key]);
                break;
            case 'get':
                unset($_GET[$key]);
                break;
            case 'post':
                unset($_POST[$key]);
                break;
            default:
                throw new \InvalidArgumentException('Invalid global type');
        }
    }

    /**
     * Destroys the session.
     */
    public function destroySession(): void
    {
        if ($this->type === 'SESSION') {
            session_destroy();
            $_SESSION = [];
        } else {
            throw new \InvalidArgumentException('Destroy session can only be called for session type');
        }
    }

    /**
     * Gets all values from the global variable.
     *
     * @return array All values of the global variable.
     */
    public function getAll(): array
    {
        switch ($this->type) {
            case 'session':
                return $_SESSION;
            case 'server':
                return $_SERVER;
            case 'get':
                return $_GET;
            case 'post':
                return $_POST;
            default:
                throw new \InvalidArgumentException('Invalid global type');
        }
    }
}
