<?php

namespace src\Infrastructure;

use src\Business\Services\AuthorService;
use src\Business\Services\BookService;
use src\Data\Repositories\SQL\SQLAuthorRepository;
use src\Data\Repositories\SQL\SQLBookRepository;
use src\Presentation\Controller\AuthorController;
use src\Presentation\Controller\BookController;

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
     */
    public static function init(): void
    {
//        $sessionManager = SessionManager::getInstance();
//        ServiceRegistry::register(SessionManager::class, $sessionManager);

        $authorRepository = new SQLAuthorRepository();
        ServiceRegistry::register(SQLAuthorRepository::class, $authorRepository);

        $bookRepository = new SQLBookRepository();
        ServiceRegistry::register(SQLBookRepository::class, $bookRepository);

        $authorService = new AuthorService(ServiceRegistry::get(SQLAuthorRepository::class), ServiceRegistry::get(SQLBookRepository::class));
        ServiceRegistry::register(AuthorService::class, $authorService);

        $bookService = new BookService(ServiceRegistry::get(SQLBookRepository::class));
        ServiceRegistry::register(BookService::class, $bookService);

        $authorController = new AuthorController(ServiceRegistry::get(AuthorService::class));
        ServiceRegistry::register(AuthorController::class, $authorController);

        $bookController = new BookController(ServiceRegistry::get(BookService::class));
        ServiceRegistry::register(BookController::class, $bookController);
    }
}
