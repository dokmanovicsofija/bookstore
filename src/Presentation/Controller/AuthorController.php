<?php

namespace src\Presentation\Controller;

use src\Business\Interfaces\AuthorServiceInterface;
use src\Infrastructure\Http\HttpRequest;
use src\Infrastructure\Http\HttpResponse;
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
     * @return HttpResponse The HTTP response object containing the list of authors.
     */
    public function index(HttpRequest $request): HttpResponse
    {
        $authors = $this->authorService->getAllAuthors();
        foreach ($authors as $author) {
            $bookCount = $this->authorService->getBookCountByAuthorId($author->getId());
            $author->setBookCount($bookCount);
        }
        ob_start();
        include __DIR__ . '/../Views/authors.php';
        $content = ob_get_clean();
        return new HttpResponse(200, $content);
    }

    /**
     * Handles the request to display the author creation form.
     *
     * @param HttpRequest $request The HTTP request object.
     * @return HttpResponse The HTTP response object containing the author creation form.
     */
    public function create(HttpRequest $request): HttpResponse
    {
        ob_start();
        include __DIR__ . '/../Views/createAuthor.php';
        $content = ob_get_clean();
        return new HttpResponse(200, $content);
    }

    /**
     * Handles the request to store a new author.
     *
     * @param HttpRequest $request The HTTP request object containing the author data.
     * @return HttpResponse The HTTP response object redirecting to the authors list or displaying validation errors.
     */
    public function store(HttpRequest $request): HttpResponse
    {
        $firstNameError = $lastNameError = "";
        $firstName = $this->validateField($request->post('first_name', ''), 100, $firstNameError);
        $lastName = $this->validateField($request->post('last_name', ''), 100, $lastNameError);

        if (empty($firstNameError) && empty($lastNameError)) {
            $this->authorService->createAuthor($firstName, $lastName);
            return new HttpResponse(302, '', ['Location' => '/src']);
        }

        ob_start();
        include __DIR__ . '/../Views/createAuthor.php';
        $content = ob_get_clean();
        return new HttpResponse(200, $content);
    }

    /**
     * Handles the request to display the author edit form.
     *
     * @param HttpRequest $request The HTTP request object.
     * @param int $id The ID of the author to be edited.
     * @return HttpResponse The HTTP response object containing the author edit form.
     */
    public function edit(HttpRequest $request, int $id): HttpResponse
    {
        $author = $this->authorService->getAuthorById($id);

        ob_start();
        include __DIR__ . '/../Views/editAuthor.php';
        $content = ob_get_clean();
        return new HttpResponse(200, $content);
    }

    /**
     * Handles the request to update an existing author.
     *
     * @param HttpRequest $request The HTTP request object containing the updated author data.
     * @param int $id The ID of the author to be updated.
     * @return HttpResponse The HTTP response object redirecting to the authors list or displaying validation errors.
     */
    public function update(HttpRequest $request, int $id): HttpResponse
    {
        $firstNameError = $lastNameError = "";
        $firstName = $this->validateField($request->post('first_name', ''), 100, $firstNameError);
        $lastName = $this->validateField($request->post('last_name', ''), 100, $lastNameError);
        $author = new Author($id, $firstName, $lastName);

        if ($request->getMethod() === 'POST') {
            if (empty($firstNameError) && empty($lastNameError)) {
                $this->authorService->updateAuthor($id, $firstName, $lastName);
                return new HttpResponse(302, '', ['Location' => '/src']);
            }
        }

        ob_start();
        include __DIR__ . '/../Views/editAuthor.php';
        $content = ob_get_clean();
        return new HttpResponse(200, $content);
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
     * @return HttpResponse The HTTP response object, either redirecting after deletion or displaying the delete form.
     */
    public function delete(HttpRequest $request, int $id): HttpResponse
    {
        if ($request->getMethod() === 'POST') {
            $this->authorService->deleteAuthor($id);
            return new HttpResponse(302, '', ['Location' => '/src']);
        }

        $author = $this->authorService->getAuthorById($id);

        ob_start();
        include __DIR__ . '/../Views/deleteAuthor.php';
        $content = ob_get_clean();
        return new HttpResponse(200, $content);
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