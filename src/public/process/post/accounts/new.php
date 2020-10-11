<?php
    include($_SERVER['DOCUMENT_ROOT'].'/prymePay/dist/connect.php');
    
    $return=array(
        'responseType'  => 'Error',
        'newAccountId'  => -1
    );

    $str_json = file_get_contents('php://input'); 
    $data = json_decode($str_json, true);

    foreach( $data['other'] as $key => $value){
        $data['other'][$key] = urlencode(htmlspecialchars($value));
    }
    if ($stmt = $link->prepare(
        "INSERT INTO accounts (accountName, accountDisplayName, accountData) VALUES (?,?,?)")
    ){	
        $otherData = json_encode($data['other']);
        $stmt->bind_param(
        "sss",        
            $data['names']['accountName'],
            $data['names']['accountDisplayName'],
            $otherData
        );    		
        $stmt->execute();
        $return['newAccountId'] = $stmt->insert_id;
        $return['responseType'] = 'Success';
        $stmt->close();
    }else{
        $return['sqlError'] = mysqli_error($link);
    }

    echo json_encode($return, true);
?>