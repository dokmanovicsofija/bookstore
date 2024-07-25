<?php

/**
 * Represents a book with its details.
 */
class Book
{
    /**
     * @var int The unique identifier of the book.
     */
    private int $id;

    /**
     * @var string The title of the book.
     */
    private string $title;

    /**
     * @var int The year the book was published.
     */
    private int $year;

    /**
     * @var int The identifier of the author of the book.
     */
    private int $authorId;

    /**
     * Constructor for the Book class.
     *
     * @param int $id The unique identifier of the book.
     * @param string $title The title of the book.
     * @param int $year The year the book was published.
     * @param int $authorId The identifier of the author of the book.
     */
    public function __construct(
        int    $id,
        string $title,
        int    $year,
        int    $authorId)
    {
        $this->id = $id;
        $this->title = $title;
        $this->year = $year;
        $this->authorId = $authorId;
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
     * @return array The associative array representation of the book.
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

    /**
     * Creates an array of Book objects from an array of associative arrays.
     *
     * @param array $batch An array of associative arrays representing books.
     *
     * @return self[] An array of Book objects.
     */
    public static function fromBatch(array $batch): array
    {
        $books = [];

        foreach ($batch as $item) {
            $books[] = new Book($item['id'], $item['title'], $item['year'], $item['authorId']);
        }

        return $books;
    }

}
