<?php
/**
 * Autoload required classes and initialize application components.
 */
require_once __DIR__ . '/../vendor/autoload.php';

use src\Infrastructure\Bootstrap;
use src\Infrastructure\ServiceRegistry;
use src\Presentation\Controller\AuthorController;
use src\Presentation\Controller\BookController;
use src\Infrastructure\Http\HttpRequest;
use src\Infrastructure\Http\HttpResponse;

Bootstrap::init();

$request = new HttpRequest();
$response = new HttpResponse();

$authorController = ServiceRegistry::get(AuthorController::class);
$bookController = ServiceRegistry::get(BookController::class);

$baseUri = str_replace('/src', '', $request->getUri());

//session_start();
//session_unset();
//session_destroy();
//session_start();

switch ($baseUri)
{
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
        $id = (int) $request->getQueryParams()['id'] ?? 0;
        if ($request->getMethod() == 'POST') {
            $response = $authorController->update($request, $id);
            break;
        }

        $response = $authorController->edit($request, $id);
        break;
    case '/deleteAuthor':
        $id = (int) $request->getQueryParams()['id'] ?? 0;
        $response = $authorController->delete($request, $id);
        break;
    case '/authorBooks':
        $id = (int) $request->getQueryParams()['id'] ?? 0;
        $response = $bookController->showBooksByAuthor($request, $id);
        break;
    default:
        $response = new HttpResponse(404, 'Page not found');
        break;
}

$response -> send();
