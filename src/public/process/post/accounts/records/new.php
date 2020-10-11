<?php
    include($_SERVER['DOCUMENT_ROOT'].'/prymePay/dist/connect.php');
    
    $return=array(
        'responseType'  => 'Error',
        'newRecordId'  => -1
    );

    $str_json = file_get_contents('php://input'); 
    $data = json_decode($str_json, true);

    if(isset($data['recordData']) && isset($data['accountId'])){
        if ($stmt = $link->prepare(
            "INSERT INTO records (accountId, recordData) VALUES (?,?)")
        ){	
            $stmt->bind_param(
            "is",        
                $data['accountId'],
                $data['recordData']
            );    		
            $stmt->execute();
            $return['newRecordId'] = $stmt->insert_id;
            $return['responseType'] = 'Success';
            $stmt->close();
        }else{
            $return['responseType'] = "Error";
            $return['errorMessage'] = mysqli_error($link);
        }
    }else{
        $return['responseType'] = "Error";
        $return['errorMessage'] = "Not Enough Data!";
    }

    echo json_encode($return, true);
?>