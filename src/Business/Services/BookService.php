<?php

namespace src\Business\Services;

use src\Business\Interfaces\BookServiceInterface;
use src\Data\Repositories\Interfaces\BookRepositoryInterface;
use src\Presentation\Models\Book;

/**
 * Class BookService
 *
 * This class provides service methods for managing books, leveraging the book repository for data operations.
 */
class BookService implements BookServiceInterface
{
    /**
     * @var BookRepositoryInterface The repository instance for managing books.
     */
    private BookRepositoryInterface $bookRepository;

    /**
     * BookService constructor.
     *
     * @param BookRepositoryInterface $bookRepository The repository instance to be used by the service.
     */
    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * Retrieves all books.
     *
     * This method fetches all books from the repository.
     *
     * @return Book[] An array of Book objects.
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
     * @return Book|null The Book object if found, or null if not found.
     */
    public function getBookById(int $id): ?Book
    {
        return $this->bookRepository->getById($id);
    }

    /**
     * Retrieves books by author ID.
     *
     * This method fetches all books from the repository that are associated with the specified author ID.
     *
     * @param int $authorId The ID of the author whose books to retrieve.
     * @return Book[] An array of Book objects related to the specified author.
     */
    public function getBooksByAuthorId(int $authorId): array
    {
        return $this->bookRepository->getByAuthorId($authorId);
    }

    /**
     * Creates a new book.
     *
     * This method creates a new book using the provided details and saves it to the repository.
     *
     * @param string $title The title of the book.
     * @param int $year The publication year of the book.
     * @param int $authorId The ID of the author of the book.
     * @return void
     */
    public function createBook(string $title, int $year, int $authorId): void
    {
        $this->bookRepository->create($title, $year, $authorId);
    }

    /**
     * Updates an existing book.
     *
     * This method updates the details of an existing book in the repository.
     *
     * @param Book $book The Book object with updated details.
     * @return void
     */
    public function updateBook(Book $book): void
    {
        $this->bookRepository->update($book);
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
        $this->bookRepository->delete($id);
    }
}