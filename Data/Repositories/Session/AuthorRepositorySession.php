<?php

class AuthorRepositorySession implements AuthorRepositoryInterface {

    private $authors;
    private $session;

    public function __construct() {
        $this->session = SessionManager::getInstance();
        $authors = $this->session->get('authors');


        if (!isset($_SESSION['authors'])) {
               $_SESSION['authors'] = [
                   (new Author(1, 'Sofija', 'Dokmanovic', '2'))->toArray(),
//                new Author(2, 'Mika', 'Mikic', 1),
//                new Author(3, 'Zika', 'Zikic', 1),
//                new Author(4, 'Nikola', 'Nikolic', 0)
               ];
            $authors = $this->session->get('authors');
            $this->session->set('authors', $authors);

        }
        $this->authors = Author::fromBatch($this->session->get('authors'));
        //            error_log(print_r($this->authors, true));

    }

    public function getAll(): array {
        return $this->authors;
    }

    public function getById($id): ?Author {
        foreach ($this->authors as $author) {
            if ($author->getId() == $id) {
                return $author;
            }
        }
        return null;
    }

    public function create(string $firstName, string $lastName): Author{
        $id = count($this->authors) + 1;
        $newAuthor = new Author($id, $firstName, $lastName, 0);
        $this->authors[] = $newAuthor;
        $this->updateSession();
        return $newAuthor;
    }

    public function update($id, string $firstName, string $lastName): void {
        $author = $this->getById($id);
        if ($author) {
            $author->setFirstName($firstName);
            $author->setLastName($lastName);
            $this->updateSession();
        }
    }

    public function delete($id): void {
        $this->authors = array_filter($this->authors, function($author) use ($id) {
            return $author->getId() != $id;
        });

        $this->authors = array_values($this->authors);

        $this->updateSession();
    }

    private function updateSession(): void
    {
        $_SESSION['authors'] = [];
        foreach ($this->authors as $author) {
            $_SESSION['authors'][] = $author->toArray();
        }
    }
}