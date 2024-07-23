<?php
session_start();

$authorId = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $_SESSION['authors'] = array_filter($_SESSION['authors'], function($a) use ($authorId) {
        return $a['id'] != $authorId;
    });

    $_SESSION['books'] = array_filter($_SESSION['books'], function($book) use ($authorId) {
        return $book['authorId'] != $authorId;
    });

    header("Location: authors.php");
    exit();
}

$author = null;
foreach ($_SESSION['authors'] as $a) {
    if ($a['id'] == $authorId) {
        $author = $a;
        break;
    }
}

if (!$author) {
    header("Location: authors.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Author</title>
    <link rel="stylesheet" href="../css/deleteAuthor.css">
</head>
<body>
<div class="delete-container">
    <div class="delete-dialog">
        <div class="delete-header">
            <span class="delete-icon">&#9888;</span>
            <h2>Delete Author</h2>
        </div>
        <p>You are about to delete the author '<?php echo htmlspecialchars($author['firstName'] . ' ' . $author['lastName']); ?>'. If you proceed with this action, the application will permanently delete all books related to this author.</p>
        <div class="delete-actions">
            <form method="post" action="deleteAuthor.php?id=<?php echo urlencode($author['id']); ?>">
                <button type="submit" name="delete" class="delete-btn">Delete</button>
                <a href="authors.php" class="cancel-btn">Cancel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>

