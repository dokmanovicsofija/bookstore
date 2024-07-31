<?php

namespace src\Presentation\Controller;

use src\Business\Interfaces\BookServiceInterface;
use src\Business\Services\BookService;
use src\Infrastructure\Request\HttpRequest;
use src\Infrastructure\Response\HttpResponse;
use src\Infrastructure\Response\JsonResponse;

/**
 * Class BookController
 *
 * This controller handles requests related to books, including creating, updating, deleting,
 * and retrieving book information. It interacts with the BookService to perform these operations
 * and returns responses in the appropriate format.
 */
class BookController
{
    /**
     * BookController constructor.
     *
     * @param BookServiceInterface $bookService The service instance to be used by the controller.
     * This service handles the business logic related to books.
     */
    public function __construct(private BookServiceInterface $bookService) {}

    /**
     * Displays the list of books associated with the specified author ID.
     *
     * This method retrieves all books from the book service that are linked to the given author ID.
     * It then generates the HTML content to display these books using the `authorBooks.php` view.
     *
     * @param HttpRequest $request The HTTP request object containing information about the current request.
     * @param int $authorId The ID of the author whose books are to be displayed.
     * @return HttpResponse An HTTP response containing the HTML content for displaying the books.
     * The content is generated from the `authorBooks.php` view file.
     */
    public function showBooksByAuthor(HttpRequest $request, int $authorId): HttpResponse
    {
        ob_start();
        include __DIR__ . '/../Views/authorBooks.php';
        $content = ob_get_clean();
        return new HttpResponse(200, $content);
    }

    /**
     * Retrieves a list of books by the given author ID and returns it as a JSON response.
     *
     * This method fetches books associated with the specified author ID from the book service
     * and formats them into a JSON response.
     *
     * @param HttpRequest $request The HTTP request object containing information about the current request.
     * @param int $authorId The ID of the author whose books are to be retrieved.
     * @return JsonResponse A JSON response containing the list of books, each with an ID, title, and year.
     */
    public function getBooksByAuthor(HttpRequest $request, int $authorId): JsonResponse
    {
        $books = $this->bookService->getBooksByAuthorId($authorId);
        $bookList = [];
        foreach ($books as $book) {
            $bookList[] = [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'year' => $book->getYear()
            ];
        }

        return new JsonResponse(['books' => $bookList]);
    }

    /**
     * Adds a new book for the specified author ID and returns the created book as a JSON response.
     *
     * This method parses the JSON data from the request body, validates it, and then creates
     * a new book using the book service. If the input data is invalid, it returns an error response.
     *
     * @param HttpRequest $request The HTTP request object containing the JSON data for the new book.
     * @param int $authorId The ID of the author to whom the book will be associated.
     * @return JsonResponse A JSON response containing the created book's details or an error message.
     */
    public function addBook(HttpRequest $request, int $authorId): JsonResponse
    {
        $data = json_decode($request->getBody(), true);
        if (empty($data['title'])) {
            return new JsonResponse(['error' => 'Book title cannot be empty.'], 400);
        }
        $title = $data['title'];
        $year = (int) $data['year'];
        if ($year <= 0) {
            return new JsonResponse(['error' => 'Please enter a valid year.'], 400);
        }
        $book = $this->bookService->createBook($title, $year, $authorId);
        $bookArray = $book->toArray();

        return new JsonResponse($bookArray, 201);
    }

    /**
     * Deletes a book by its ID and returns a JSON response indicating success.
     *
     * This method deletes the specified book using the book service and returns a response
     * with a status code indicating that the deletion was successful. The response body is empty
     * as per the `204 No Content` status code convention.
     *
     * @param HttpRequest $request The HTTP request object. (Not used in this method, but included for consistency.)
     * @param int $bookId The ID of the book to be deleted.
     * @return JsonResponse A JSON response with an empty body and a 204 No Content status code.
     */
    public function deleteBook(HttpRequest $request, int $bookId): JsonResponse
    {
        $this->bookService->deleteBook($bookId);

        return new JsonResponse([], 204);
    }

}
