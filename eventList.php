<?php
    require_once "functions/functions.php";

    if(isset($_GET['value'])){
        $column = $_GET['column'];
        $value = $_GET['value'];
        $events = searchEvent($column, $value);
    } else {
        $column = "";
        $value = "";
        $events = getEventsFromFile();
    }

    //print_r($clients);

?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Event list</title>
    </head>
    <body>

    <h1>Event list</h1>

    <a href="index.html">Front page</a><br><br>

    <form method="get">
        Search:
        <select name="column">
            <option value="client_company_name" <?php echo ($column=='client_company_name')?'selected':'';?>>Client company name</option>
            <option value="notification_name" <?php echo ($column=='notification_name')?'selected':'';?>>Notification name</option>
            <option value="start" <?php echo ($column=='start')?'selected':'';?>>Start</option>
            <option value="frequency" <?php echo ($column=='frequency')?'selected':'';?>>Frequency</option>
            <option value="message" <?php echo ($column=='message')?'selected':'';?>>Message</option>
            <option value="status" <?php echo ($column=='status')?'selected':'';?>>status</option>
        </select>
        <input type="text" name="value" placeholder="Value..." value="<?php echo $value; ?>">
        <button type="submit">Go</button>
        <a href="eventList.php">Show all events</a>
    </form>

    <a href="addEvent.php">Add event</a>

    <table>
        <tr>
            <th>Id</th>
            <th>Client company name</th>
            <th>Notification name</th>
            <th>Start</th>
            <th>Frequency</th>
            <th>Message</th>
            <th>Status</th>
            <th></th>
            <!--<th></th>-->
            <th></th>
        </tr>
        <?php foreach ($events as $e){ ?>
            <tr>
                <td><?php echo $e['id'] ?></td>
                <?php $client = getClientById($e['client_id']); ?>
                <td><?php echo $client['company_name'] ?></td>
                <?php $notification = getNotificationById($e['notification_id']); ?>
                <td><?php echo $notification['name'] ?></td>
                <td><?php echo $e['start'] ?></td>
                <td>Every <?php echo $e['frequency'] ?> day</td>
                <td><?php echo $e['message'] ?></td>
                <td><?php echo $e['status'] ?></td>
                <td><a href="editEvent.php?id=<?php echo $e['id'] ?>">Edit</a></td>
                <!--<td><a href="deleteEvent.php?id=<?php echo $e['id'] ?>">Delete</a></td>-->
                <td><a href="changeEventStatus.php?id=<?php echo $e['id'] ?>">Change status</a></td>
            </tr>
        <?php } ?>
    </table>

    </body>
    </html>

<?php echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; ?>