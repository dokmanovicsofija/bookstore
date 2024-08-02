<?php

namespace Bookstore\Business\Interfaces;
use Bookstore\Business\Domain\AuthorDomainModel;

/**
 * Interface AuthorRepositoryInterface
 *
 * This interface defines the contract for a repository managing authors.
 */
interface AuthorRepositoryInterface
{
    /**
     * Retrieves all authors.
     *
     * @return AuthorDomainModel[] An array of Author objects.
     */
    public function getAll(): array;

    /**
     * Retrieves an author by their ID.
     *
     * @param int $id The ID of the author to retrieve.
     * @return AuthorDomainModel|null The Author object if found, or null if not found.
     */
    public function getById(int $id): ?AuthorDomainModel;

    /**
     * Creates a new author with the given first and last names.
     *
     * @param string $firstName The first name of the new author.
     * @param string $lastName The last name of the new author.
     * @return AuthorDomainModel The created Author object.
     */
    public function create(string $firstName, string $lastName): AuthorDomainModel;

    /**
     * Updates the information of an existing author.
     *
     * @param int $id The ID of the author to update.
     * @param string $firstName The new first name of the author.
     * @param string $lastName The new last name of the author.
     * @return void
     */
    public function update(int $id, string $firstName, string $lastName): void;

    /**
     * Deletes an author with the specified ID.
     *
     * @param int $id The ID of the author to delete.
     * @return void
     */
    public function delete(int $id): void;
}