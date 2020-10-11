<?php
    include($_SERVER['DOCUMENT_ROOT'].'/prymePay/dist/connect.php');
    
    $return=array(
        'responseType'  => 'Success'
    );
  
    $id = -1;
    if (isset($_GET) || !empty($_GET)){
        $id = (isset($_GET['id']))? $_GET['id'] : -1; 
    }

    if ($stmt = $link->prepare(
        "UPDATE records SET historic=1 WHERE id=?")
    ){
        $stmt->bind_param(
            "s", $id
        );    		
        $stmt->execute();
        $stmt->close();
    }else{
        $return['responseType'] = 'Failed';
        $return['sqlError'] = mysqli_error($link);
    }
    echo json_encode($return, true);
?>