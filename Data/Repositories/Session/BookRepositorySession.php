<?php

/**
 * Class BookRepositorySession
 *
 * This class implements the BookRepositoryInterface and manages books in a session.
 */
class BookRepositorySession implements BookRepositoryInterface
{
    /**
     * @var Book[] An array of Book objects.
     */
    private array $books;

    /**
     * @var SessionManager The session manager instance.
     */
    private SessionManager $session;

    /**
     * BookRepositorySession constructor.
     *
     * Initializes the session and loads books from the session.
     */
    public function __construct()
    {

        $this->session = SessionManager::getInstance();
        $books = $this->session->get('books');

        if (!isset($_SESSION['books'])) {
            $_SESSION['books'] = [
                (new Book(1, 'Book Title 1', 2021, 1))->toArray(),
                (new Book(2, 'Book Title 2', 2020, 1))->toArray(),
                (new Book(3, 'Book Title 3', 2022, 1))->toArray(),
                (new Book(4, 'Book Title 4', 2023, 1))->toArray(),
            ];
            $books = $this->session->get('books');
            $this->session->set('books', $books);
        }

        $this->books = Book::fromBatch($this->session->get('books'));
    }

    /**
     * Retrieves all books.
     *
     * @return Book[] An array of Book objects.
     */
    public function getAll(): array
    {
        return $this->books;
    }

    /**
     * Retrieves a book by its ID.
     *
     * @param int $id The ID of the book to retrieve.
     * @return Book|null The Book object if found, or null if not found.
     */
    public function getById(int $id): ?Book
    {
        foreach ($this->books as $book) {
            if ($book->getId() == $id) {
                return $book;
            }
        }

        return null;
    }

    /**
     * Retrieves books by author ID.
     *
     * @param int $authorId The ID of the author whose books to retrieve.
     * @return Book[] An array of Book objects.
     */
    public function getByAuthorId(int $authorId): array
    {
        return array_filter($this->books, function($book) use ($authorId) {
            return $book->getAuthorId() == $authorId;
        });
    }

    /**
     * Creates a new book.
     *
     * @param string $title The title of the new book.
     * @param int $year The publication year of the new book.
     * @param int $authorId The ID of the author of the new book.
     * @return Book The created Book object.
     */
    public function create(string $title, int $year, int $authorId): Book
    {
        $id = $this->getNextId();
        $newBook = new Book($id, $title, $year, $authorId);
        $this->books[] = $newBook;
        $this->updateSession();

        return $newBook;
    }

    /**
     * Updates an existing book.
     *
     * @param Book $book The Book object with updated information.
     * @return void
     */
    public function update(Book $book): void
    {
        foreach ($this->books as $key => $existingBook) {
            if ($existingBook->getId() == $book->getId()) {
                $this->books[$key] = $book;
                $this->updateSession();
                return;
            }
        }
    }

    /**
     * Deletes a book by its ID.
     *
     * @param int $id The ID of the book to delete.
     * @return void
     */
    public function delete(int $id): void
    {
        $this->books = array_filter($this->books, function($book) use ($id) {
            return $book->getId() != $id;
        });

        $this->books = array_values($this->books);

        $this->updateSession();
    }

    /**
     * Updates the session with the current list of books.
     *
     * @return void
     */
    private function updateSession(): void
    {
        $_SESSION['books'] = [];
        foreach ($this->books as $book) {
            $_SESSION['books'][] = $book->toArray();
        }
    }

    /**
     * Gets the next available ID for a new book.
     *
     * This function calculates the next available ID by iterating through the existing books
     * and finding the highest current ID. It then returns the highest ID plus one, ensuring
     * that each new book will receive a unique ID.
     *
     * @return int The next available ID for a new book.
     */
    private function getNextId(): int
    {
        $lastId = 0;

        foreach ($this->books as $book) {
            if ($book->getId() > $lastId) {
                $lastId = $book->getId();
            }
        }

        return $lastId + 1;
    }
}
