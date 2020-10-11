<?php
    include($_SERVER['DOCUMENT_ROOT'].'/prymePay/dist/connect.php');
    
    $return=array(
        'responseType'  => 'None'
    );

    $str_json = file_get_contents('php://input'); 
    $data = json_decode($str_json, true);

    if(isset($data['recordData']) && isset($data['id'])){
        if ($stmt = $link->prepare(
            "UPDATE records SET recordData=? WHERE id=?")
        ){	
            $stmt->bind_param(
            "si",
                $data['recordData'],
                $data['id']
            );    		
            $stmt->execute();
            $return['responseType'] = 'Success';
            $return['affected_rows'] = $stmt->affected_rows;
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