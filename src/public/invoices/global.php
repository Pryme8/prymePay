<?php
    $data = $_GET;
    $page = 'menu';
    if(isset($data['page'])){
        $page = $data['page'];
        if($page !== 'new' && $page !=='menu'){
            echo "ERROR!";
            exit(); 
        }
    }

    if(!isset($data['accountId'])){
        echo "ERROR!";
        exit();
    }

    $accountId = $data['accountId'];

    $range = false;
    if(isset($data['range'])){
        $range = $data['range'];
    }

    $recordIds = false;
    if(isset($data['recordIds'])){
        $recordIds = json_decode($data['recordIds'], false);
    }

    $showInvoiced = 0;
    if(isset($data['showInvoiced'])){
        $showInvoiced = $data['showInvoiced'];
    }

    $dateOfInvoice = date("m/d/Y");
    if(isset($data['dateOfInvoice'])){
        $dateOfInvoice = $data['dateOfInvoice'];
    }

    $noteToClient = false;
    if(isset($data['noteToClient'])){
        $noteToClient = $data['noteToClient'];
    }
?>

<?php
    include($_SERVER['DOCUMENT_ROOT'].'/prymePay/dist/connect.php');  
    $accountData=array();    
    if ($result = mysqli_query($link, "SELECT * FROM accounts WHERE id=$accountId AND historic=0")){
        if(!mysqli_num_rows($result)){
            echo "No Accounts!";
            exit();
        }
        while ($row = $result->fetch_object()){
            $accountData['return'][] = $row;
        }
        mysqli_free_result($result);        
    }else{
        print_r(mysqli_error($link));
    }
    $accountData = $accountData['return'][0];
    $accountName = $accountData->accountDisplayName;
    $accountDetails = json_decode($accountData->accountData, true);    
    foreach($accountDetails as $k => $v){
        $accountDetails[$k] = htmlspecialchars_decode(urldecode($v));
    }
    $_recordData = array();

    if($page == 'new'){
        $query = "SELECT id, recordData FROM records WHERE accountId=$accountId AND invoiced=$showInvoiced AND historic=0";

        if($recordIds){
            foreach($recordIds as $rid){
                $query = "SELECT id, recordData FROM records WHERE accountId=$accountId AND id IN (" . implode(',', array_map('intval', $recordIds)) . ")";
            }
        }

        if($range){
            //make range query
        }

        if ($result = mysqli_query($link, $query)){
            if(!mysqli_num_rows($result)){
                echo "ERROR!";
                exit();
            }
            while ($row = $result->fetch_object()){
                $_recordData['records'][] = $row;
            }
            mysqli_free_result($result);        
        }else{
            print_r(mysqli_error($link));
        }
        
        if(!$noteToClient){
            $noteToClient ="Thank you for you business!";
        }
    }

    $recordData = array();
    $_recordIds = array();
    foreach($_recordData['records'] as $k => $v){
        $record = json_decode($v->recordData, true);
        $_recordIds[] = $v->id;
        foreach($record as $rk => $rv){
            $record[$rk] = htmlspecialchars_decode(urldecode($rv));
        }
        array_push($recordData, $record);    
    }
    // $_GET['recordIds'] = json_encode($_recordIds);
    // $newUrl =  $_SERVER['PHP_SELF']."?".http_build_query($_GET);
    $saveLink = htmlspecialchars_decode(urlencode("page=view&accountId=$accountId&dateOfInvoice=$dateOfInvoice&invoiceIds=".json_encode($_recordIds)."&noteToClient=$noteToClient"));
?>