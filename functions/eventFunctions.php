<?php
    const EVENTS_FILE = "files/events.csv";
    const EVENTS_IDS = "files/Events.txt";
    
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

echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>";