<?php
/**
 * Autoload required classes and initialize application components.
 */
require_once __DIR__ . '/../vendor/autoload.php';

use Bookstore\Infrastructure\Bootstrap;
use Bookstore\Infrastructure\Request\HttpRequest;
use Bookstore\Infrastructure\Response\HtmlResponse;
use Bookstore\Infrastructure\ServiceRegistry;
use Bookstore\Presentation\Controller\AuthorController;
use Bookstore\Presentation\Controller\BookController;

Bootstrap::init();

//session_start();
//session_unset();
//session_destroy();
//session_start();

$request = new HttpRequest();
$response = new HtmlResponse();

$authorController = ServiceRegistry::get(AuthorController::class);
$bookController = ServiceRegistry::get(BookController::class);

$baseUri = str_replace('/src', '', $request->getUri());

switch ($baseUri) {
    case '/':
        $response = $authorController->index($request);
        break;
    case '/createAuthor':
        if ($request->getMethod() == 'POST') {
            $response = $authorController->store($request);
            break;
        }

        $response = $authorController->create($request);
        break;
    case '/editAuthor':
        if ($request->getMethod() == 'POST') {
            $response = $authorController->update($request);
            break;
        }

        $response = $authorController->edit($request);
        break;
    case '/deleteAuthor':
        $response = $authorController->delete($request);
        break;
    case '/authorBooks':
        $response = $bookController->showBooksByAuthor($request);
        break;
    case '/books':
        if ($request->getMethod() === 'GET') {
            $response = $bookController->getBooksByAuthor($request);
            break;
        }

        if ($request->getMethod() === 'POST') {
            $response = $bookController->addBook($request);
            break;
        }

        break;
    case '/books/delete':
        if ($request->getMethod() === 'DELETE') {
            $response = $bookController->deleteBook($request);
        }

        break;
    default:
        $response = new HtmlResponse(404, [], 'Page not found');
        break;
}

$response->send();
