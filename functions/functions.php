<?php
//require_once "clientFunctions.php";
//require_once "notificationFunctions.php";
//require_once "eventFunctions.php";

const CLIENTS_FILE = "files/clients.csv";
const CLIENT_IDS = "files/client_ids.txt";

const EVENTS_FILE = "files/events.csv";
const EVENTS_IDS = "files/Events.txt";

const NOTIFICATIONS_FILE = "files/notifications.csv";
const NOTIFICATIONS_IDS = "files/notifications.txt";

function getClientId(){
    if(!file_exists(CLIENT_IDS)){
        touch(CLIENT_IDS);
        $handle = fopen(CLIENT_IDS, 'r+');
        $id=0;
    } else {
        $handle = fopen(CLIENT_IDS, 'r+');
        $id = fread($handle,filesize(CLIENT_IDS));
        settype($id,"integer");
    }
    rewind($handle);
    fwrite($handle,++$id);

    fclose($handle);
    return $id;
}

function getClientsFromFile(){
    $clients = array();
    $i=0;
    if(file_exists(CLIENTS_FILE)){
        $file = fopen(CLIENTS_FILE, "r");
        while ($data = fgetcsv($file, 1000, ",")) {
            /*for ($c=0; $c < count($data); $c++) {
                echo $data[$c] . "<br />\n";
            }*/

            $clients[$i]['id'] = $data[0];
            $clients[$i]['company_name'] = $data[1];
            $clients[$i]['business_number'] = $data[2];
            $clients[$i]['first_name'] = $data[3];
            $clients[$i]['last_name'] = $data[4];
            $clients[$i]['phone_number'] = $data[5];
            $clients[$i]['cell_number'] = $data[6];
            $clients[$i]['email'] = $data[7];
            $clients[$i]['website'] = $data[8];
            $clients[$i]['status'] = $data[9];
            $i++;
        }
        fclose($file);

        return $clients;
    }
    return null;
}

function getClientById($id){
    $clients = getClientsFromFile();

    foreach ($clients as $c){
        if($id == $c['id']){
            return $c;
        }
    }
    return null;
}

function searchClient($column, $value){
    $clients = getClientsFromFile();
    $output = array();

    $j=0;

    for ($i = 0; $i < count($clients); $i++){
        if(strpos(strtolower($clients[$i][$column]), strtolower($value)) !== false){
            $output[$j] = $clients[$i];
            $j++;
        }
    }

    return $output;

}

function saveClientsToFile($clients){
    if(file_exists(CLIENTS_FILE)) {
        $file = fopen(CLIENTS_FILE, 'w');
        foreach ($clients as $c) {
            fputcsv($file, $c);
        }
        fclose($file);
    }
}

function addClientsToFile($client){
    if(file_exists(CLIENTS_FILE)) {
        $file = fopen(CLIENTS_FILE, 'a');
        fputcsv($file, $client);
        fclose($file);
    }
}

function updateClient($client){
    $clients = getClientsFromFile();

    for ($i = 0; $i < count($clients); $i++){
        if($client['id'] == $clients[$i]['id']){
            $clients[$i]['company_name'] = $client['company_name'];
            $clients[$i]['business_number'] = $client['business_number'];
            $clients[$i]['first_name'] = $client['first_name'];
            $clients[$i]['last_name'] = $client['last_name'];
            $clients[$i]['phone_number'] = $client['phone_number'];
            $clients[$i]['cell_number'] = $client['cell_number'];
            $clients[$i]['email'] = $client['email'];
            $clients[$i]['website'] = $client['website'];
        }
    }

    saveClientsToFile($clients);
}

function updateClientStatus($id, $status){
    $clients = getClientsFromFile();

    for ($i = 0; $i < count($clients); $i++){
        if($id == $clients[$i]['id']){
            $clients[$i]['status'] = $status;
        }
    }

    saveClientsToFile($clients);
}

function addClient($client){
    $clients = getClientsFromFile();

    $i = count($clients);

    $clients[$i]['id'] = getClientId();
    $clients[$i]['company_name'] = $client['company_name'];
    $clients[$i]['business_number'] = $client['business_number'];
    $clients[$i]['first_name'] = $client['first_name'];
    $clients[$i]['last_name'] = $client['last_name'];
    $clients[$i]['phone_number'] = $client['phone_number'];
    $clients[$i]['cell_number'] = $client['cell_number'];
    $clients[$i]['email'] = $client['email'];
    $clients[$i]['website'] = $client['website'];
    $clients[$i]['status'] = $client['status'];

    addClientsToFile($clients[$i]);

    //echo $i;
}

function deleteClient($num){
    $clients = getClientsFromFile();

    $id = (int)$num;

    echo $id;

    //array_splice($clients, $id, 1);
    unset($clients[$id - 1]);

    //print_r($clients);

    saveClientsToFile($clients);
}

function clientInputValidation($client){
    $result = true;

    if(empty($client['company_name'])){
        $result = false;
    }

    if(empty($client['business_number']) || (! is_numeric($client['business_number']))){
        $result = false;
    }

    if(empty($client['first_name'])){
        $result = false;
    }

    if(empty($client['last_name'])){
        $result = false;
    }

    if(empty($client['phone_number']) || (! is_numeric($client['phone_number']))){
        $result = false;
    }

    if(empty($client['cell_number']) || (! is_numeric($client['cell_number']))){
        $result = false;
    }

    if(empty($client['email']) || (! filter_var($client['email'], FILTER_VALIDATE_EMAIL))){
        $result = false;
    }

    return $result;
}

function getEventsId(){
    if(!file_exists(EVENTS_IDS)){
        touch(EVENTS_IDS);
        $handle = fopen(EVENTS_IDS, 'r+');
        $id=0;
    } else {
        $handle = fopen(EVENTS_IDS, 'r+');
        $id = fread($handle,filesize(EVENTS_IDS));
        settype($id,"integer");
    }
    rewind($handle);
    fwrite($handle,++$id);

    fclose($handle);
    return $id;
}

function getEventsFromFile(){
    $events = array();
    $i=0;
    if(file_exists(EVENTS_FILE)){
        $file = fopen(EVENTS_FILE, "r");
        while ($data = fgetcsv($file, 1000, ",")) {
            /*for ($c=0; $c < count($data); $c++) {
                echo $data[$c] . "<br />\n";
            }*/

            $events[$i]['id'] = $data[0];
            $events[$i]['client_id'] = $data[1];
            $events[$i]['notification_id'] = $data[2];
            $events[$i]['start'] = $data[3];
            $events[$i]['frequency'] = $data[4];
            $events[$i]['message'] = $data[5];
            $events[$i]['status'] = $data[6];
            $i++;
        }
        fclose($file);

        return $events;
    }
    return null;
}

function getEventsFromFileByClientId($clientId){
    $events = array();
    $i=0;
    if(file_exists(EVENTS_FILE)){
        $file = fopen(EVENTS_FILE, "r");
        while ($data = fgetcsv($file, 1000, ",")) {
            /*for ($c=0; $c < count($data); $c++) {
                echo $data[$c] . "<br />\n";
            }*/
            if($data[1] == $clientId) {
                $events[$i]['id'] = $data[0];
                $events[$i]['client_id'] = $data[1];
                $events[$i]['notification_id'] = $data[2];
                $events[$i]['start'] = $data[3];
                $events[$i]['frequency'] = $data[4];
                $events[$i]['message'] = $data[5];
                $events[$i]['status'] = $data[6];
                $i++;
            }
        }
        fclose($file);

        return $events;
    }
    return null;
}

function getEventById($id){
    $events = getEventsFromFile();

    foreach ($events as $event){
        if($id == $event['id']){
            return $event;
        }
    }
    return null;
}

function searchEvent($column, $value){
    $events = getEventsFromFile();
    $clients = getClientsFromFile();
    $notifications = getNotificationsFromFile();

    if($column == 'client_company_name' || $column == 'notification_name') {
        for ($i = 0; $i < count($events); $i++) {
            for ($j = 0; $j < count($clients); $j++) {
                if ($events[$i]['client_id'] == $clients[$j]['id']) {
                    $events[$i]['client_company_name'] = $clients[$j]['company_name'];
                }
            }
            for ($k = 0; $k < count($notifications); $k++) {
                if ($events[$i]['notification_id'] == $notifications[$k]['id']) {
                    $events[$i]['notification_name'] = $notifications[$k]['name'];
                }
            }
        }
    }

    $output = array();

    $j=0;

    for ($i = 0; $i < count($events); $i++){
        if(strpos(strtolower($events[$i][$column]), strtolower($value)) !== false){
            $output[$j] = $events[$i];
            $j++;
        }
    }

    return $output;

}

function searchClientEvent($column, $value, $clientId){
    $events = getEventsFromFile();
    $notifications = getNotificationsFromFile();

    if($column == 'client_company_name' || $column == 'notification_name') {
        for ($i = 0; $i < count($events); $i++) {
            for ($k = 0; $k < count($notifications); $k++) {
                if ($events[$i]['notification_id'] == $notifications[$k]['id']) {
                    $events[$i]['notification_name'] = $notifications[$k]['name'];
                }
            }
        }
    }

    $output = array();

    $j=0;

    for ($i = 0; $i < count($events); $i++){
        if(strpos(strtolower($events[$i][$column]), strtolower($value)) !== false){
            if($clientId == $events[$i]['client_id']){
                $output[$j] = $events[$i];
                $j++;
            }
        }
    }

    return $output;

}

function saveEventsToFile($events){
    if(file_exists(EVENTS_FILE)) {
        $file = fopen(EVENTS_FILE, 'w');
        foreach ($events as $event) {
            fputcsv($file, $event);
        }
        fclose($file);
    }
}

function addEventsToFile($event){
    if(file_exists(EVENTS_FILE)) {
        $file = fopen(EVENTS_FILE, 'a');
        fputcsv($file, $event);
        fclose($file);
    }
}

function updateEvent($event){
    $events = getEventsFromFile();

    for ($i = 0; $i < count($events); $i++){
        if($event['id'] == $events[$i]['id']){
            $events[$i]['client_id'] = $event['client_id'];
            $events[$i]['notification_id'] = $event['notification_id'];
            $events[$i]['frequency'] = $event['frequency'];
            $events[$i]['message'] = $event['message'];
        }
    }

    saveEventsToFile($events);
    createEventFile($event);
}

function updateEventStatus($id, $status){
    $events = getEventsFromFile();

    for ($i = 0; $i < count($events); $i++){
        if($id == $events[$i]['id']){
            $events[$i]['status'] = $status;
        }
    }

    saveEventsToFile($events);
}

function updateEventStatusByClientId($clientId, $status){
    $events = getEventsFromFile();

    for ($i = 0; $i < count($events); $i++){
        if($clientId == $events[$i]['client_id']){
            $events[$i]['status'] = $status;
        }
    }

    saveEventsToFile($events);
}

function addEvent($event){
    $events = getClientsFromFile();

    $i = count($events);

    $events[$i]['id'] = getEventsId();
    $events[$i]['client_id'] = $event['client_id'];
    $events[$i]['notification_id'] = $event['notification_id'];
    $events[$i]['start'] = $event['start'];
    $events[$i]['frequency'] = $event['frequency'];
    $events[$i]['message'] = $event['message'];
    $events[$i]['status'] = $event['status'];

    addEventsToFile($events[$i]);
    createEventFile($events[$i]);

    //echo $i;
}

function deleteEvent($num){
    $events = getEventsFromFile();

    $id = (int)$num;

    echo $id;

    //array_splice($events, $id, 1);
    unset($events[$id - 1]);

    //print_r($events);

    saveEventsToFile($events);
}

function createEventFile($event){
    $client = getClientById($event['client_id']);

    $year = substr($event['start'],0,4);
    $month = substr($event['start'],5,2);
    $day = substr($event['start'],8,2);
    $id = $event['id'];

    $directory = "events/$year/$month/$day";
    $filename = "$directory/$id.txt";

    if(!file_exists($filename)){
        if(! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
        //touch($filename);
        $handle = fopen($filename, 'w');
    } else {
        $handle = fopen($filename, 'w');
    }

    $content = "";
    $content .= "event_id: ".$event['id']."\n";
    $content .= "client_name: ".$client['first_name']." ".$client['last_name']."\n";
    $content .= "company_name: ".$client['company_name']."\n";
    $content .= "cell_number: ".$client['cell_number']."\n";
    $content .= "email: ".$client['email']."\n";
    $content .= "message: ".$event['message']."\n";

    fwrite($handle,$content);

    fclose($handle);
}

function eventInputValidation($event){
    $result = true;

    if(empty($event['client_id']) || (! is_numeric($event['client_id']))){
        $result = false;
    }

    if(empty($event['notification_id']) || (! is_numeric($event['notification_id']))){
        $result = false;
    }

    if(empty($event['start'])){
        $result = false;
    }

    if(empty($event['frequency']) || (! is_numeric($event['frequency']))){
        $result = false;
    }

    if(empty($event['message'])){
        $result = false;
    }

    return $result;
}

function getNotificationsId(){
    if(!file_exists(NOTIFICATIONS_IDS)){
        touch(NOTIFICATIONS_IDS);
        $handle = fopen(NOTIFICATIONS_IDS, 'r+');
        $id=0;
    } else {
        $handle = fopen(NOTIFICATIONS_IDS, 'r+');
        $id = fread($handle,filesize(NOTIFICATIONS_IDS));
        settype($id,"integer");
    }
    rewind($handle);
    fwrite($handle,++$id);

    fclose($handle);
    return $id;
}

function getNotificationsFromFile(){
    $notifications = array();
    $i=0;
    if(file_exists(NOTIFICATIONS_FILE)){
        $file = fopen(NOTIFICATIONS_FILE, "r");
        while ($data = fgetcsv($file, 1000, ",")) {
            /*for ($c=0; $c < count($data); $c++) {
                echo $data[$c] . "<br />\n";
            }*/

            $notifications[$i]['id'] = $data[0];
            $notifications[$i]['name'] = $data[1];
            $notifications[$i]['type'] = $data[2];
            $notifications[$i]['status'] = $data[3];
            $i++;
        }
        fclose($file);

        return $notifications;
    }
    return null;
}

function getNotificationById($id){
    $notifications = getNotificationsFromFile();

    foreach ($notifications as $n){
        if($id == $n['id']){
            return $n;
        }
    }
    return null;
}

function searchNotification($column, $value){
    $notifications = getNotificationsFromFile();
    $output = array();

    $j=0;

    for ($i = 0; $i < count($notifications); $i++){
        if(strpos(strtolower($notifications[$i][$column]), strtolower($value)) !== false){
            $output[$j] = $notifications[$i];
            $j++;
        }
    }

    return $output;

}

function saveNotificationsToFile($notifications){
    if(file_exists(NOTIFICATIONS_FILE)) {
        $file = fopen(NOTIFICATIONS_FILE, 'w');
        foreach ($notifications as $n) {
            fputcsv($file, $n);
        }
        fclose($file);
    }
}

function addNotificationsToFile($notification){
    if(file_exists(NOTIFICATIONS_FILE)) {
        $file = fopen(NOTIFICATIONS_FILE, 'a');
        fputcsv($file, $notification);
        fclose($file);
    }
}

function updateNotification($notification){
    $notifications = getNotificationsFromFile();

    for ($i = 0; $i < count($notifications); $i++){
        if($notification['id'] == $notifications[$i]['id']){
            $notifications[$i]['name'] = $notification['name'];
            $notifications[$i]['type'] = $notification['type'];
        }
    }

    saveNotificationsToFile($notifications);
}

function updateNotificationStatus($id, $status){
    $notifications = getNotificationsFromFile();

    for ($i = 0; $i < count($notifications); $i++){
        if($id == $notifications[$i]['id']){
            $notifications[$i]['status'] = $status;
        }
    }

    saveNotificationsToFile($notifications);
}

function addNotification($notification){
    $notifications = getClientsFromFile();

    $i = count($notifications);

    $notifications[$i]['id'] = getNotificationsId();
    $notifications[$i]['name'] = $notification['name'];
    $notifications[$i]['type'] = $notification['type'];
    $notifications[$i]['status'] = $notification['status'];

    addNotificationsToFile($notifications[$i]);

    //echo $i;
}

function deleteNotification($num){
    $notifications = getNotificationsFromFile();

    $id = (int)$num;

    echo $id;

    //array_splice($notifications, $id, 1);
    unset($notifications[$id - 1]);

    //print_r($notifications);

    saveNotificationsToFile($notifications);
}

function notificationInputValidation($notification){
    $result = true;

    if(empty($notification['name'])){
        $result = false;
    }

    if(empty($notification['type'])){
        $result = false;
    }

    return $result;
}


echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>";