<?php

    require_once "functions/functions.php";

    if(isset($_POST['frequency']) && eventInputValidation($_POST)){
        updateEvent($_POST);
        die("<br>Event saved<br><a href='eventList.php'>Go to event list</a>");
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

        Client company name*: <select name="client_id">
            <?php foreach($clients as $c){ ?>
                <option value="<?php echo $c['id']; ?>" <?php if($event['client_id'] == $c['id']){ echo "selected"; } ?>>
                    <?php echo $c['company_name']; ?></option>
            <?php } ?>
        </select><br>

        Notification name*: <select name="notification_id">
            <?php foreach($notifications as $n){ ?>
                <option value="<?php echo $n['id']; ?>" <?php if($event['notification_id'] == $n['id']){ echo "selected"; } ?>>
                    <?php echo $n['name']; ?></option>
            <?php } ?>
        </select><br>

        <input type="hidden" name="start" value="<?php echo date("Y-m-d h:i:sa"); ?>" required>
        Frequency*: Every <input type="number" name="frequency" value="<?php echo $event['frequency'] ?>" required> day<br>
        Message*: <input type="text" name="message" value="<?php echo $event['message'] ?>" required><br><br>
        <a href='eventList.php'>Cancel</a>
        <button type="submit">Save</button>
    </form>

    </body>
    </html>

<?php echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; ?>