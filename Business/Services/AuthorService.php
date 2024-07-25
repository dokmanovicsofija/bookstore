<?php
require_once 'autoload.php';

class AuthorService implements AuthorServiceInterface {
    private AuthorRepositoryInterface $authorRepository;

    public function __construct(AuthorRepositoryInterface $authorRepository) {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @return Author[]
     */
    public function getAllAuthors(): array {
        return $this->authorRepository->getAll();
    }

    public function getAuthorById($id): ?Author {
        return $this->authorRepository->getById($id);
    }

    public function createAuthor(string $firstName, string $lastName): void {
        $this->authorRepository->create($firstName, $lastName);
    }

    public function updateAuthor($id, string $firstName, string $lastName): void {
        $this->authorRepository->update($id, $firstName, $lastName);
    }

    public function deleteAuthor($id): void {
        $this->authorRepository->delete($id);
    }
}