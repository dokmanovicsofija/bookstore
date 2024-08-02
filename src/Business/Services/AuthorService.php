<?php

namespace Bookstore\Business\Services;

use Bookstore\Business\Domain\AuthorDomainModel;
use Bookstore\Business\Interfaces\AuthorRepositoryInterface;
use Bookstore\Business\Interfaces\AuthorServiceInterface;
use Bookstore\Business\Interfaces\BookRepositoryInterface;

/**
 * Class AuthorService
 *
 * This class implements the AuthorServiceInterface and provides methods for managing authors.
 */
class AuthorService implements AuthorServiceInterface
{
    /**
     * AuthorService constructor.
     *
     * @param AuthorRepositoryInterface $authorRepository An instance of the repository for managing authors.
     */
    public function __construct(private AuthorRepositoryInterface $authorRepository, private BookRepositoryInterface $bookRepository)
    {
    }

    /**
     * Retrieves all authors from the repository.
     *
     * @return AuthorDomainModel[] An array of Author objects.
     */
    public function getAllAuthors(): array
    {
        return $this->authorRepository->getAll();
    }

    /**
     * Retrieves an author by their ID.
     *
     * @param int $id The ID of the author to retrieve.
     * @return AuthorDomainModel|null The Author object if found, or null if not found.
     */
    public function getAuthorById(int $id): ?AuthorDomainModel
    {
        return $this->authorRepository->getById($id);
    }

    /**
     * Creates a new author with the given first and last names.
     *
     * @param string $firstName The first name of the new author.
     * @param string $lastName The last name of the new author.
     * @return void
     */
    public function createAuthor(string $firstName, string $lastName): void
    {
        $this->authorRepository->create($firstName, $lastName);
    }

    /**
     * Updates the information of an existing author.
     *
     * @param int $id The ID of the author to update.
     * @param string $firstName The new first name of the author.
     * @param string $lastName The new last name of the author.
     * @return void
     */
    public function updateAuthor(
        int    $id,
        string $firstName,
        string $lastName): void
    {
        $this->authorRepository->update($id, $firstName, $lastName);
    }

    /**
     * Deletes an author with the specified ID.
     *
     * @param int $id The ID of the author to delete.
     * @return void
     */
    public function deleteAuthor(int $id): void
    {
        $this->bookRepository->deleteBooksByAuthorId($id);
        $this->authorRepository->delete($id);
    }
}