<?php

namespace src\Presentation\Controller;

use src\Business\Interfaces\BookServiceInterface;
use src\Business\Services\BookService;
use src\Infrastructure\Http\HttpRequest;
use src\Infrastructure\Http\HttpResponse;

/**
 * Class BookController
 *
 * This controller handles requests related to books, including creating, updating, deleting,
 * and retrieving book information.
 */
class BookController
{
    /**
     * BookController constructor.
     *
     * @param BookService $bookService The service instance to be used by the controller.
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
     */

    public function showBooksByAuthor(HttpRequest $request, int $authorId): HttpResponse
    {
        ob_start();
        include __DIR__ . '/../Views/authorBooks.php';
        $content = ob_get_clean();
        return new HttpResponse(200, $content);
    }

    public function getBooksByAuthor($request, $authorId) {
        $books = $this->bookService->getBooksByAuthorId($authorId);
        $bookList = [];
        foreach ($books as $book) {
            $bookList[] = [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'year' => $book->getYear()
            ];
        }

        return $this->jsonResponse(['books' => $bookList]);
    }

    public function addBook(HttpRequest $request, int $authorId): HttpResponse
    {
        $data = json_decode($request->getBody(), true);
        if (empty($data['title'])) {
            return $this->jsonResponse(['error' => 'Book title cannot be empty.'], 400);
        }
        $title = $data['title'];
        $year = (int) $data['year'];
        if ($year <= 0) {
            return $this->jsonResponse(['error' => 'Please enter a valid year.'], 400);
        }
        $book = $this->bookService->createBook($title, $year, $authorId);
        $bookArray = $book->toArray();
        return $this->jsonResponse($bookArray, 201);
    }

    public function deleteBook(HttpRequest $request, int $bookId): HttpResponse
    {
        $this->bookService->deleteBook($bookId);
        return $this->jsonResponse('', 204);
    }

    private function jsonResponse($data, int $statusCode = 200): HttpResponse {
        $jsonResponse = json_encode($data);
        error_log('JSON Response: ' . $jsonResponse);

        header('Content-Type: application/json');
        return new HttpResponse($statusCode, $jsonResponse);
    }

}
