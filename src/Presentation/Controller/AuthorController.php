<?php

namespace Bookstore\Presentation\Controller;

use Exception;
use Bookstore\Business\Interfaces\AuthorServiceInterface;
use Bookstore\Infrastructure\Request\HttpRequest;
use Bookstore\Infrastructure\Response\HtmlResponse;
use Bookstore\Presentation\Models\Author;

/**
 * Class AuthorController
 *
 * This class handles the HTTP requests related to authors and interacts with the AuthorService.
 */
readonly class AuthorController
{
    /**
     * AuthorController constructor.
     *
     * @param AuthorServiceInterface $authorService The service for handling author-related operations.
     */
    public function __construct(private AuthorServiceInterface $authorService)
    {
    }

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

        return HtmlResponse::fromView(__DIR__ . '/../Views/authors.php', ['authors' => $authors]);
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
        $firstNameError =  '';
        $lastNameError = '';
        $firstName = ''; $lastName = '';
        return HtmlResponse::fromView(__DIR__ . '/../Views/createAuthor.php', ['firstName' => $firstName, 'lastName'=> $lastName, 'firstNameError' => $firstNameError, 'lastNameError' => $lastNameError]);
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
        $firstName = $request->post('first_name', '');
        $lastName = $request->post('last_name', '');

        try {
            $author = new Author(0, $firstName, $lastName);
            $this->authorService->createAuthor($author->getFirstName(), $author->getLastName());
            return new HtmlResponse(302, ['Location' => '/src']);
        } catch (\InvalidArgumentException $e) {
            $errors = json_decode($e->getMessage(), true);
            $firstNameError = $errors['firstName'] ?? '';
            $lastNameError = $errors['lastName'] ?? '';

            return HtmlResponse::fromView(__DIR__ . '/../Views/createAuthor.php', [
                'firstName' => $firstName, 'lastName'=> $lastName,
                'firstNameError' => $firstNameError,
                'lastNameError' => $lastNameError
            ]);
        }
    }

    /**
     * Handles the request to display the author edit form.
     *
     * @param HttpRequest $request The HTTP request object.
     * @return HtmlResponse The HTTP response object containing the author edit form.
     * @throws Exception
     */
    public function edit(HttpRequest $request): HtmlResponse
    {
        $firstNameError =  '';
        $lastNameError = '';
        $id = (int)$request->getQueryParams()['id'] ?? 0;
        $author = $this->authorService->getAuthorById($id);

        return HtmlResponse::fromView(__DIR__ . '/../Views/editAuthor.php', ['author' => $author, 'firstNameError' => $firstNameError, 'lastNameError' => $lastNameError]);
    }

    /**
     * Handles the request to update an existing author.
     *
     * @param HttpRequest $request The HTTP request object containing the updated author data.
     * @return HtmlResponse The HTTP response object redirecting to the authors list or displaying validation errors.
     * @throws Exception
     */
    public function update(HttpRequest $request): HtmlResponse
    {
        $id = (int)$request->getQueryParams()['id'] ?? 0;
        $firstName = $request->post('first_name', '');
        $lastName = $request->post('last_name', '');

        try {
            $author = new Author($id, $firstName, $lastName);
            $this->authorService->updateAuthor($id, $author->getFirstName(), $author->getLastName());
            return new HtmlResponse(302, ['Location' => '/src']);
        } catch (\InvalidArgumentException $e) {
            $errors = json_decode($e->getMessage(), true);
            $firstNameError = $errors['firstName'] ?? '';
            $lastNameError = $errors['lastName'] ?? '';

            $author = $this->authorService->getAuthorById($id);

            return HtmlResponse::fromView(__DIR__ . '/../Views/editAuthor.php', [
                'author' => $author,
                'firstNameError' => $firstNameError,
                'lastNameError' => $lastNameError
            ]);
        }
    }

    /**
     * Handles the request to delete an author.
     *
     * If the request method is POST, the author is deleted using the provided ID,
     * and the user is redirected to the authors list page.
     * If the request method is not POST, the delete author form is displayed.
     *
     * @param HttpRequest $request The HTTP request object containing the request data.
     * @return HtmlResponse The HTTP response object, either redirecting after deletion or displaying the delete form.
     * @throws Exception
     */
    public function delete(HttpRequest $request): HtmlResponse
    {
        $id = (int)$request->getQueryParams()['id'] ?? 0;
        if ($request->getMethod() === 'POST') {
            try {
                $this->authorService->deleteAuthor($id);
                return new HtmlResponse(302, ['Location' => '/src']);
            } catch (Exception $e) {
                return new HtmlResponse(500, [], 'Internal Server Error');
            }
        }

        $author = $this->authorService->getAuthorById($id);

        return HtmlResponse::fromView(__DIR__ . '/../Views/deleteAuthor.php', ['author' => $author]);
    }
}