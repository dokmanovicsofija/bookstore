<?php
$firstNameError = $lastNameError = "";
$firstName = $lastName = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["first_name"])) {
        $firstNameError = "* This field is required";
    } elseif (strlen($_POST["first_name"]) > 100) {
        $firstNameError = "* Maximum length is 100 characters";
    } else {
        $firstName = htmlspecialchars($_POST["first_name"]);
    }

    if (empty($_POST["last_name"])) {
        $lastNameError = "* This field is required";
    } elseif (strlen($_POST["last_name"]) > 100) {
        $lastNameError = "* Maximum length is 100 characters";
    }  else {
        $lastName = htmlspecialchars($_POST["last_name"]);
    }

//    if ($firstName && $lastName) {
//        //header("Location: authors.php");
//    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Author</title>
    <link rel="stylesheet" href="../css/createAuthor.css">
</head>
<body>
<div class="form-container">
    <h2>Author Create</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="first_name">First name</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo $firstName; ?>">
        <span class="error"><?php echo $firstNameError; ?></span>

        <label for="last_name">Last name</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo $lastName; ?>">
        <span class="error"><?php echo $lastNameError; ?></span>

        <button type="submit">Save</button>
    </form>
</div>
</body>
</html>
