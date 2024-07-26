<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Author</title>
    <link rel="stylesheet" href="/Presentation/Public/css/editAuthor.css">
</head>
<body>
<div class="form-container">
    <h2>Author Edit (<?php echo $author->getId(); ?>)</h2>
    <form action="/editAuthor?id=<?php echo $author->getId(); ?>" method="POST">
        <label for="first_name">First name</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($author->getFirstName()); ?>">
        <span class="error"><?php echo $firstNameError; ?></span>

        <label for="last_name">Last name</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($author->getLastName()); ?>">
        <span class="error"><?php echo $lastNameError; ?></span>

        <button type="submit">Save</button>
    </form>
</div>
</body>
</html>

