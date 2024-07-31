<?php

namespace src\Data\Repositories\SQL;

use src\Data\Repositories\Interfaces\AuthorRepositoryInterface;
use src\Infrastructure\DatabaseConnection;
use src\Presentation\Models\Author;
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
     * @return Author[] An array of Author objects.
     */
    public function getAll(): array
    {
        $stmt = $this->connection->query("SELECT * FROM Author");
        $authors = $stmt->fetchAll();
        return array_map(fn($author) => new Author($author['id'], $author['firstName'], $author['lastName']), $authors);
    }

    /**
     * Retrieves an author by their ID.
     *
     * @param int $id The ID of the author to retrieve.
     * @return Author|null The Author object if found, or null if not found.
     */
    public function getById(int $id): ?Author
    {
        $stmt = $this->connection->prepare("SELECT * FROM Author WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $author = $stmt->fetch();
        return $author ? new Author($author['id'], $author['firstName'], $author['lastName']) : null;
    }

    /**
     * Creates a new author with the given first and last names.
     *
     * @param string $firstName The first name of the new author.
     * @param string $lastName The last name of the new author.
     * @return Author The created Author object.
     */
    public function create(string $firstName, string $lastName): Author
    {
        $stmt = $this->connection->prepare("INSERT INTO Author (firstName, lastName) VALUES (:firstName, :lastName)");
        $stmt->execute(['firstName' => $firstName, 'lastName' => $lastName]);
        $id = $this->connection->lastInsertId();
        return new Author($id, $firstName, $lastName);
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
