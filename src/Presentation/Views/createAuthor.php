<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Author</title>
    <link rel="stylesheet" href="/src/Presentation/Public/css/createAuthor.css">
</head>
<body>
<div class="form-container">
    <h2>Author Create</h2>
    <form action="/createAuthor" method="POST">
        <label for="first_name">First name</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo $firstName; ?>">
        <span class="error"><?php echo htmlspecialchars($firstNameError); ?></span>

        <label for="last_name">Last name</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo $lastName; ?>">
        <span class="error"><?php echo htmlspecialchars($lastNameError); ?></span>

        <button type="submit">Save</button>
    </form>
</div>
</body>
</html>
