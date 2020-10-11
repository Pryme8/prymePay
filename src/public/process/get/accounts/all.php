<?php
    include($_SERVER['DOCUMENT_ROOT'].'/prymePay/dist/connect.php');
    
    $return=array(
        'responseType'  => 'Success',
        'rowCount'      => 0,
        'types'          => array()
    );

    if ($result = mysqli_query($link, "SELECT * FROM accounts")) {
   
        $return['rowCount'] = mysqli_num_rows($result);
        while ($row = $result->fetch_object()){
            $return['data'][] = $row;
        }
        
        /* free result set */
        mysqli_free_result($result);
        echo json_encode($return, true);
    }else{        
        $return['responseType'] = 'Failed';
        $return['data'] = mysqli_error($link);
    }
?>