<?php

require_once "functions/functions.php";

if(isset($_POST['id'])){
    deleteClient($_POST['id']);
    die("<br>Client deleted<br><a href='clientList.php'>Go to client list</a>");
}

$id = $_GET['id'];

$client = getClientById($id);
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Delete Client</title>
    </head>
    <body>

        <h1>Are you sure you want to delete <?php echo $client['company_name'] ?></h1>

        <form method="post" action="">
            <input type="hidden" name="id" value="<?php echo $client['id'] ?>">
            <button type="submit">Delete</button>
        </form>

    </body>
    </html>

<?php echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; ?>