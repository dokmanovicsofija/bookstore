<?php

namespace src\Business\Interfaces;
use src\Presentation\Models\Book;

/**
 * Interface for managing book services.
 */
interface BookServiceInterface
{
    /**
     * Returns all books.
     *
     * @return Book[] An array of Book objects.
     */
    public function getAllBooks(): array;

    /**
     * Returns a book with a specific ID.
     *
     * @param int $id The unique identifier of the book.
     * @return Book|null The Book object if found, null otherwise.
     */
    public function getBookById(int $id): ?Book;

    /**
     * Returns the count of books that belong to a specific author.
     *
     * @param int $authorId The unique identifier of the author.
     * @return int The count of books belonging to the specified author.
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
     * @param string $title The title of the book.
     * @param int $year The publication year of the book.
     * @param int $authorId The ID of the author who wrote the book.
     *
     * @return Book
     */
    public function createBook(string $title, int $year, int $authorId): Book;

    /**
     * Deletes a book based on its ID.
     *
     * @param int $id The unique identifier of the book to be deleted.
     *
     * @return void
     */
    public function deleteBook(int $id): void;
}
