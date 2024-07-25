<?php

namespace Infrastructure;

use \SessionManager;
use \AuthorRepositorySession;
use \BookRepositorySession;
use \AuthorService;
use \BookService;
use \AuthorController;
use \BookController;

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
        $sessionManager = SessionManager::getInstance();
        ServiceRegistry::register('sessionManager', $sessionManager);

        $authorRepository = new AuthorRepositorySession();
        ServiceRegistry::register('authorRepository', $authorRepository);

        $bookRepository = new BookRepositorySession();
        ServiceRegistry::register('bookRepository', $bookRepository);

        $authorService = new AuthorService(ServiceRegistry::get('authorRepository'));
        ServiceRegistry::register('authorService', $authorService);

        $bookService = new BookService(ServiceRegistry::get('bookRepository'));
        ServiceRegistry::register('bookService', $bookService);

        $authorController = new AuthorController(ServiceRegistry::get('authorService'));
        ServiceRegistry::register('authorController', $authorController);

        $bookController = new BookController(ServiceRegistry::get('bookService'));
        ServiceRegistry::register('bookController', $bookController);
    }
}
