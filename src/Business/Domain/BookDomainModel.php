<?php

namespace Bookstore\Business\Domain;

class BookDomainModel
{
    public function __construct(
        private int $id,
        private string $title,
        private int $year,
        private int $authorId
    ) {
    }

    /**
     * Gets the ID of the book.
     *
     * @return int The ID of the book.
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
     * Gets the year of publication of the book.
     *
     * @return int The year of publication.
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * Gets the ID of the author of the book.
     *
     * @return int The ID of the author.
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * Sets the title of the book.
     *
     * @param string $title The new title of the book.
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Sets the year of publication of the book.
     *
     * @param int $year The new year of publication.
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
    }
}
