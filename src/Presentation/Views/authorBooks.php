<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books by Author</title>
    <link rel="stylesheet" href="./Presentation/Public/css/authorBooks.css">
</head>
<body>
<div class="container">
    <h1>Books by Author</h1>
    <table>
        <thead>
        <tr>
            <th>Book</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($books as $book): ?>
            <tr>
                <td><?php echo htmlspecialchars($book->getTitle()) . ' (' . htmlspecialchars($book->getYear()) . ')'; ?></td>
                <td>
                    <a href="editBook.php?id=<?php echo $book->getId(); ?>" class="edit">&#9998;</a>
                    <a href="deleteBook.php?id=<?php echo $book->getId(); ?>" class="delete">&#10060;</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="createBook.php?authorId=<?php echo $authorId; ?>" class="add">+</a>
</div>
</body>
</html>

