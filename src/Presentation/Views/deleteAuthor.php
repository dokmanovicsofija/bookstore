<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Author</title>
    <link rel="stylesheet" href="/Presentation/Public/css/deleteAuthor.css">
</head>
<body>
<div class="delete-container">
    <div class="delete-dialog">
        <div class="delete-header">
            <span class="delete-icon">&#9888;</span>
            <h2>Delete Author</h2>
        </div>
        <p>You are about to delete the author '<?php echo htmlspecialchars($author->getFullName()); ?>'.
            If you proceed with this action, the application will permanently delete all books related to this author.</p>
        <div class="delete-actions">
            <form method="post" action="/deleteAuthor?id=<?php echo urlencode($author->getId()); ?>">
            <button type="submit" name="delete" class="delete-btn">Delete</button>
                <a href="/src" class="cancel-btn">Cancel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>


