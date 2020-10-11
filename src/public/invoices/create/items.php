<style>
.invoice-items {
    margin-top: 2.4in;
    display: block;
}

.items-headers {
    display: block;
    position:relative;
    border-bottom: 1px solid black;
}
.items-header, .field {
    display: inline-block;
    font-size: 0.7em;
}
.item{
    padding-bottom:3px;
    padding-top:3px;
}
.item:nth-child(odd){
    background:rgb(200,200,210);
}
.field{
    vertical-align: top;
}
.col-0{
    width:8%;
}
.col-1{
    width:10%;
}
.col-2{
    width:10%;
}
.col-3{
    width:36%;
}
.col-4{
    width:10%;
}
.col-5{
    width:10%;
}
.col-6{
    width:12%;
}

.item .col-0{
    text-align:center;
}
.item .col-1{
    width:11.5%;
}
.item .col-3{
    width:37%;
}
.item .col-4{
    width:10.5%;
}
.item .col-5{
    width:10.5%;
    text-align:center;
}
.item .col-6{
    text-align:center;
}


</style>

<div class='invoice-items'>
    <div class='items-headers'>
        <div class='items-header col-0'>Item #</div>
        <div class='items-header col-1'>Date</div>
        <div class='items-header col-2'>Hours</div>
        <div class='items-header col-3'>Description</div>
        <div class='items-header col-4'>Rate</div>
        <div class='items-header col-5'>Discount</div>
        <div class='items-header col-6'>Item Total</div>
    </div>
<?php 
    class Field{
        function __construct($params){
            $this->col = $params['col'];
            $this->value = $params['value'];             
        }

        function print(){
            $col = $this->col;
            $value = $this->value;
            echo "<div class='field col-$col'>$value</div>";
        }
    }
    
?>

<?php
    $i = 0;
    $itemsTotal = 0;
    $itemsDiscountTotal = 0;
    echo "<div class='items'>";
    foreach($recordData as $record){
        echo "<div class='item'>";
            (new Field(
                array(
                    'col' => 0,
                    'value' => $i    
                )
            ))->print(); 

            $dateOf = explode( '-', $record['date']);
            $year = str_split( $dateOf[0] );
            (new Field(
                array(
                    'col' => 1,
                    'value' => $dateOf[1].'/'.$dateOf[2].'/'.$year[2].$year[3]
                )
            ))->print();            
           
            $hours = round(abs(strtotime($record['endedOn']) - strtotime($record['startedOn'])) / 3600,2);
            (new Field(
                array(
                    'col' => 2,
                    'value' => $hours
                )
            ))->print();

            (new Field(
                array(
                    'col' => 3,
                    'value' => $record['description']
                )
            ))->print();

            (new Field(
                array(
                    'col' => 4,
                    'value' => '&#36;'.$record['rate']
                )
            ))->print();

            $discount = '-';
            if($record['discount']!=='0.00'){
                $discount = '&#36;'.$record['discount'];
            }
            (new Field(
                array(
                    'col' => 5,
                    'value' => $discount
                )
            ))->print();

            $total = '0.00';
            $charge = floatval($record['rate'])*floatval($hours);
            $discountAmount = floatval($record['discount']);
            $itemsDiscountTotal+=$discountAmount;            
            if($charge-$discountAmount>0){
                $total = ($charge-$discountAmount);
            }  
            $itemsTotal+=$total;     
            (new Field(
                array(
                    'col' => 6,
                    'value' => '&#36;'.number_format($total, 2, '.', '')
                )
            ))->print();
            

        echo "</div>";
        $i++;
    }
    echo "</div>";
?>
</div>