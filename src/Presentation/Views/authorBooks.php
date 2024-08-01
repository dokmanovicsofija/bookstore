<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books by Author</title>
    <link rel="stylesheet" href="/src/Presentation/Public/css/authorBooks.css">
</head>
<body>
<div class="container">
    <input type="hidden" id="author-id" value="<?php echo htmlspecialchars($authorId); ?>">
    <div id="books-section">
        <h1>Books by Author</h1>
        <table id="books-table">
            <thead>
            <tr>
                <th>Book</th>
                <th>Year</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <button id="add-book-btn">Add Book</button>
    </div>
    <a href="/src" id="back-to-authors" class="back">Back to Authors</a>
</div>

<script src="/src/Presentation/Public/js/ajax.js"></script>
<script src="/src/Presentation/Public/js/books.js"></script>
</body>
</html>