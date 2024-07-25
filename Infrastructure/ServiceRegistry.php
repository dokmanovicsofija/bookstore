<?php

namespace Infrastructure;

class ServiceRegistry
{
    private static array $services = [];

    /**
     * Registers a service in the registry.
     *
     * @param string $key The key under which the service is registered.
     * @param mixed $service The service instance.
     *
     * @return void
     */
    public static function register(string $key, $service): void
    {
        self::$services[$key] = $service;
    }

    /**
     * Retrieves a registered service.
     *
     * @param string $key The key of the service to retrieve.
     *
     * @return mixed
     *
     * @throws \Exception If the service is not found.
     */
    public static function get(string $key)
    {
        if (!isset(self::$services[$key])) {
            throw new \Exception("Service not found: " . $key);
        }
        return self::$services[$key];
    }
}

