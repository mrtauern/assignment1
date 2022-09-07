<?php
    const CLIENTS_FILE = "files/clients.csv";
    const CLIENT_IDS = "files/client_ids.txt";

    /*function loadClientsFromFile(){
        $clients = array();
        $file = fopen("files/clients.csv","r+");
        $data = fgetcsv($file);
        $i=0;
        foreach ($data as $f){
            $csv[] = explode(',',$f);

            $clients[$i]['id'] = $csv[$i][0];
            $clients[$i]['company_name'] = $csv[$i][1];
            $clients[$i]['business_number'] = $csv[$i][2];
            $clients[$i]['first_name'] = $csv[$i][3];
            $clients[$i]['last_name'] = $csv[$i][4];
            $clients[$i]['phone_number'] = $csv[$i][5];
            $clients[$i]['cell_number'] = $csv[$i][6];
            $clients[$i]['website'] = $csv[$i][7];

            $i++;

            print_r($csv);
        }

        return $clients;
    }*/

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

echo "<a href='/folder_view/vs.php?s=" . __FILE__ . "' target='_blank'>View Source</a>";