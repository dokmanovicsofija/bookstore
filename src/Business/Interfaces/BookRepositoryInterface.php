<?php

namespace Bookstore\Business\Interfaces;
use Bookstore\Business\Domain\BookDomainModel;

/**
 * Interface for book repository operations.
 */
interface BookRepositoryInterface
{
    /**
     * Returns all books.
     *
     * @return BookDomainModel[] An array of Book objects.
     */
    public function getAll(): array;

    /**
     * Returns a book with a specific ID.
     *
     * @param int $id The unique identifier of the book.
     * @return BookDomainModel|null The Book object if found, null otherwise.
     */
    public function getById(int $id): ?BookDomainModel;

    /**
     * Retrieves books by author ID.
     *
     * @param int $authorId The ID of the author whose books to retrieve.
     * @return BookDomainModel[] An array of Book objects.
     */
    public function getBooksByAuthorId(int $authorId): array;


    /**
     * Creates a new book.
     *
     * @param string $title The title of the new book.
     * @param int $year The year of the new book.
     * @param int $authorId The ID of the author of the new book.
     * @return BookDomainModel The created Book object.
     */
    public function addBook(string $title, int $year, int $authorId): BookDomainModel;

    /**
     * Deletes a book based on its ID.
     *
     * @param int $id The unique identifier of the book to be deleted.
     *
     * @return void
     */
    public function deleteBook(int $id): void;

    /**
     * Deletes books based on the author's ID.
     *
     * This method removes all books associated with the given author's ID from the database.
     *
     * @param int $authorId The ID of the author whose books should be deleted.
     * @return void
     */
    public function deleteBooksByAuthorId(int $authorId): void;
}
