<?php

    require_once "functions/functions.php";

    $id = $_GET['id'];

    $client = getClientById($id);

    if(isset($_POST['confirm'])){
        updateClientStatus($_POST['id'], $_POST['status']);
        updateEventStatusByClientId($_POST['id'], $_POST['status']);
        die("<br>Status changed<br><a href='clientList.php'>Go to client list</a>");
    } elseif(isset($_POST['id'])){
        ?>

            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Confirm change</title>
            </head>
            <body>

            <h1>Are you sure you want to change status for <?php echo $client['company_name'] ?>?</h1>

            <form method="post" action="">
                <input type="hidden" name="id" value="<?php echo $_POST['id'] ?>">
                <input type="hidden" name="status" value="<?php echo $_POST['status'] ?>">
                <input type="hidden" name="confirm" value="true">
                <a href='clientList.php'>Cancel</a>
                <button type="submit">Confirm</button>
            </form>

            </body>
            </html>

        <?php echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; ?>

        <?php
        die();
    }

    if($client['status'] == "active"){
        $statusActive = "selected";
        $statusArchive = "";
    } else {
        $statusActive = "";
        $statusArchive = "selected";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Change status</title>
    </head>
    <body>

        <h1>Change status for <?php echo $client['company_name'] ?></h1>

        <form method="post" action="">
            <input type="hidden" name="id" value="<?php echo $client['id'] ?>">
            Status: <select name="status">
                <option <?php echo $statusActive ?>>active</option>
                <option <?php echo $statusArchive ?>>archive</option>
            </select><br><br>
            <a href='clientList.php'>Cancel</a>
            <button type="submit">Change</button>
        </form>

    </body>
</html>

<?php echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; ?>
