<?php

interface AuthorRepositoryInterface {
    /**
     * @return Author[]
     */
    public function getAll(): array;
    public function getById($id): ?Author;
    public function create(string $firstName, string $lastName): Author;
    public function update($id, string $firstName, string $lastName): void;
    public function delete($id): void;
}