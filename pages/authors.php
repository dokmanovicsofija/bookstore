<?php

$authors = [
    ["id" => 1, "name" => "Sofija Dokmanovic"],
    ["id" => 2, "name" => "Marija Mikic"],
    ["id" => 3, "name" => "Jovan Jovanovic"],
    ["id" => 4, "name" => "Nikola Nikolic"],
];

$books = [
    ["title" => "Knjiga A", "author_id" => 1],
    ["title" => "Knjiga B", "author_id" => 1],
    ["title" => "Knjiga C", "author_id" => 2],
    ["title" => "Knjiga D", "author_id" => 3],
    ["title" => "Knjiga E", "author_id" => 4],
    ["title" => "Knjiga F", "author_id" => 4],
];

$bookCount = [];
foreach ($books as $book) {
    $authorId = $book['author_id'];
    if (!isset($bookCount[$authorId])) {
        $bookCount[$authorId] = 0;
    }
    $bookCount[$authorId]++;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Author List</title>
    <link rel="stylesheet" href="../css/authors.css">
</head>
<body>
<div class="container">
    <h1>Author List</h1>
    <table>
        <thead>
        <tr>
            <th>Author</th>
            <th>Books</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($authors as $author): ?>
            <tr>
                <td>
                    <div class="author-info">
                        <span class="avatar">&#128100;</span>
                        <a href="authorBooks.php?name=<?php echo urlencode($author['name']); ?>">
                            <?php echo htmlspecialchars($author['name']); ?>
                        </a>
                    </div>
                </td>
                <td><span class="book-count"><?php echo isset($bookCount[$author['id']]) ? $bookCount[$author['id']] : 0; ?></span></td>
                <td>
                    <a href="editAuthor.php?id=<?php echo $author['id']; ?>" class="edit">&#9998;</a>
                    <a href="deleteAuthor.php?id=<?php echo $author['id']; ?>" class="delete">&#10060;</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="createAuthor.php" class="add">+</a>
</div>
</body>
</html>