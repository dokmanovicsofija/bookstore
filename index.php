<?php
require_once 'autoload.php';

$sessionManager = SessionManager::getInstance(); //dodala instancu
$authorRepository = new AuthorRepositorySession();
$authorService = new AuthorService($authorRepository);
$authorController = new AuthorController($authorService);

$url = isset($_GET['url']) ? $_GET['url'] : 'authors';
$urlParts = explode('/', $url);
$page = $urlParts[0];
$id = isset($urlParts[1]) ? $urlParts[1] : null;

//$bookRepository = new BookRepositorySession();
//$bookService = new BookService($bookRepository);
//$bookController = new BookController($bookService);

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$baseUri = strtok($requestUri, '?');

//session_start();
//session_unset();
//session_destroy();
//session_start();

switch ($baseUri) {
    case '/':
        $authorController->index();
        break;
    case '/createAuthor':
        if ($requestMethod == 'POST') {
            $authorController->store();
        } else {
            $authorController->create();
        }
        break;
    case '/editAuthor':
        if (isset($_GET['id'])) {
            if ($requestMethod == 'POST') {
                $authorController->update($_GET['id']);
            } else {
                $authorController->edit($_GET['id']);
            }
        } else {
            header("Location: /");
        }
        break;
    case '/deleteAuthor':
        if (isset($_GET['id'])) {
            $authorController->delete($_GET['id']);
        } else {
            header("Location: /authors.php");
        }
        break;
    default:
        http_response_code(404);
        echo "Page not found";
        break;

//    // Routes for books
//    case '/books':
//        $bookController->index();
//        break;
//    case '/create-book':
//        if ($requestMethod == 'POST') {
//            $bookController->store();
//        } else {
//            $bookController->create();
//        }
//        break;
//    case '/edit-book':
//        if (isset($_GET['id'])) {
//            if ($requestMethod == 'POST') {
//                $bookController->update($_GET['id']);
//            } else {
//                $bookController->edit($_GET['id']);
//            }
//        } else {
//            header("Location: /books");
//        }
//        break;
//    case '/delete-book':
//        if (isset($_GET['id'])) {
//            $bookController->delete($_GET['id']);
//        } else {
//            header("Location: /books");
//        }
//        break;
//    default:
//        http_response_code(404);
//        echo "Page not found";
//        break;
}
