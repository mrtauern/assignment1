<?php
    require_once "functions/functions.php";

    $clients = getClientsFromFile();

    if(isset($_GET['clientId'])){
        $clientId = $_GET['clientId'];

        if(isset($_GET['value'])){
            $column = $_GET['column'];
            $value = $_GET['value'];
            $events = searchClientEvent($column, $value, $clientId);
        } else {
            $column = "";
            $value = "";
            $events = getEventsFromFileByClientId($clientId);
        }
    } else {
        $clientId = 0;
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

    <h1>Your events</h1>

    <a href="index.html">Front page</a><br><br>

    <form method="get" action="">
        Select company: <select name="clientId">
            <?php foreach ($clients as $c){ ?>
                <option value="<?php echo $c['id'] ?>" <?php if($c['id'] == $clientId){echo "selected";} ?>><?php echo $c['company_name'] ?></option>
            <?php } ?>
        </select>
        <button type="submit">Submit</button>
    </form>

    <?php if(isset($_GET['clientId'])){ ?>

        <form method="get">
            <input type="hidden" name="clientId" value="<?php echo $clientId; ?>">
            Search:
            <select name="column">
                <option value="notification_name" <?php echo ($column=='notification_name')?'selected':'';?>>Notification name</option>
                <option value="start" <?php echo ($column=='start')?'selected':'';?>>Start</option>
                <option value="frequency" <?php echo ($column=='frequency')?'selected':'';?>>Frequency</option>
                <option value="message" <?php echo ($column=='message')?'selected':'';?>>Message</option>
                <option value="status" <?php echo ($column=='status')?'selected':'';?>>status</option>
            </select>
            <input type="text" name="value" placeholder="Value..." value="<?php echo $value; ?>">
            <button type="submit">Go</button>
            <a href="clientEventManager.php?clientId=<?php echo $clientId; ?>">Show all client events</a>
        </form>

        <a href="changeAllClientEventStatus.php?clientId=<?php echo $clientId; ?>">Change client status</a><br><br>

        <?php
            $client = getClientById($clientId);
        ?>

        Current client status: <?php echo $client['status']; ?><br><br>

        <a href="addClientEvent.php?clientId=<?php echo $clientId; ?>">Add event</a>

        <table>
            <tr>
                <th>Id</th>
                <th>Notification name</th>
                <th>Start</th>
                <th>Frequency</th>
                <th>Message</th>
                <th>Status</th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach ($events as $e){ ?>
                <tr>
                    <td><?php echo $e['id'] ?></td>
                    <?php $notification = getNotificationById($e['notification_id']); ?>
                    <td><?php echo $notification['name'] ?></td>
                    <td><?php echo $e['start'] ?></td>
                    <td>Every <?php echo $e['frequency'] ?> day</td>
                    <td><?php echo $e['message'] ?></td>
                    <td><?php echo $e['status'] ?></td>
                    <td><a href="editClientEvent.php?id=<?php echo $e['id'] ?>&clientId=<?php echo $clientId; ?>">Edit</a></td>
                    <td><a href="changeClientEventStatus.php?id=<?php echo $e['id'] ?>&clientId=<?php echo $clientId; ?>">Change status</a></td>
                </tr>
            <?php } ?>
        </table>

    <?php } ?>

    </body>
    </html>

<?php echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; ?>