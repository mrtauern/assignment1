<?php

    require_once "functions/functions.php";

    $id = $_GET['id'];

    $event = getEventById($id);

    if(isset($_POST['confirm'])){
        updateEventStatus($_POST['id'], $_POST['status']);
        die("<br>Status changed<br><a href='eventList.php'>Go to event list</a>");
    } elseif(isset($_POST['id'])){
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Confirm change</title>
    </head>
    <body>

    <h1>Are you sure you want to change status for <?php echo $event['id'] ?>?</h1>

    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $_POST['id'] ?>">
        <input type="hidden" name="status" value="<?php echo $_POST['status'] ?>">
        <input type="hidden" name="confirm" value="true">
        <a href='eventList.php'>Cancel</a>
        <button type="submit">Confirm</button>
    </form>

    </body>
    </html>

    <?php echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; ?>

    <?php
    die();
}

if($event['status'] == "active"){
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

<h1>Change status for <?php echo $event['id'] ?></h1>

<form method="post" action="">
    <input type="hidden" name="id" value="<?php echo $event['id'] ?>">
    Status: <select name="status">
        <option <?php echo $statusActive ?>>active</option>
        <option <?php echo $statusArchive ?>>archive</option>
    </select><br><br>
    <a href='eventList.php'>Cancel</a>
    <button type="submit">Change</button>
</form>

</body>
</html>

<?php echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; ?>
