<?php
class InputText{
    function __construct($params){
        $id = $params['id'];
        $value = $params['value'];
        echo "<div>";
        if(isset($params['label'])){
            echo "<span>".$params['label']." : </span>";
        }
        echo "<input type='text' id='$id' value='$value' /></div>";
    }
}
?>

<div class='account-info'>
<?php
    echo "<div>id : ".$_GET['id']."</div>";
    new InputText(
        array(
            'id' => 'accountName:'.$_GET['id'],
            'label' => 'accountName',
            'value' => $_GET['accountName']
        )
    );
    new InputText(
        array(
            'id' => 'accountDisplayName:'.$_GET['id'],
            'label' => 'accountDisplayName',
            'value' => $_GET['accountDisplayName']
        )
    );
?>
<div class='account-address' load-action='Account-Address.LOAD'></div> 
<?php
    include('./records.php');
?>

</div>