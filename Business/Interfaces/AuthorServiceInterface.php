<?php

interface AuthorServiceInterface {
    public function getAllAuthors(): array;
    public function getAuthorById($id): ?Author;
    public function createAuthor(string $firstName, string $lastName): void;
    public function updateAuthor($id, string $firstName, string $lastName): void;
    public function deleteAuthor($id): void;
}