<?php

namespace Bookstore\Data\Repositories\SQL;

use Bookstore\Business\Domain\BookDomainModel;
use Bookstore\Business\Interfaces\BookRepositoryInterface;
use Bookstore\Infrastructure\DatabaseConnection;
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
        $this->connection = DatabaseConnection::getInstance();
    }

    /**
     * Returns all books.
     *
     * @return BookDomainModel[] An array of Book objects.
     */
    public function getAll(): array
    {
        $stmt = $this->connection->query("SELECT * FROM Book");
        $books = $stmt->fetchAll();
        return array_map(fn($book) => new BookDomainModel($book['id'], $book['title'], $book['year'], $book['authorId']), $books);
    }

    /**
     * Returns a book with a specific ID.
     *
     * @param int $id The unique identifier of the book.
     * @return BookDomainModel|null The Book object if found, null otherwise.
     */
    public function getById(int $id): ?BookDomainModel
    {
        $stmt = $this->connection->prepare("SELECT * FROM Book WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $book = $stmt->fetch();
        return $book ? new BookDomainModel($book['id'], $book['title'], $book['year'], $book['authorId']) : null;
    }

    /**
     * Retrieves books by author ID.
     *
     * @param int $authorId The ID of the author whose books to retrieve.
     * @return BookDomainModel[] An array of Book objects.
     */
    public function getBooksByAuthorId(int $authorId): array
    {
        $stmt = $this->connection->prepare("SELECT * FROM Book WHERE authorId = :authorId");
        $stmt->execute(['authorId' => $authorId]);
        $books = $stmt->fetchAll();
        return array_map(fn($book) => new BookDomainModel($book['id'], $book['title'], $book['year'], $book['authorId']), $books);
    }

    /**
     * Creates a new book.
     *
     * @param string $title The title of the new book.
     * @param int $year The year of the new book.
     * @param int $authorId The ID of the author of the new book.
     * @return BookDomainModel The created Book object.
     */
    public function addBook(string $title, int $year, int $authorId): BookDomainModel
    {
        $stmt = $this->connection->prepare("INSERT INTO Book (title, year, authorId) VALUES (:title, :year, :authorId)");
        $stmt->execute(['title' => $title, 'year' => $year, 'authorId' => $authorId]);
        $id = $this->connection->lastInsertId();
        return new BookDomainModel($id, $title, $year, $authorId);
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
