<?php
//class Book {
//    private $id;
//    private $title;
//    private $year;
//    private $authorId;
//
//    public function __construct($id, $title, $year, $authorId) {
//        $this->id = $id;
//        $this->title = $title;
//        $this->year = $year;
//        $this->authorId = $authorId;
//    }
//
//    public function getId() {
//        return $this->id;
//    }
//
//    public function getTitle() {
//        return $this->title;
//    }
//
//    public function getYear() {
//        return $this->year;
//    }
//
//    public function getAuthorId() {
//        return $this->authorId;
//    }
//
//    public function setId($id): void {
//        $this->id = $id;
//    }
//
//    public function setTitle($title): void {
//        $this->title = htmlspecialchars($title);
//    }
//
//    public function setYear($year): void {
//        $this->year = htmlspecialchars($year);
//    }
//
//    public function setAuthorId($authorId): void {
//        $this->authorId = (int)$authorId;
//    }
//
//    /**
//     *
//     *
//     * @return array
//     */
//    public function toArray(): array
//    {
//        return [
//            'id' => $this->id,
//            'title' => $this->title,
//            'year' => $this->year,
//            'authorId' => $this->authorId,
//        ];
//    }
//
//    /**
//     * @param array $batch
//     *
//     * @return self[]
//     */
//    public static function fromBatch(array $batch): array
//    {
//        $books = [];
//
//        foreach ($batch as $item) {
//            $books[] = new Book($item['id'], $item['title'], $item['year'], $item['authorId']);
//        }
//
//        return $books;
//    }
//
//}
