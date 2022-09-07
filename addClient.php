<?php

require_once "functions/functions.php";

if(isset($_POST['company_name']) && clientInputValidation($_POST)){
    addClient($_POST);
    die("<br>Client added<br><a href='clientList.php'>Go to client list</a>");
}
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit Client</title>
    </head>
    <body>

    <h1>Edit client</h1>

    <form method="post" action="">
        Company name*: <input type="text" name="company_name" value="" required><br>
        Business number*: <input type="number" name="business_number" value="" required><br>
        First name*: <input type="text" name="first_name" value="" required><br>
        Last name*: <input type="text" name="last_name" value="" required><br>
        Phone number*: <input type="number" name="phone_number" value="" required><br>
        Cell number*: <input type="number" name="cell_number" value="" required><br>
        Email*: <input type="email" name="email" value="" required><br>
        Website: <input type="text" name="website" value=""><br>
        Status: <select name="status">
            <option>active</option>
            <option>archive</option>
        </select><br><br>
        <a href='clientList.php'>Cancel</a>
        <button type="submit">Save</button>
    </form>

    </body>
    </html>

<?php echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; ?>