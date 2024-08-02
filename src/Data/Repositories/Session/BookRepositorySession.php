<?php

namespace Bookstore\Data\Repositories\Session;

use Bookstore\Business\Interfaces\BookRepositoryInterface;
use Bookstore\Infrastructure\SessionManager;
use Bookstore\Presentation\Models\Book;

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
     * BookRepositorySession constructor.
     *
     * Initializes the session and loads books from the session.
     */
    public function __construct()
    {
        $sessionManager = SessionManager::getInstance();
        $books = $sessionManager ->get('books');

        if (!$books) {
            $defaultBooks = [
                (new Book(1, 'Book Title 1', 2021, 1))->toArray(),
                (new Book(2, 'Book Title 2', 2020, 2))->toArray(),
                (new Book(3, 'Book Title 3', 2022, 1))->toArray(),
                (new Book(4, 'Book Title 4', 2023, 1))->toArray(),
            ];
            $sessionManager->set('books', $defaultBooks);
            $books = $defaultBooks;
        }

        $this->books = Book::fromBatch($books);
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
     * Counts the number of books by author ID.
     *
     * @param int $authorId The ID of the author whose books to count.
     * @return int The number of books for the given author.
     */
    public function countBooksByAuthorId(int $authorId): int
    {
        return count(array_filter($this->books, function ($book) use ($authorId) {
            return $book->getAuthorId() == $authorId;
        }));
    }

    /**
     * Retrieves books by author ID.
     *
     * @param int $authorId The ID of the author whose books to retrieve.
     * @return Book[] An array of Book objects.
     */
    public function getBooksByAuthorId(int $authorId): array
    {
        return array_filter($this->books, function ($book) use ($authorId) {
            return $book->getAuthorId() == $authorId;
        });
    }

    /**
     * Adds a new book to the collection.
     *
     * @param string $title The title of the book.
     * @param int $year The publication year of the book.
     * @param int $authorId The unique identifier of the author of the book.
     * @return Book The newly added Book object.
     */
    public function addBook(string $title, int $year, int $authorId): Book
    {
        $id = $this->getNextIdBook();
        $newBook = new Book($id, $title, $year, $authorId);
        $this->books[] = $newBook;
        $this->updateSessionBook();

        return $newBook;
    }

    /**
     * Deletes a book from the collection by its unique identifier.
     *
     * @param int $bookId The unique identifier of the book to be deleted.
     * @return void
     */
    public function deleteBook(int $bookId): void
    {
        $this->books = array_filter($this->books, function ($book) use ($bookId) {
            return $book->getId() != $bookId;
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

    /**
     * Gets the next available ID for a new book.
     *
     * This function calculates the next available ID by iterating through the existing books
     * and finding the highest current ID. It then returns the highest ID plus one, ensuring
     * that each new book will receive a unique ID.
     *
     * @return int The next available ID for a new book.
     */
    private function getNextIdBook(): int
    {
        $lastId = 0;

        foreach ($this->books as $book) {
            if ($book->getId() > $lastId) {
                $lastId = $book->getId();
            }
        }

        return $lastId + 1;
    }

    /**
     * Deletes all books associated with the specified author ID from the session.
     *
     * This method filters out books from the internal collection that have the
     * specified author ID. After removing the books, the session is updated
     * to reflect the changes. This ensures that any books linked to the author
     * being deleted are also removed, maintaining data consistency.
     *
     * @param int $authorId The ID of the author whose books are to be deleted.
     *
     * @return void
     */
    public function deleteBooksByAuthorId(int $authorId): void
    {
        $this->books = array_filter($this->books, function (Book $book) use ($authorId) {
            return $book->getAuthorId() !== $authorId;
        });

        SessionManager::getInstance() ->set('books', array_map(function (Book $book) {
            return $book->toArray();
        }, $this->books));
    }

    /**
     * Updates the session with the current list of books.
     *
     * @return void
     */
    private function updateSessionBook(): void
    {
        $booksArray = [];
        foreach ($this->books as $book) {
            $booksArray[] = $book->toArray();
        }

        SessionManager::getInstance()->set('books', $booksArray);
    }
}
