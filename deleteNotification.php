<?php

    require_once "functions/functions.php";
    
    if(isset($_POST['id'])){
        deleteNotification($_POST['id']);
        die("<br>Notification deleted<br><a href='notificationList.php'>Go to notification list</a>");
    }
    
    $id = $_GET['id'];
    
    $notification = getNotificationById($id);
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Delete Notification</title>
    </head>
    <body>

    <h1>Are you sure you want to delete <?php echo $notification['name'] ?></h1>

    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $notification['id'] ?>">
        <button type="submit">Delete</button>
    </form>

    </body>
    </html>

<?php echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; ?>