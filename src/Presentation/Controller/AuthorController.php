<?php

namespace src\Presentation\Controller;

use Exception;
use src\Business\Interfaces\AuthorServiceInterface;
use src\Infrastructure\Request\HttpRequest;
use src\Infrastructure\Response\HtmlResponse;
use src\Presentation\Models\Author;

/**
 * Class AuthorController
 *
 * This class handles the HTTP requests related to authors and interacts with the AuthorService.
 */
class AuthorController
{
    /**
     * AuthorController constructor.
     *
     * @param AuthorServiceInterface $authorService The service for handling author-related operations.
     */
    public function __construct(private AuthorServiceInterface $authorService) {}

    /**
     * Handles the request to display the list of authors.
     *
     * @param HttpRequest $request The HTTP request object.
     * @return HtmlResponse The HTTP response object containing the list of authors.
     * @throws Exception
     */
    public function index(HttpRequest $request): HtmlResponse
    {
        $authors = $this->authorService->getAllAuthors();
        foreach ($authors as $author) {
            $bookCount = $this->authorService->getBookCountByAuthorId($author->getId());
            $author->setBookCount($bookCount);
        }
        $response = new HtmlResponse(200);
        $response->setBodyFromFile(__DIR__ . '/../Views/authors.php', ['authors' => $authors]);
        return $response;
    }

    /**
     * Handles the request to display the author creation form.
     *
     * @param HttpRequest $request The HTTP request object.
     * @return HtmlResponse The HTTP response object containing the author creation form.
     * @throws Exception
     */
    public function create(HttpRequest $request): HtmlResponse
    {
        $response = new HtmlResponse(200);
        $response->setBodyFromFile(__DIR__ . '/../Views/createAuthor.php');
        return $response;
    }

    /**
     * Handles the request to store a new author.
     *
     * @param HttpRequest $request The HTTP request object containing the author data.
     * @return HtmlResponse The HTTP response object redirecting to the authors list or displaying validation errors.
     * @throws Exception
     */
    public function store(HttpRequest $request): HtmlResponse
    {
        $firstNameError = $lastNameError = "";
        $firstName = $this->validateField($request->post('first_name', ''), 100, $firstNameError);
        $lastName = $this->validateField($request->post('last_name', ''), 100, $lastNameError);

        if (empty($firstNameError) && empty($lastNameError)) {
            $this->authorService->createAuthor($firstName, $lastName);
            return new HtmlResponse(302, '', ['Location' => '/src']);
        }

        $response = new HtmlResponse(200);
        $response->setBodyFromFile(__DIR__ . '/../Views/createAuthor.php', ['firstNameError' => $firstNameError, 'lastNameError' => $lastNameError]);
        return $response;
    }

    /**
     * Handles the request to display the author edit form.
     *
     * @param HttpRequest $request The HTTP request object.
     * @param int $id The ID of the author to be edited.
     * @return HtmlResponse The HTTP response object containing the author edit form.
     * @throws Exception
     */
    public function edit(HttpRequest $request, int $id): HtmlResponse
    {
        $author = $this->authorService->getAuthorById($id);

        $response = new HtmlResponse(200);
        $response->setBodyFromFile(__DIR__ . '/../Views/editAuthor.php', ['author' => $author]);
        return $response;
    }

    /**
     * Handles the request to update an existing author.
     *
     * @param HttpRequest $request The HTTP request object containing the updated author data.
     * @param int $id The ID of the author to be updated.
     * @return HtmlResponse The HTTP response object redirecting to the authors list or displaying validation errors.
     * @throws Exception
     */
    public function update(HttpRequest $request, int $id): HtmlResponse
    {
        $firstNameError = $lastNameError = "";
        $firstName = $this->validateField($request->post('first_name', ''), 100, $firstNameError);
        $lastName = $this->validateField($request->post('last_name', ''), 100, $lastNameError);
        $author = new Author($id, $firstName, $lastName);

        if ($request->getMethod() === 'POST') {
            if (empty($firstNameError) && empty($lastNameError)) {
                $this->authorService->updateAuthor($id, $firstName, $lastName);
                return new HtmlResponse(302, '', ['Location' => '/src']);
            }
        }

        $response = new HtmlResponse(200);
        $response->setBodyFromFile(__DIR__ . '/../Views/editAuthor.php', ['author' => $author, 'firstNameError' => $firstNameError, 'lastNameError' => $lastNameError]);
        return $response;
    }

    /**
     * Handles the request to delete an author.
     *
     * If the request method is POST, the author is deleted using the provided ID,
     * and the user is redirected to the authors list page.
     * If the request method is not POST, the delete author form is displayed.
     *
     * @param HttpRequest $request The HTTP request object containing the request data.
     * @param int $id The ID of the author to be deleted.
     * @return HtmlResponse The HTTP response object, either redirecting after deletion or displaying the delete form.
     * @throws Exception
     */
    public function delete(HttpRequest $request, int $id): HtmlResponse
    {
        if ($request->getMethod() === 'POST') {
            try {
                $this->authorService->deleteAuthor($id);
                return new HtmlResponse(302, '', ['Location' => '/src']);
            } catch (Exception $e) {
                return new HtmlResponse(500, 'Internal Server Error');
            }
        }

        $author = $this->authorService->getAuthorById($id);

        $response = new HtmlResponse(200);
        $response->setBodyFromFile(__DIR__ . '/../Views/deleteAuthor.php', ['author' => $author]);
        return $response;
    }

    /**
     * Validates a field based on length and emptiness criteria.
     *
     * Checks if the field is empty or exceeds the maximum length allowed.
     * If there are validation issues, sets the corresponding error message.
     * Otherwise, sanitizes the field value.
     *
     * @param string $field The value of the field to validate.
     * @param int $maxLength The maximum allowed length for the field.
     * @param string &$error The error message to be set if validation fails.
     * @return string The sanitized field value if valid, or the original value if invalid.
     */
    private function validateField(string $field, int $maxLength, string &$error): string
    {
        if (empty($field)) {
            $error = "* This field is required";
        } elseif (strlen($field) > $maxLength) {
            $error = "* Maximum length is $maxLength characters";
        } else {
            $field = htmlspecialchars($field);
        }

        return $field;
    }
}