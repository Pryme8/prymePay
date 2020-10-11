<?php
    $id = $_GET['id'] || false;
    $label = $_GET['label'] || false;
    $value = $_GET['value'] || '';
    if($id){
        return;
    }   
?>

<div class="input text">    
    <?php
        if($label){
            echo '<div class="input-label">$label</div>;';
        }
    ?>    
    <div class="input-input">
    <input type='text' id=<?php echo $id;?> value=<?php echo $value;?>/>
    </div> 
</div>