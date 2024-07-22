<?php
class Author {
    private $id;
    private $firstName;
    private $lastName;

    public function __construct($id, $firstName, $lastName) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getId() {
        return $this->id;
    }

    public function getFullName() {
        return $this->firstName . ' ' . $this->lastName;
    }
}
?>

