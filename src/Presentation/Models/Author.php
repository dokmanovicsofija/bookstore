<?php

namespace src\Presentation\Models;

/**
 * Class Author
 *
 * Represents an author with personal details such as ID, first name, and last name.
 * Inherits from AbstractDTO.
 */
class Author extends AbstractDTO
{
    /**
     * Author constructor.
     *
     * @param int $id The unique identifier for the author.
     * @param string $firstName The first name of the author (optional, default is an empty string).
     * @param string $lastName The last name of the author (optional, default is an empty string).
     */
    public function __construct(
        private int  $id,
        private string $firstName = '',
        private string $lastName = '',
    )
    {}

    /**
     * Gets the unique identifier of the author.
     *
     * @return int The unique identifier of the author.
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
     * Gets the full name of the author.
     *
     * @return string The full name of the author.
     */
    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }


    /**
     * Sets the unique identifier for the author.
     *
     * @param int $id The unique identifier for the author.
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Sets the first name of the author.
     *
     * @param string $firstName The first name of the author.
     * @return void
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = htmlspecialchars($firstName);
    }

    /**
     * Sets the last name of the author.
     *
     * @param string $lastName The last name of the author.
     * @return void
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = htmlspecialchars($lastName);
    }

    /**
     * Converts the author object to an associative array.
     *
     * @return array An associative array representation of the author, including 'id', 'firstName', and 'lastName'.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
        ];
    }

}
