<?php

namespace Bookstore\Data\Repositories\SQL;

use Bookstore\Business\Interfaces\AuthorRepositoryInterface;
use Bookstore\Infrastructure\DatabaseConnection;
use Bookstore\Business\Domain\AuthorDomainModel;
use PDO;

/**
 * Class SqlAuthorRepository
 *
 * Implementation of AuthorRepositoryInterface using SQL (PDO).
 */
class SqlAuthorRepository implements AuthorRepositoryInterface
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance();
    }

    /**
     * Retrieves all authors.
     *
     * @return AuthorDomainModel[] An array of Author objects.
     */
    public function getAll(): array
    {
        $sql = "
        SELECT a.id AS id, a.firstName AS firstName, a.lastName AS lastName, COUNT(b.id) AS bookCount
        FROM Author a
        LEFT JOIN Book b ON a.id = b.authorId
        GROUP BY a.id, a.firstName, a.lastName
    ";

        $stmt = $this->connection->query($sql);
        $authors = $stmt->fetchAll();

        return array_map(fn($author) => (new AuthorDomainModel(
            $author['id'],
            $author['firstName'],
            $author['lastName'],
            $author['bookCount']
        )), $authors);
    }

    /**
     * Retrieves an author by their ID.
     *
     * @param int $id The ID of the author to retrieve.
     * @return AuthorDomainModel|null The Author object if found, or null if not found.
     */
    public function getById(int $id): ?AuthorDomainModel
    {
        $stmt = $this->connection->prepare("SELECT * FROM Author WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $author = $stmt->fetch();
        return $author ? new AuthorDomainModel($author['id'], $author['firstName'], $author['lastName']) : null;
    }

    /**
     * Creates a new author with the given first and last names.
     *
     * @param string $firstName The first name of the new author.
     * @param string $lastName The last name of the new author.
     * @return AuthorDomainModel The created Author object.
     */
    public function create(string $firstName, string $lastName): AuthorDomainModel
    {
        $stmt = $this->connection->prepare("INSERT INTO Author (firstName, lastName) VALUES (:firstName, :lastName)");
        $stmt->execute(['firstName' => $firstName, 'lastName' => $lastName]);
        $id = $this->connection->lastInsertId();
        return new AuthorDomainModel($id, $firstName, $lastName);
    }

    /**
     * Updates the information of an existing author.
     *
     * @param int $id The ID of the author to update.
     * @param string $firstName The new first name of the author.
     * @param string $lastName The new last name of the author.
     * @return void
     */
    public function update(int $id, string $firstName, string $lastName): void
    {
        $stmt = $this->connection->prepare("UPDATE Author SET firstName = :firstName, lastName = :lastName WHERE id = :id");
        $stmt->execute(['firstName' => $firstName, 'lastName' => $lastName, 'id' => $id]);
    }

    /**
     * Deletes an author with the specified ID.
     *
     * @param int $id The ID of the author to delete.
     * @return void
     */
    public function delete(int $id): void
    {
        $stmt = $this->connection->prepare("DELETE FROM Author WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
