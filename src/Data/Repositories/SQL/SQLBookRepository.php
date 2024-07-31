<?php

namespace src\Data\Repositories\SQL;

use src\Data\Repositories\Interfaces\BookRepositoryInterface;
use src\Infrastructure\DatabaseConnection;
use src\Presentation\Models\Book;
use PDO;

/**
 * Class SQLBookRepository
 *
 * Implementation of BookRepositoryInterface using SQL (PDO).
 */
class SQLBookRepository implements BookRepositoryInterface
{
    private PDO $connection;

    public function __construct()
    {
        // Get the PDO instance from the DatabaseConnection singleton
        $this->connection = DatabaseConnection::getInstance();
    }

    /**
     * Returns all books.
     *
     * @return Book[] An array of Book objects.
     */
    public function getAll(): array
    {
        $stmt = $this->connection->query("SELECT * FROM Book");
        $books = $stmt->fetchAll();
        return array_map(fn($book) => new Book($book['id'], $book['title'], $book['year'], $book['authorId']), $books);
    }

    /**
     * Returns a book with a specific ID.
     *
     * @param int $id The unique identifier of the book.
     * @return Book|null The Book object if found, null otherwise.
     */
    public function getById(int $id): ?Book
    {
        $stmt = $this->connection->prepare("SELECT * FROM Book WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $book = $stmt->fetch();
        return $book ? new Book($book['id'], $book['title'], $book['year'], $book['authorId']) : null;
    }

    /**
     * Returns books that belong to a specific author.
     *
     * @param int $authorId The unique identifier of the author.
     * @return int The count of books belonging to the specified author.
     */
    public function countBooksByAuthorId(int $authorId): int
    {
        $stmt = $this->connection->prepare("SELECT COUNT(*) as book_count FROM Book WHERE authorId = :authorId");
        $stmt->execute(['authorId' => $authorId]);
        return (int) $stmt->fetchColumn();
    }

    /**
     * Retrieves books by author ID.
     *
     * @param int $authorId The ID of the author whose books to retrieve.
     * @return Book[] An array of Book objects.
     */
    public function getBooksByAuthorId(int $authorId): array
    {
        $stmt = $this->connection->prepare("SELECT * FROM Book WHERE authorId = :authorId");
        $stmt->execute(['authorId' => $authorId]);
        $books = $stmt->fetchAll();
        return array_map(fn($book) => new Book($book['id'], $book['title'], $book['year'], $book['authorId']), $books);
    }

    /**
     * Creates a new book.
     *
     * @param string $title The title of the new book.
     * @param int $year The year of the new book.
     * @param int $authorId The ID of the author of the new book.
     * @return Book The created Book object.
     */
    public function addBook(string $title, int $year, int $authorId): Book
    {
        $stmt = $this->connection->prepare("INSERT INTO Book (title, year, authorId) VALUES (:title, :year, :authorId)");
        $stmt->execute(['title' => $title, 'year' => $year, 'authorId' => $authorId]);
        $id = $this->connection->lastInsertId();
        return new Book($id, $title, $year, $authorId);
    }

    /**
     * Deletes a book based on its ID.
     *
     * @param int $id The unique identifier of the book to be deleted.
     * @return void
     */
    public function deleteBook(int $id): void
    {
        $stmt = $this->connection->prepare("DELETE FROM Book WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    /**
     * Deletes books based on the author's ID.
     *
     * @param int $authorId The ID of the author whose books should be deleted.
     * @return void
     */
    public function deleteBooksByAuthorId(int $authorId): void
    {
        $stmt = $this->connection->prepare("DELETE FROM Book WHERE authorId = :authorId");
        $stmt->execute(['authorId' => $authorId]);
    }
}
