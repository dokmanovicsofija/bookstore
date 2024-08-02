<?php

namespace Bookstore\Business\Domain;

/**
 * Class BookDomainModel
 *
 * Represents a book in the domain layer of the application.
 * This class contains properties related to a book and methods for manipulating book data.
 */
class BookDomainModel
{
    /**
     * BookDomainModel constructor.
     *
     * Initializes a new instance of the BookDomainModel class with the provided data.
     *
     * @param int $id The unique identifier for the book.
     * @param string $title The title of the book.
     * @param int $year The publication year of the book.
     * @param int $authorId The unique identifier for the author of the book.
     */
    public function __construct(
        private int    $id,
        private string $title,
        private int    $year,
        private int    $authorId
    )
    {
    }

    /**
     * Convert the book object to an associative array.
     *
     * This method creates an array representation of the book object with keys corresponding to the object's properties.
     *
     * @return array An associative array with keys 'id', 'title', 'year', and 'authorId', and their respective values.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'year' => $this->year,
            'authorId' => $this->authorId
        ];
    }
}
