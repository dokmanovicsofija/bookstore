<?php

namespace Bookstore\Business\Domain;

/**
 * Represents an author in the domain layer.
 */
class AuthorDomainModel
{
    /**
     * Constructor for initializing the AuthorDomainModel.
     *
     * @param int $id The unique identifier for the author.
     * @param string $firstName The first name of the author.
     * @param string $lastName The last name of the author.
     * @param int $bookCount The number of books written by the author (default is 0).
     */
    public function __construct(private int $id, private string $firstName, private string $lastName, private int $bookCount = 0)
    {
    }

    /**
     * Get the ID of the author.
     *
     * @return int The ID of the author.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Gets the first name of the author.
     *
     * @return string The first name of the author.
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Gets the last name of the author.
     *
     * @return string The last name of the author.
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Get the number of books by the author.
     *
     * @return int The number of books.
     */
    public function getBookCount(): int
    {
        return $this->bookCount;
    }

    /**
     * Gets the full name of the author.
     *
     * @return string The full name of the author.
     */
    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * Sets the number of books written by the author.
     *
     * @param int $bookCount The new number of books written by the author.
     */
    public function setBookCount(int $bookCount): void
    {
        $this->bookCount = $bookCount;
    }
}
