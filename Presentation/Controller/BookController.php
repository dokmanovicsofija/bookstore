<?php

/**
 * Class BookController
 *
 * This controller handles requests related to books, including creating, updating, deleting,
 * and retrieving book information.
 */
class BookController
{
    /**
     * @var BookService The service instance for managing books.
     */
    private BookService $bookService;

    /**
     * BookController constructor.
     *
     * @param BookService $bookService The service instance to be used by the controller.
     */
    public function __construct(BookServiceInterface $bookService)
    {
        $this->bookService = $bookService;
    }

    public function showBooksByAuthor(int $authorId): void
    {
        $books = $this->bookService->getBooksByAuthorId($authorId);
        require './Presentation/Views/authorBooks.php';
    }

    /**
     * Displays the list of books.
     */
    public function index(): void {
        $books = $this->bookService->getAllBooks();
        require './Presentation/Views/books.php';
    }

    public function show(int $id): void {
        $book = $this->bookService->getBookById($id);
        require './Presentation/Views/book.php';
    }

//    public function create(): void
//    {
//        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//            $title = $_POST['title'] ?? '';
//            $year = $_POST['year'] ?? '';
//            $authorId = $_POST['authorId'] ?? '';
//
//            if ($title && $year && $authorId) {
//                $book = new Book(null, $title, $year, $authorId);
//                $this->bookService->createBook($book);
//                header('Location: /books');
//                exit;
//            }
//        }
//        require './Presentation/Views/createBook.php';
//    }
    /**
     * Handles the form submission to create a new book.
     */
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $year = (int)($_POST['year'] ?? 0);
            $authorId = (int)($_POST['authorId'] ?? 0);

            if ($title !== '' && $year > 0 && $authorId > 0) {
                $newBook = $this->bookService->createBook($title, $year, $authorId);
                header('Location: /bookList.php'); // Redirekcija na listu knjiga
                exit();
            }

            // Ako dođe ovde, podaci nisu validni
            $error = 'All fields are required and must be valid.';
            include 'views/createBook.php'; // Ponovo prikazujemo formu sa greškom
        }
    }


    public function edit(int $id): void {
        $book = $this->bookService->getBookById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $year = $_POST['year'] ?? '';
            $authorId = $_POST['authorId'] ?? '';

            if ($title && $year && $authorId) {
                $book->setTitle($title);
                $book->setYear($year);
                $book->setAuthorId($authorId);
                $this->bookService->updateBook($book);
                header('Location: /books');
                exit;
            }
        }

        require './Presentation/Views/editBook.php';
    }

    public function delete(int $id): void {
        $this->bookService->deleteBook($id);
        header('Location: /books');
        exit;
    }
}
