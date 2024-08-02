<?php

namespace Bookstore\Business\Services;

use Bookstore\Business\Domain\BookDomainModel;
use Bookstore\Business\Interfaces\BookRepositoryInterface;
use Bookstore\Business\Interfaces\BookServiceInterface;

/**
 * Class BookService
 *
 * This class provides service methods for managing books, leveraging the book repository for data operations.
 */
class BookService implements BookServiceInterface
{
    /**
     * BookService constructor.
     *
     * @param BookRepositoryInterface $bookRepository The repository instance to be used by the service.
     */
    public function __construct(private BookRepositoryInterface $bookRepository)
    {
    }

    /**
     * Retrieves all books.
     *
     * This method fetches all books from the repository.
     *
     * @return BookDomainModel[] An array of Book objects.
     */
    public function getAllBooks(): array
    {
        return $this->bookRepository->getAll();
    }

    /**
     * Retrieves a book by its ID.
     *
     * This method fetches a single book from the repository based on the provided ID.
     *
     * @param int $id The ID of the book to retrieve.
     * @return BookDomainModel|null The Book object if found, or null if not found.
     */
    public function getBookById(int $id): ?BookDomainModel
    {
        return $this->bookRepository->getById($id);
    }

    /**
     * Retrieves books by author ID.
     *
     * @param int $authorId The ID of the author whose books to retrieve.
     * @return BookDomainModel[] An array of Book objects.
     */
    public function getBooksByAuthorId(int $authorId): array
    {
        return $this->bookRepository->getBooksByAuthorId($authorId);
    }

    /**
     * Creates a new book.
     *
     * This method creates a new book using the provided details and saves it to the repository.
     *
     * @param string $title The title of the book.
     * @param int $year The publication year of the book.
     * @param int $authorId The ID of the author of the book.
     * @return BookDomainModel
     */
    public function createBook(string $title, int $year, int $authorId): BookDomainModel
    {
        return $this->bookRepository->addBook($title, $year, $authorId);
    }

    /**
     * Deletes a book by its ID.
     *
     * This method removes a book from the repository based on the provided ID.
     *
     * @param int $id The ID of the book to delete.
     * @return void
     */
    public function deleteBook(int $id): void
    {
        $this->bookRepository->deleteBook($id);
    }
}
