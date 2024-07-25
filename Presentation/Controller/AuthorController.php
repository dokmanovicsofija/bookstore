<?php

require_once 'autoload.php';

/**
 * Class AuthorController
 *
 * This class handles the HTTP requests related to authors and interacts with the AuthorService.
 */
class AuthorController
{
    /**
     * @var AuthorServiceInterface The service for handling author-related operations.
     */
    private AuthorServiceInterface $authorService;

    /**
     * AuthorController constructor.
     *
     * @param AuthorServiceInterface $authorService The service for handling author-related operations.
     */
    public function __construct(AuthorServiceInterface $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * Displays the list of all authors.
     *
     * @return void
     */
    public function index(): void
    {
        $authors = $this->authorService->getAllAuthors();
//        $new =[];
//        foreach ($authors as $author) {
//            $new[] = $author->toArray();
//        }
        require './Presentation/Views/authors.php';
    }

    /**
     * Displays the form for creating a new author.
     *
     * @return void
     */
    public function create(): void
    {
        require './Presentation/Views/createAuthor.php';
    }

    /**
     * Handles the form submission for creating a new author.
     *
     * Validates the input data and creates a new author if validation is successful.
     *
     * @return void
     */
    public function store(): void
    {
        $firstName = $lastName = "";
        $firstNameError = $lastNameError = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["first_name"])) {
                $firstNameError = "* This field is required";
            }

            if (strlen($_POST["first_name"]) > 100) {
                $firstNameError = "* Maximum length is 100 characters";
            }

            if (empty($firstNameError)) {
                $firstName = htmlspecialchars($_POST["first_name"]);
            }

            if (empty($_POST["last_name"])) {
                $lastNameError = "* This field is required";
            }

            if (strlen($_POST["last_name"]) > 100) {
                $lastNameError = "* Maximum length is 100 characters";
            }

            if (empty($lastNameError)) {
                $lastName = htmlspecialchars($_POST["last_name"]);
            }

            if (empty($firstNameError) && empty($lastNameError)) {
                $this->authorService->createAuthor($firstName, $lastName);
                header('Location: /');
                exit();
            }
        }

        require './Presentation/Views/createAuthor.php';
    }

    /**
     * Displays the form for editing an existing author.
     *
     * @param int $id The ID of the author to edit.
     * @return void
     */
    public function edit(int $id): void
    {
        $author = $this->authorService->getAuthorById($id);
        if (!$author) {
            header("Location: /");
            exit();
        }

        include __DIR__ . '/../Views/editAuthor.php';
    }

    /**
     * Handles the form submission for updating an existing author.
     *
     * Validates the input data and updates the author if validation is successful.
     *
     * @param int $id The ID of the author to update.
     * @return void
     */
    public function update(int $id): void
    {
        $firstNameError = $lastNameError = "";
        $firstName = $_POST['first_name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        $author = new Author($id, $firstName, $lastName);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($firstName)) {
                $firstNameError = "* This field is required";
            }

            if (strlen($firstName) > 100) {
                $firstNameError = "* Maximum length is 100 characters";
            }

            if (empty($firstNameError)) {
                $firstName = htmlspecialchars($firstName);
            }

            if (empty($lastName)) {
                $lastNameError = "* This field is required";
            }

            if (strlen($lastName) > 100) {
                $lastNameError = "* Maximum length is 100 characters";
            }

            if (empty($lastNameError)) {
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

    /**
     * Handles the deletion of an author.
     *
     * If the request is a POST request, the author is deleted. Otherwise, it displays the deletion confirmation page.
     *
     * @param int $id The ID of the author to delete.
     * @return void
     */
    public function delete(int $id): void
    {
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