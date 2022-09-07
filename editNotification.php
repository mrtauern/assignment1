<?php

    require_once "functions/functions.php";
    
    if(isset($_POST['name']) && notificationInputValidation($_POST)){
        updateNotification($_POST);
        die("<br>Notification updated<br><a href='notificationList.php'>Go to notification list</a>");
    }
    
    $id = $_GET['id'];
    
    $notification = getNotificationById($id);
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit notification</title>
    </head>
    <body>

    <h1>Edit notification</h1>

    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $notification['id'] ?>">
        Name*: <input type="text" name="name" value="<?php echo $notification['name'] ?>" required><br>
        Type*: SMS<input type="radio" name="type" value="SMS" <?php if($notification['type'] == "SMS"){ echo "checked"; } ?> required><br>
        Email<input type="radio" name="type" value="email" <?php if($notification['type'] == "email"){ echo "checked"; } ?> required><br><br>
        <a href='notificationList.php'>Cancel</a>
        <button type="submit">Save</button>
    </form>

    </body>
    </html>

<?php echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; ?>