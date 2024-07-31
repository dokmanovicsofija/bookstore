<?php

namespace src\Presentation\Models;

/**
 * Class Book
 *
 * Represents a book with its details, including the unique identifier, title, publication year, and author ID.
 * Inherits from AbstractDTO.
 */
class Book extends AbstractDTO
{
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
     * Gets the title of the book.
     *
     * @return string The title of the book.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Gets the year the book was published.
     *
     * @return int The year the book was published.
     */
    public function getYear(): int
    {
        return $this->year;
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
     * Sets the unique identifier of the book.
     *
     * @param int $id The unique identifier of the book.
     *
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Sets the title of the book.
     *
     * @param string $title The title of the book.
     *
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = htmlspecialchars($title);
    }

    /**
     * Sets the year the book was published.
     *
     * @param int $year The year the book was published.
     *
     * @return void
     */
    public function setYear(int $year): void
    {
        $this->year = htmlspecialchars($year);
    }

    /**
     * Sets the identifier of the author of the book.
     *
     * @param int $authorId The identifier of the author of the book.
     *
     * @return void
     */
    public function setAuthorId(int $authorId): void
    {
        $this->authorId = (int)$authorId;
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
