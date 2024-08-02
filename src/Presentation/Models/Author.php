<?php

namespace Bookstore\Presentation\Models;

use InvalidArgumentException;

/**
 * Class Author
 *
 * Represents an author with personal details such as ID, first name, and last name.
 * Inherits from AbstractDTO.
 */
class Author extends AbstractDTO
{
    private const int MAX_LENGTH = 100;

    /**
     * Author constructor.
     *
     * @param int $id The unique identifier for the author.
     * @param string $firstName The first name of the author (optional, default is an empty string).
     * @param string $lastName The last name of the author (optional, default is an empty string).
     */
    public function __construct(
        private int    $id,
        private string $firstName = '',
        private string $lastName = '',
    )
    {
        $errors = $this->validate($firstName, $lastName);
        if (!empty($errors)) {
            throw new InvalidArgumentException(json_encode($errors));
        }
    }

    /**
     * Validates the provided first and last names according to predefined rules.
     *
     * This method checks if the first name and last name are non-empty and do not exceed
     * the maximum allowed length. If any validation rules are violated, appropriate error
     * messages are added to the `$errors` array.
     *
     * @param string $firstName The first name to be validated.
     * @param string $lastName The last name to be validated.
     * @return array An associative array where the keys are 'firstName' and 'lastName',
     *               and the values are the corresponding error messages if any validation
     *               errors are found. If no errors are found, the array will be empty.
     */
    private function validate(string $firstName, string $lastName): array
    {
        $errors = [];

        if (empty($firstName)) {
            $errors['firstName'] = 'First name is required.';
        }
        if (strlen($firstName) > self::MAX_LENGTH) {
            $errors['firstName'] = 'First name must not exceed ' . self::MAX_LENGTH . ' characters.';
        }

        if (empty($lastName)) {
            $errors['lastName'] = 'Last name is required.';
        }
        if (strlen($lastName) > self::MAX_LENGTH) {
            $errors['lastName'] = 'Last name must not exceed ' . self::MAX_LENGTH . ' characters.';
        }

        return $errors;
    }

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
