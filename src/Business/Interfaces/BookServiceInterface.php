<?php

namespace Bookstore\Business\Interfaces;
use Bookstore\Business\Domain\BookDomainModel;

/**
 * Interface for managing book services.
 */
interface BookServiceInterface
{
    /**
     * Returns all books.
     *
     * @return BookDomainModel[] An array of Book objects.
     */
    public function getAllBooks(): array;

    /**
     * Returns a book with a specific ID.
     *
     * @param int $id The unique identifier of the book.
     * @return BookDomainModel|null The Book object if found, null otherwise.
     */
    public function getBookById(int $id): ?BookDomainModel;

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
     * @param string $title The title of the book.
     * @param int $year The publication year of the book.
     * @param int $authorId The ID of the author who wrote the book.
     *
     * @return BookDomainModel
     */
    public function createBook(string $title, int $year, int $authorId): BookDomainModel;

    /**
     * Deletes a book based on its ID.
     *
     * @param int $id The unique identifier of the book to be deleted.
     *
     * @return void
     */
    public function deleteBook(int $id): void;
}
