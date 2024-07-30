<?php

namespace src\Data\Repositories\Interfaces;
use src\Presentation\Models\Book;

/**
 * Interface for book repository operations.
 */
interface BookRepositoryInterface
{
    /**
     * Returns all books.
     *
     * @return Book[] An array of Book objects.
     */
    public function getAll(): array;

    /**
     * Returns a book with a specific ID.
     *
     * @param int $id The unique identifier of the book.
     * @return Book|null The Book object if found, null otherwise.
     */
    public function getById(int $id): ?Book;

    /**
     * Returns books that belong to a specific author.
     *
     * @param int $authorId The unique identifier of the author.
     * @return Book[] An array of Book objects belonging to the specified author.
     */
    public function countBooksByAuthorId(int $authorId): int;

    /**
     * Retrieves books by author ID.
     *
     * @param int $authorId The ID of the author whose books to retrieve.
     * @return Book[] An array of Book objects.
     */
    public function getBooksByAuthorId(int $authorId): array;


    /**
     * Creates a new book.
     *
     * @param string $title The title of the new book.
     * @param int $year The year of the new book.
     * @param int $authorId The ID of the author of the new book.
     * @return Book The created Book object.
     */
    public function addBook(string $title, int $year, int $authorId): Book;

    /**
     * Deletes a book based on its ID.
     *
     * @param int $id The unique identifier of the book to be deleted.
     *
     * @return void
     */
    public function deleteBook(int $id): void;
}
