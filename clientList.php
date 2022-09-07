<?php
    require_once "functions/functions.php";

    if(isset($_GET['value'])){
        $column = $_GET['column'];
        $value = $_GET['value'];
        $clients = searchClient($column, $value);
    } else {
        $column = "";
        $value = "";
        $clients = getClientsFromFile();
    }

    //print_r($clients);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Client list</title>
    </head>
    <body>

        <h1>Client list</h1>

        <a href="index.html">Front page</a><br><br>

        <form method="get">
            Search:
            <select name="column">
                <option value="company_name" <?php echo ($column=='company_name')?'selected':'';?>>Company name</option>
                <option value="business_number" <?php echo ($column=='business_number')?'selected':'';?>>Business number</option>
                <option value="first_name" <?php echo ($column=='first_name')?'selected':'';?>>First name</option>
                <option value="last_name" <?php echo ($column=='last_name')?'selected':'';?>>Last name</option>
                <option value="phone_number" <?php echo ($column=='phone_number')?'selected':'';?>>Phone number</option>
                <option value="cell_number" <?php echo ($column=='cell_number')?'selected':'';?>>Cell number</option>
                <option value="email" <?php echo ($column=='email')?'selected':'';?>>Email</option>
                <option value="website" <?php echo ($column=='website')?'selected':'';?>>Website</option>
                <option value="status" <?php echo ($column=='status')?'selected':'';?>>status</option>
            </select>
            <input type="text" name="value" placeholder="Value..." value="<?php echo $value; ?>">
            <button type="submit">Go</button>
            <a href="clientList.php">Show all clients</a>
        </form>

        <a href="addClient.php">Add client</a>

        <table>
            <tr>
                <th>Id</th>
                <th>Company name</th>
                <th>Business number</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Phone number</th>
                <th>Cell number</th>
                <th>Email</th>
                <th>Website</th>
                <th>Status</th>
                <th></th>
                <!--<th></th>-->
                <th></th>
            </tr>
            <?php foreach ($clients as $c){ ?>
            <tr>
                <td><?php echo $c['id'] ?></td>
                <td><?php echo $c['company_name'] ?></td>
                <td><?php echo $c['business_number'] ?></td>
                <td><?php echo $c['first_name'] ?></td>
                <td><?php echo $c['last_name'] ?></td>
                <td><?php echo $c['phone_number'] ?></td>
                <td><?php echo $c['cell_number'] ?></td>
                <td><?php echo $c['email'] ?></td>
                <td><?php echo $c['website'] ?></td>
                <td><?php echo $c['status'] ?></td>
                <td><a href="editClient.php?id=<?php echo $c['id'] ?>">Edit</a></td>
                <!--<td><a href="deleteClient.php?id=<?php echo $c['id'] ?>">Delete</a></td>-->
                <td><a href="changeClientStatus.php?id=<?php echo $c['id'] ?>">Change status</a></td>
            </tr>
            <?php } ?>
        </table>

    </body>
</html>

<?php echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>"; ?>