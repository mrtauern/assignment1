<?php

    const NOTIFICATIONS_FILE = "files/notifications.csv";
    const NOTIFICATIONS_IDS = "files/notifications.txt";

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