<?php

namespace Bookstore\Presentation\Models;

use InvalidArgumentException;

/**
 * Class Book
 *
 * Represents a book with its details, including the unique identifier, title, publication year, and author ID.
 * Inherits from AbstractDTO.
 */
class Book extends AbstractDTO
{
    private const int MAX_TITLE_LENGTH = 255;

    /**
     * Constructor for the Book class.
     *
     * @param int $id The unique identifier of the book.
     * @param string $title The title of the book.
     * @param int $year The year the book was published.
     * @param int $authorId The identifier of the author of the book.
     */
    public function __construct(
        private int    $id,
        private string $title,
        private int    $year,
        private int    $authorId)
    {
        $this->validate($title, $year);
    }

    /**
     * Validate the book properties.
     *
     * @param string $title The title of the book.
     * @param int $year The publication year of the book.
     *
     * @throws InvalidArgumentException If validation fails.
     */
    private function validate(string $title, int $year): void
    {
        if (empty($title)) {
            throw new InvalidArgumentException('Book title cannot be empty.');
        }
        if (strlen($title) > self::MAX_TITLE_LENGTH) {
            throw new InvalidArgumentException('Book title exceeds maximum length.');
        }
        if ($year <= 0) {
            throw new InvalidArgumentException('Please enter a valid year.');
        }
    }

    /**
     * Gets the unique identifier of the book.
     *
     * @return int The unique identifier of the book.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Gets the identifier of the author of the book.
     *
     * @return int The identifier of the author of the book.
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * Get the title of the book.
     *
     * @return string The title of the book.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get the publication year of the book.
     *
     * @return int The publication year of the book.
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * Converts the book object to an associative array.
     *
     * @return array An associative array representation of the book, including 'id', 'title', 'year', and 'authorId'.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'year' => $this->year,
            'authorId' => $this->authorId,
        ];
    }
}
