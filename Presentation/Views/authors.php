
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Author List</title>
    <link rel="stylesheet" href="./Presentation/Public/css/authors.css">
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
                            <a href="authorBooks.php?id=<?php echo urlencode($author->getId()); ?>">
                                <?php echo htmlspecialchars($author->getFullName()) ?>
                            </a>
                    </div>
                </td>
                    <td>
                        <span class="book-count"><?php echo htmlspecialchars($author->getBookCount()) ?></span>

                    </td>
                    <td>
                        <a href="./editAuthor?id=<?php echo htmlspecialchars($author->getId()) ?>" class="edit">&#9998;</a>
                        <a href="./deleteAuthor?id=<?php echo htmlspecialchars($author->getId()) ?>" class="delete">&#10060;</a>
                    </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="./createAuthor" class="add">+</a>
</div>
</body>
</html>