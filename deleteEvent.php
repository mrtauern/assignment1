<?php

    require_once "functions/functions.php";

    if(isset($_POST['id'])){
        deleteEvent($_POST['id']);
        die("<br>Event deleted<br><a href='eventList.php'>Go to event list</a>");
    }

    $id = $_GET['id'];

    $event = getEventById($id);
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Delete Event</title>
    </head>
    <body>

    <h1>Are you sure you want to delete <?php echo $event['id'] ?></h1>

    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $event['id'] ?>">
        <button type="submit">Delete</button>
    </form>

    </body>
    </html>

<?php echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; ?>