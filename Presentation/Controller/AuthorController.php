<?php

require_once 'autoload.php';

class AuthorController {
    private $authorService;

    public function __construct($authorService) {
        $this->authorService = $authorService;
    }

    public function index(): void
    {
        $authors = $this->authorService->getAllAuthors();
//        $new =[];
//        foreach ($authors as $author) {
//            $new[] = $author->toArray();
//        }
        require './Presentation/Views/authors.php';
    }

    public function create(): void
    {
        require './Presentation/Views/createAuthor.php';
    }

    public function store() {
        $firstName = $lastName = "";
        $firstNameError = $lastNameError = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["first_name"])) {
                $firstNameError = "* This field is required";
            } elseif (strlen($_POST["first_name"]) > 100) {
                $firstNameError = "* Maximum length is 100 characters";
            } else {
                $firstName = htmlspecialchars($_POST["first_name"]);
            }

            if (empty($_POST["last_name"])) {
                $lastNameError = "* This field is required";
            } elseif (strlen($_POST["last_name"]) > 100) {
                $lastNameError = "* Maximum length is 100 characters";
            } else {
                $lastName = htmlspecialchars($_POST["last_name"]);
            }

            if (empty($firstNameError) && empty($lastNameError)) {
                $this->authorService->createAuthor($firstName, $lastName);
                header('Location: /');
                exit();
            }
        } else {
            $firstName = $lastName = "";
        }

        require './Presentation/Views/createAuthor.php';
    }

    public function edit($id) {
        $author = $this->authorService->getAuthorById($id);
        if (!$author) {
            header("Location: /");
            exit();
        }
        include __DIR__ . '/../Views/editAuthor.php';
    }

    public function update($id) {
        $firstNameError = $lastNameError = "";
        $firstName = $_POST['first_name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($firstName)) {
                $firstNameError = "* This field is required";
            } elseif (strlen($firstName) > 100) {
                $firstNameError = "* Maximum length is 100 characters";
            } else {
                $firstName = htmlspecialchars($firstName);
            }

            if (empty($lastName)) {
                $lastNameError = "* This field is required";
            } elseif (strlen($lastName) > 100) {
                $lastNameError = "* Maximum length is 100 characters";
            } else {
                $lastName = htmlspecialchars($lastName);
            }

            if (empty($firstNameError) && empty($lastNameError)) {
                $this->authorService->updateAuthor($id, $firstName, $lastName);
                header('Location: /');
                exit();
            }
        }

        require './Presentation/Views/editAuthor.php';
    }

    public function delete($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->authorService->deleteAuthor($id);
            header("Location: /");
            exit();
        }
        $author = $this->authorService->getAuthorById($id);
        if (!$author) {
            header("Location: /authors.php");
            exit();
        }
        include __DIR__ . '/../Views/deleteAuthor.php';
    }
}