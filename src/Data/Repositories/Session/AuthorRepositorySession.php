<?php

namespace Bookstore\Data\Repositories\Session;

use Bookstore\Business\Interfaces\AuthorRepositoryInterface;
use Bookstore\Infrastructure\SessionManager;
use Bookstore\Presentation\Models\Author;

/**
 * Class AuthorRepositorySession
 *
 * This class implements the AuthorRepositoryInterface and manages authors in a session.
 */
class AuthorRepositorySession implements AuthorRepositoryInterface
{
    /**
     * @var Author[] An array of Author objects.
     */
    private array $authors;

    /**
     * @var SessionManager The session manager instance.
     */
    private SessionManager $sessionManager;

    /**
     * AuthorRepositorySession constructor.
     *
     * Initializes the object by setting up the session manager and loading
     * * the authors from the session. If no authors are found in the session,
     * * it initializes the session with a default author.
     */
    public function __construct()
    {
        $this->sessionManager = SessionManager::getInstance();
        $authors = $this->sessionManager->get('authors');

        if (!$authors) {
            $defaultAuthors = [
                (new Author(1, 'Sofija', 'Dokmanovic'))->toArray(),
                (new Author(2, 'Ana', 'Ivanovic'))->toArray(),
            ];
            $this->sessionManager->set('authors', $defaultAuthors);
            $authors = $defaultAuthors;
        }

        $this->authors = Author::fromBatch($authors);
    }

    /**
     * Retrieves all authors.
     *
     * @return Author[] An array of Author objects.
     */
    public function getAll(): array
    {
        return $this->authors;
    }

    /**
     * Retrieves an author by their ID.
     *
     * @param int $id The ID of the author to retrieve.
     * @return Author|null The Author object if found, or null if not found.
     */
    public function getById(int $id): ?Author
    {
        foreach ($this->authors as $author) {
            if ($author->getId() == $id) {
                return $author;
            }
        }

        return null;
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
        $id = $this->getNextId();
        $newAuthor = new Author($id, $firstName, $lastName);
        $this->authors[] = $newAuthor;
        $this->updateSession();

        return $newAuthor;
    }

    /**
     * Updates the information of an existing author.
     *
     * @param int $id The ID of the author to update.
     * @param string $firstName The new first name of the author.
     * @param string $lastName The new last name of the author.
     * @return void
     */
    public function update(
        int $id, string $firstName, string $lastName): void
    {
        $author = $this->getById($id);
        if ($author) {
            $author->setFirstName($firstName);
            $author->setLastName($lastName);
            $this->updateSession();
        }

    }

    /**
     * Deletes an author with the specified ID.
     *
     * @param int $id The ID of the author to delete.
     * @return void
     */
    public function delete(int $id): void
    {
        $this->authors = array_filter($this->authors, function ($author) use ($id) {
            return $author->getId() != $id;
        });

        $this->authors = array_values($this->authors);

        $this->updateSession();
    }

    /**
     * Updates the session with the current list of authors.
     *
     * @return void
     */
    private function updateSession(): void
    {
        $authorsArray = [];
        foreach ($this->authors as $author) {
            $authorsArray[] = $author->toArray();
        }

        $this->sessionManager->set('authors', $authorsArray);
    }

    /**
     * Gets the next available ID for a new author.
     *
     * This function calculates the next available ID by iterating through the existing authors
     * and finding the highest current ID. It then returns the highest ID plus one, ensuring
     * that each new author will receive a unique ID.
     *
     * @return int The next available ID for a new author.
     */
    private function getNextId(): int
    {
        $lastId = 0;

        foreach ($this->authors as $author) {
            if ($author->getId() > $lastId) {
                $lastId = $author->getId();
            }
        }

        return $lastId + 1;
    }
}