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
    new InputText(
        array(
            'id' => 'contactName:'.$_GET['id'],
            'label' => 'contactName',
            'value' => $_GET['contactName']
        )
    ); 
    new InputText(
        array(
            'id' => 'streetAddress:'.$_GET['id'],
            'label' => 'streetAddress',
            'value' => $_GET['streetAddress']
        )
    );
    new InputText(
        array(
            'id' => 'addressLine2:'.$_GET['id'],
            'label' => 'addressLine2',
            'value' => $_GET['addressLine2']
        )
    );
    new InputText(
        array(
            'id' => 'phone:'.$_GET['id'],
            'label' => 'phone',
            'value' => $_GET['phone']
        )
    );
?>
</div>