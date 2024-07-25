<?php
class Author {
    private $id;
    private $firstName;
    private $lastName;
    private $bookCount;

    public function __construct($id, $firstName, $lastName, $bookCount) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->bookCount = $bookCount;
    }

    public function getId() {
        return $this->id;
    }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getBookCount() {
        return $this->bookCount;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setFirstName($firstName): void
    {
        $this->firstName = htmlspecialchars($firstName);
    }

    public function setLastName($lastName): void
    {
        $this->lastName = htmlspecialchars($lastName);
    }

    public function setBookCount($bookCount): void
    {
        $this->bookCount = $bookCount;
    }

    /**
     *
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'bookCount' => $this->bookCount,
        ];
    }

    /**
     * @param array $batch
     *
     * @return self[]
     */
    public static function fromBatch(array $batch): array
    {
        $authors = [];

        foreach ($batch as $item) {
            $authors[] = new Author($item['id'], $item['firstName'], $item['lastName'], $item['bookCount']);
        }

        return $authors;
    }


}

