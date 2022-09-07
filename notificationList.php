<?php
    require_once "functions/functions.php";

    if(isset($_GET['value'])){
        $column = $_GET['column'];
        $value = $_GET['value'];
        $notifications = searchNotification($column, $value);
    } else {
        $column = "";
        $value = "";
        $notifications = getNotificationsFromFile();
    }

    //print_r($clients);

?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Notification list</title>
    </head>
    <body>

    <h1>Notification list</h1>

    <a href="index.html">Front page</a><br><br>

    <form method="get">
        Search:
        <select name="column">
            <option value="name" <?php echo ($column=='name')?'selected':'';?>>Name</option>
            <option value="type" <?php echo ($column=='type')?'selected':'';?>>Type</option>
            <option value="status" <?php echo ($column=='status')?'selected':'';?>>status</option>
        </select>
        <input type="text" name="value" placeholder="Value..." value="<?php echo $value; ?>">
        <button type="submit">Go</button>
        <a href="notificationList.php">Show all notifications</a>
    </form>

    <a href="addNotification.php">Add notification</a>

    <table>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Type</th>
            <th>Status</th>
            <th></th>
            <!--<th></th>-->
            <th></th>
        </tr>
        <?php foreach ($notifications as $n){ ?>
            <tr>
                <td><?php echo $n['id'] ?></td>
                <td><?php echo $n['name'] ?></td>
                <td><?php echo $n['type'] ?></td>
                <td><?php echo $n['status'] ?></td>
                <td><a href="editNotification.php?id=<?php echo $n['id'] ?>">Edit</a></td>
                <!--<td><a href="deleteNotification.php?id=<?php echo $n['id'] ?>">Delete</a></td>-->
                <td><a href="changeNotificationStatus.php?id=<?php echo $n['id'] ?>">Change status</a></td>
            </tr>
        <?php } ?>
    </table>

    </body>
    </html>

<?php echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; ?>