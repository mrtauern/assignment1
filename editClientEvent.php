<?php

    require_once "functions/functions.php";

    $clientId = $_GET['clientId'];

    if(isset($_POST['frequency']) && eventInputValidation($_POST)){
        updateEvent($_POST);
        die("<br>Event saved<br><a href='clientEventManager.php?clientId=$clientId'>Go to client event list</a>");
    }

    //print_r($_POST);

    $id = $_GET['id'];

    $event = getEventById($id);
    $clients = getClientsFromFile();
    $notifications = getNotificationsFromFile();
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit event</title>
    </head>
    <body>

        <h1>Edit event</h1>

        <form method="post" action="">
            <input type="hidden" name="id" value="<?php echo $event['id'] ?>">

            <input type="hidden" name="client_id" value="<?php echo $event['client_id']; ?>">

            Notification name*: <select name="notification_id">
                <?php foreach($notifications as $n){ ?>
                    <option value="<?php echo $n['id']; ?>" <?php if($event['notification_id'] == $n['id']){ echo "selected"; } ?>>
                        <?php echo $n['name']; ?></option>
                <?php } ?>
            </select><br>

            <input type="hidden" name="start" value="<?php echo date("Y-m-d h:i:sa"); ?>" required>
            Frequency*: Every <input type="number" name="frequency" value="<?php echo $event['frequency'] ?>" required> day<br>
            Message*: <input type="text" name="message" value="<?php echo $event['message'] ?>" required><br><br>
            <a href='clientEventManager.php?clientId=<?php echo $clientId; ?>'>Cancel</a>
            <button type="submit">Save</button>
        </form>

    </body>
    </html>

<?php echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; ?>