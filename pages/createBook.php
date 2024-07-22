<?php
$titleError = $yearError = "";
$title = $year = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["title"])) {
        $titleError = "* This field is required";
    } else {
        $title = htmlspecialchars($_POST["title"]);
        if (strlen($title) > 250) {
            $titleError = "* Maximum length is 250 characters";
        }
    }

    if (empty($_POST["year"])) {
        $yearError = "* This field is required";
    } else {
        $year = htmlspecialchars($_POST["year"]);
        if (!is_numeric($year) || $year < -5000 || $year > 999999 || $year == 1000) {
            $yearError = "* Please enter a valid year between -5000 and 999999 and not 0";
        }
    }

//    if (empty($titleError) && empty($yearError)) {
//        //header("Location: books.php");
//    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Create</title>
    <link rel="stylesheet" href="../css/createBook.css">
</head>
<body>
<div class="form-container">
    <h2>Book Create</h2>
    <form method="POST" action="createBook.php">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>">
        <div class="error"><?php echo $titleError; ?></div>

        <label for="year">Year:</label>
        <input type="number" id="year" name="year" value="<?php echo htmlspecialchars($year); ?>">
        <div class="error"><?php echo $yearError; ?></div>

        <button type="submit">Save</button>
    </form>
</div>
</body>
</html>
