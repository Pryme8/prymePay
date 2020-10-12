<?php
class InputText{
    function __construct($params){
        $id = $params['id'];
        $value = $params['value'];
        $type = $params['type'] || 'text';
        $fieldId = $params['id'];
        echo "<div>";
            if(isset($params['label'])){
                echo "<span>".$params['label']." : </span>";
            }
            echo "<input id='$id' type='$type' fieldId='$fieldId' ";
            if($value != ''){
                echo "value='$value'";
            }
            echo " />";
        echo "</div>";
    }
}
?>

<div class='new-account'>
<h3>New Account</h3>
<form id='new-account-names-form'>
<?php
    new InputText(
        array(
            'id' => 'accountName',
            'label' => 'accountName',
            'value' => '',
            'type'  => 'text'      
        )
    );
    new InputText(
        array(
            'id' => 'accountDisplayName',
            'label' => 'accountDisplayName',
            'value' => '',
            'type'  => 'text'
        )
    );
?>
</form>
<form id='new-account-other-form'>
<?php
    new InputText(
        array(
            'id' => 'contactName',
            'label' => 'contactName',
            'value' => '',
            'type'  => 'text'
        )
    ); 
    new InputText(
        array(
            'id' => 'streetAddress',
            'label' => 'streetAddress',
            'value' => '',
            'type'  => 'text'
        )
    );
    new InputText(
        array(
            'id' => 'addressLine2',
            'label' => 'addressLine2',
            'value' => '',
            'type'  => 'text'    
        )
    );
    new InputText(
        array(
            'id' => 'phone',
            'label' => 'phone',
            'value' => '',
            'type'  => 'text'    
        )
    );
?>
</form>
<hr>
<a href='#' click-action="Account-New.ACCEPT">Accept</a> | <a href='#' click-action="Close-Parent-Popup">Cancel</a>
</div>