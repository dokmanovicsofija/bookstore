<?php

namespace Bookstore\Infrastructure;

use Bookstore\Business\Interfaces\AuthorRepositoryInterface;
use Bookstore\Business\Interfaces\AuthorServiceInterface;
use Bookstore\Business\Interfaces\BookRepositoryInterface;
use Bookstore\Business\Interfaces\BookServiceInterface;
use Bookstore\Business\Services\AuthorService;
use Bookstore\Business\Services\BookService;
use Bookstore\Data\Repositories\SQL\SQLAuthorRepository;
use Bookstore\Data\Repositories\SQL\SQLBookRepository;
use Bookstore\Presentation\Controller\AuthorController;
use Bookstore\Presentation\Controller\BookController;
use Dotenv\Dotenv;
use Exception;

class Bootstrap
{
    /**
     * Initializes the application by setting up and registering all necessary services, repositories, and controllers.
     *
     * This method performs the following tasks:
     * - Initializes the session manager and registers it with the service registry.
     * - Creates instances of repository classes and registers them with the service registry.
     * - Creates instances of service classes, injecting the appropriate repositories, and registers them with the service registry.
     * - Creates instances of controller classes, injecting the appropriate services, and registers them with the service registry.
     *
     * This setup ensures that all components are properly initialized and available for use throughout the application.
     *
     * @return void
     *
     * @throws Exception
     */
    public static function init(): void
    {
//        $dotenv = Dotenv::createUnsafeImmutable('/var/www/bookstore');
        $dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../../');
        $dotenv->load();

        self::registerRepos();
        self::registerServices();
        self::registerControllers();
    }

    /**
     * Registers repository instances with the service registry.
     *
     * @return void
     */
    protected static function registerRepos(): void
    {
        ServiceRegistry::register(AuthorRepositoryInterface::class, new SQLAuthorRepository());
        ServiceRegistry::register(BookRepositoryInterface::class, new SQLBookRepository());
    }

    /**
     * Registers service instances with the service registry.
     *
     * @return void
     *
     * @throws Exception
     */
    protected static function registerServices(): void
    {
        ServiceRegistry::register(AuthorServiceInterface::class, new AuthorService(
            ServiceRegistry::get(AuthorRepositoryInterface::class),
            ServiceRegistry::get(BookRepositoryInterface::class)
        ));
        ServiceRegistry::register(BookServiceInterface::class, new BookService(
            ServiceRegistry::get(BookRepositoryInterface::class)
        ));
    }

    /**
     * Registers controller instances with the service registry.
     *
     * @return void
     *
     * @throws Exception
     */
    protected static function registerControllers(): void
    {
        ServiceRegistry::register(AuthorController::class, new AuthorController(
            ServiceRegistry::get(AuthorServiceInterface::class)
        ));
        ServiceRegistry::register(BookController::class, new BookController(
            ServiceRegistry::get(BookServiceInterface::class)
        ));
    }
}
