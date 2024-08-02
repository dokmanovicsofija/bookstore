<?php

namespace Bookstore\Business\Interfaces;
use Bookstore\Business\Domain\AuthorDomainModel;

/**
 * Interface AuthorServiceInterface
 *
 * This interface defines operations for managing authors in the system.
 */
interface AuthorServiceInterface
{
    /**
     * Returns all authors in the system.
     *
     * @return AuthorDomainModel[] An array of Author objects.
     */
    public function getAllAuthors(): array;

    /**
     * Returns an author with the specified ID.
     *
     * @param int $id The ID of the author.
     * @return AuthorDomainModel|null The Author object if found, or null if not.
     */
    public function getAuthorById(int $id): ?AuthorDomainModel;

    /**
     * Creates a new author.
     *
     * @param string $firstName The first name of the author.
     * @param string $lastName The last name of the author.
     * @return void
     */
    public function createAuthor(string $firstName, string $lastName): void;

    /**
     * Updates the information of an author with the specified ID.
     *
     * @param int $id The ID of the author to update.
     * @param string $firstName The new first name of the author.
     * @param string $lastName The new last name of the author.
     * @return void
     */
    public function updateAuthor(int $id, string $firstName, string $lastName): void;

    /**
     * Deletes an author with the specified ID.
     *
     * @param int $id The ID of the author to delete.
     * @return void
     */
    public function deleteAuthor(int $id): void;
}