<?php
    include($_SERVER['DOCUMENT_ROOT'].'/prymePay/dist/connect.php');
    
    $return=array(
        'responseType'  => 'Success',
        'rowCount'      => 0,
        'data'          => array()
    );

    unset($sql);
    $id = -1;
    if (isset($_GET) || !empty($_GET)){
        $id = (isset($_GET['id']))? $_GET['id'] : -1; 
    }  

    if ($result = mysqli_query($link, "SELECT id, accountData FROM accounts WHERE id=$id")) {
   
        $return['rowCount'] = mysqli_num_rows($result);
        while ($row = $result->fetch_object()){
            $return['data'][] = $row;
        }        
        /* free result set */
        mysqli_free_result($result);        
    }else{        
        $return['responseType'] = 'Failed';
        $return['data'] = mysqli_error($link);
    }

    echo json_encode($return, true);
?>