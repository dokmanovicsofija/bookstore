<?php

namespace Bookstore\Presentation\Controller;

use Bookstore\Presentation\Models\Book;
use Exception;
use Bookstore\Business\Interfaces\BookServiceInterface;
use Bookstore\Infrastructure\Request\HttpRequest;
use Bookstore\Infrastructure\Response\HtmlResponse;
use Bookstore\Infrastructure\Response\JsonResponse;
use InvalidArgumentException;

/**
 * Class BookController
 *
 * This controller handles requests related to books, including creating, updating, deleting,
 * and retrieving book information. It interacts with the BookService to perform these operations
 * and returns responses in the appropriate format.
 */
readonly class BookController
{
    /**
     * BookController constructor.
     *
     * @param BookServiceInterface $bookService The service instance to be used by the controller.
     * This service handles the business logic related to books.
     */
    public function __construct(private BookServiceInterface $bookService)
    {
    }

    /**
     * Displays the list of books associated with the specified author ID.
     *
     * This method retrieves all books from the book service that are linked to the given author ID.
     * It then generates the HTML content to display these books using the `authorBooks.php` view.
     *
     * @param HttpRequest $request The HTTP request object containing information about the current request.
     * @return HtmlResponse An HTTP response containing the HTML content for displaying the books.
     * The content is generated from the `authorBooks.php` view file.
     * @throws Exception
     */
    public function showBooksByAuthor(HttpRequest $request): HtmlResponse
    {
        $authorId = (int)$request->getQueryParams()['id'] ?? 0;
        return HtmlResponse::fromView(__DIR__ . '/../Views/authorBooks.php', ['authorId' => $authorId]);
    }

    /**
     * Retrieves a list of books by the given author ID and returns it as a JSON response.
     *
     * This method fetches books associated with the specified author ID from the book service
     * and formats them into a JSON response.
     *
     * @param HttpRequest $request The HTTP request object containing information about the current request.
     * @return JsonResponse A JSON response containing the list of books, each with an ID, title, and year.
     */
    public function getBooksByAuthor(HttpRequest $request): JsonResponse
    {
        $authorId = (int)$request->getQueryParams()['authorId'] ?? 0;
        $books = $this->bookService->getBooksByAuthorId($authorId);
        $bookList = array_map(fn($book) => $book->toArray(), $books);

        return new JsonResponse(['books' => $bookList]);
    }

    /**
     * Adds a new book for the specified author ID and returns the created book as a JSON response.
     *
     * This method parses the JSON data from the request body, validates it, and then creates
     * a new book using the book service. If the input data is invalid, it returns an error response.
     *
     * @param HttpRequest $request The HTTP request object containing the JSON data for the new book.
     * @return JsonResponse A JSON response containing the created book's details or an error message.
     */
    public function addBook(HttpRequest $request): JsonResponse
    {
        $authorId = (int)$request->getQueryParams()['authorId'] ?? 0;
        $data = $request->getParsedBody();
        $title = $data['title'] ?? '';
        $year = isset($data['year']) ? (int)$data['year'] : 0;
        try {
            $book = new Book(0, $title, $year, $authorId);
            $this->bookService->createBook($book->getTitle(), $book->getYear(), $book->getAuthorId());
            return new JsonResponse($book->toArray(), 201);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Deletes a book by its ID and returns a JSON response indicating success.
     *
     * This method deletes the specified book using the book service and returns a response
     * with a status code indicating that the deletion was successful. The response body is empty
     * as per the `204 No Content` status code convention.
     *
     * @param HttpRequest $request The HTTP request object. (Not used in this method, but included for consistency.)
     * @return JsonResponse A JSON response with an empty body and a 204 No Content status code.
     */
    public function deleteBook(HttpRequest $request): JsonResponse
    {
        $bookId = (int)$request->getQueryParams()['bookId'];
        $this->bookService->deleteBook($bookId);

        return new JsonResponse([], 204);
    }
}
