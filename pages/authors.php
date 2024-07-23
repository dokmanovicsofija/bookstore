<?php

session_start();

if (!isset($_SESSION['authors'])) {
    $_SESSION['authors'] = [
        ["id" => 1, "firstName" => "Sofija", "lastName" => "Dokmanovic"],
        ["id" => 2, "firstName" => "Marija", "lastName" => "Mikic"],
        ["id" => 3, "firstName" => "Jovan", "lastName" => "Jovanovic"],
        ["id" => 4, "firstName" => "Nikola", "lastName" => "Nikolic"]
    ];
}

if (!isset($_SESSION['books'])) {
    $_SESSION['books'] = [
        ["id" => 1, "title" => "Knjiga A", "year" => 2020, "authorId" => 1],
        ["id" => 2, "title" => "Knjiga B", "year" => 2021, "authorId" => 1],
        ["id" => 3, "title" => "Knjiga C", "year" => 2019, "authorId" => 2],
        ["id" => 4, "title" => "Knjiga D", "year" => 2022, "authorId" => 3],
        ["id" => 5, "title" => "Knjiga E", "year" => 2023, "authorId" => 4],
        ["id" => 6, "title" => "Knjiga F", "year" => 2022, "authorId" => 4]
    ];
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
            <?php foreach ($_SESSION['authors'] as $author): ?>
            <tr>
                <td>
                    <div class="author-info">
                        <span class="avatar">&#128100;</span>
                            <a href="authorBooks.php?id=<?php echo urlencode($author['id']); ?>">
                                <?php echo htmlspecialchars($author['firstName'] . ' ' . $author['lastName']); ?>
                            </a>
                    </div>
                </td>
                    <td><span class="book-count"><?php echo count(array_filter($_SESSION['books'], function($book) use ($author) {
                            return $book['authorId'] == $author['id'];
                        })); ?></span></td>
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