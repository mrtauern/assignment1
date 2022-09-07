<?php

require_once "functions/functions.php";

if(isset($_POST['name']) && notificationInputValidation($_POST)){
    addNotification($_POST);
    die("<br>Notification added<br><a href='notificationList.php'>Go to notification list</a>");
}
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add notification</title>
    </head>
    <body>

    <h1>Add notification</h1>

    <form method="post" action="">
        Name*: <input type="text" name="name" value="" required><br>
        Type*: SMS<input type="radio" name="type" value="SMS" required> Email<input type="radio" name="type" value="email" required><br>
        Status: <select name="status">
            <option>enabled</option>
            <option>disabled</option>
        </select><br><br>
        <a href='notificationList.php'>Cancel</a>
        <button type="submit">Save</button>
    </form>

    </body>
    </html>

<?php echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; ?>