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
        $id = (int)$request->getQueryParams()['id'] ?? 0;
        if ($request->getMethod() == 'POST') {
            $response = $authorController->update($request, $id);
            break;
        }

        $response = $authorController->edit($request, $id);
        break;
    case '/deleteAuthor':
        $id = (int)$request->getQueryParams()['id'] ?? 0;
        $response = $authorController->delete($request, $id);
        break;
    case '/authorBooks':
        $id = (int)$request->getQueryParams()['id'] ?? 0;
        $response = $bookController->showBooksByAuthor($request, $id);
        break;
    case '/books':
        if ($request->getMethod() === 'GET') {
            $id = (int)$request->getQueryParams()['authorId'] ?? 0;
            $response = $bookController->getBooksByAuthor($request, $id);
            break;
        }

        if ($request->getMethod() === 'POST') {
            $id = (int)$request->getQueryParams()['authorId'] ?? 0;
            $response = $bookController->addBook($request, $id);
            break;
        }

        break;
    case '/books/delete':
        if ($request->getMethod() === 'DELETE') {
            $bookId = (int)$request->getQueryParams()['bookId'];
            $response = $bookController->deleteBook($request, $bookId);
        }

        break;
    default:
        $response = new HtmlResponse(404, 'Page not found');
        break;
}

$response->send();
