<?php
session_start();

$authorId = $_GET['id'];

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

$firstNameError = $lastNameError = "";
$firstName = $author['firstName'];
$lastName = $author['lastName'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    if (empty($_POST["first_name"])) {
        $firstNameError = "* This field is required";
        $isValid = false;
    } elseif (strlen($_POST["first_name"]) > 100) {
        $firstNameError = "* Maximum length is 100 characters";
        $isValid = false;
    } else {
        $firstName = htmlspecialchars($_POST["first_name"]);
    }

    if (empty($_POST["last_name"])) {
        $lastNameError = "* This field is required";
        $isValid = false;
    } elseif (strlen($_POST["last_name"]) > 100) {
        $lastNameError = "* Maximum length is 100 characters";
        $isValid = false;
    } else {
        $lastName = htmlspecialchars($_POST["last_name"]);
    }

    if ($isValid) {
        foreach ($_SESSION['authors'] as &$a) {
            if ($a['id'] == $authorId) {
                $a['firstName'] = $firstName;
                $a['lastName'] = $lastName;
                break;
            }
        }
        header("Location: authors.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Author</title>
    <link rel="stylesheet" href="../css/editAuthor.css">
</head>
<body>
<div class="form-container">
    <h2>Author Edit (<?php echo $authorId; ?>)</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . urlencode($authorId); ?>" method="post">
        <label for="first_name">First name</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($firstName); ?>">
        <span class="error"><?php echo $firstNameError; ?></span>

        <label for="last_name">Last name</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($lastName); ?>">
        <span class="error"><?php echo $lastNameError; ?></span>

        <button type="submit">Save</button>
    </form>
</div>
</body>
</html>

