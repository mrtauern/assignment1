<?php

    require_once "functions/functions.php";

    if(isset($_POST['id']) && clientInputValidation($_POST)){
        updateClient($_POST);
        die("<br>Client saved<br><a href='clientList.php'>Go to client list</a>");
    }

    $id = $_GET['id'];

    $client = getClientById($id);
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
            <input type="hidden" name="id" value="<?php echo $client['id'] ?>">
            Company name*: <input type="text" name="company_name" value="<?php echo $client['company_name'] ?>" required><br>
            Business number*: <input type="number" name="business_number" value="<?php echo $client['business_number'] ?>" required><br>
            First name*: <input type="text" name="first_name" value="<?php echo $client['first_name'] ?>" required><br>
            Last name*: <input type="text" name="last_name" value="<?php echo $client['last_name'] ?>" required><br>
            Phone number*: <input type="number" name="phone_number" value="<?php echo $client['phone_number'] ?>" required><br>
            Cell number*: <input type="number" name="cell_number" value="<?php echo $client['cell_number'] ?>" required><br>
            Email*: <input type="email" name="email" value="<?php echo $client['email'] ?>" required><br>
            Website: <input type="text" name="website" value="<?php echo $client['website'] ?>"><br><br>
            <a href='clientList.php'>Cancel</a>
            <button type="submit">Save</button>
        </form>

    </body>
</html>

<?php echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; ?>