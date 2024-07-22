<?php
class Book {
    private $id;
    private $title;
    private $year;
    private $authorId;

    public function __construct($id, $title, $year, $authorId) {
        $this->id = $id;
        $this->title = $title;
        $this->year = $year;
        $this->authorId = $authorId;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getYear() {
        return $this->year;
    }

    public function getAuthorId() {
        return $this->authorId;
    }
}
?>
