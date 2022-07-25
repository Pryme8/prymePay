<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PrymePay - Invoices</title>
    <meta name="description" content="Quickly Keep track of hours and make Pryme Invoices!">
    <meta name="PrymeDesign LLC">
    <link href="https://fonts.googleapis.com/css2?family=Signika:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        html {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        font-family: 'Signika', sans-serif;
        }
        *, *:before, *:after {
        -webkit-box-sizing: inherit;
        -moz-box-sizing: inherit;
        box-sizing: inherit;
        -webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
        color-adjust: exact !important;                 /*Firefox*/
        } 

        @media screen {
            .invoice{
                padding: 0.5in;
                width:7in;
                height:9.5in;
                left:50%;
                top:50%;
                margin:auto;
                display:block;
                -webkit-box-shadow: 2px 2px 7px 3px rgba(60,60,60,0.4);
                box-shadow: 2px 2px 7px 3px rgba(60,60,60,0.4);
            }
            .invoice-menu{
                text-align:center;
                padding-top:1em;
            }
        }

        /* print styles */
        @media print {
            .invoice{
                margin: 0.5in;
                size:7in 9.5in;
            }
            
            .item:nth-child(odd){
                box-shadow: inset 0 0 0 1000px rgb(200,200,210);
            }
            .invoice-menu{
                display:none;
            }
        }
    </style>
</head>
    <body>
        <?php
            include('../global.php');
        ?>

        <div class="invoice">
            <?php  
                include('./header.php');
                include('./items.php');
                include('./summary.php');
            ?>
        </div>
        <div class='invoice-menu'>
            <a href='#' click-action="Invoice.SAVE" params-string="<?php echo $saveLink; ?>" account-id="<?php echo $accountId; ?>">Save</a><span> | </span> 
            <a href='#'>Export</a><span> | </span>
            <a href='#'>Save and Export</a>
        </div>
        <script src='../../js/pay.js'></script>
    </body>
</html>



