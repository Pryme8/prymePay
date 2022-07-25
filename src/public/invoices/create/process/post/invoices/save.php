<?php
    include($_SERVER['DOCUMENT_ROOT'].'/prymePay/dist/connect.php');
    
    $return=array(
        'responseType'  => 'None'
    );
    $str_json = file_get_contents('php://input'); 
    $data = json_decode($str_json, true);

    function checkOk($var){
        return (isset($var) && !empty($var) && $var != "");
    }
    if(
        checkOk($data['accountId']) && 
        checkOk($data['paramsString']) 
    ){
        if ($stmt = $link->prepare(
            "INSERT INTO invoices (accountId, paramsString) VALUES (?,?)")
        ){	
            $stmt->bind_param(
                "is",        
                $data['accountId'],               
                $data['paramsString']
            );    		
            $stmt->execute();
            $return['newInvoiceId'] = $stmt->insert_id;
            $return['responseType'] = 'Success';
            $stmt->close();
        }else{
            $return['sqlError'] = mysqli_error($link);
        }
    }else{
        $return['responseType'] = "Error";
        $return['message'] = "Please check params.";        
    }
    echo json_encode($return);
?>