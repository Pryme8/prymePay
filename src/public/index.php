<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PrymePay</title>
    <meta name="description" content="Quickly Keep track of hours and make Pryme Invoices!">
    <meta name="PrymeDesign LLC">    
    <style>
        .popup{
            position: fixed;
            top: 50%;
            background: white;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 1em;
            border: 1px solid gainsboro;
        }

        .record-item-header, .record-item{
            display: table-row;
    
        }

        .record-item{
            position:relative;
        }

        .record-item-head {
            display: table-cell;
            width: 10%;
            margin: 0;
            padding: 0.2em;
        }

        .record-item-field {
            display: table-cell;
            width: 10%;
            margin: 0;
            padding: 0.2em;
            vertical-align: bottom;
            height: 1.5em;
        }
        .record-item-field > * {
            padding: 0;
            margin: 0;
            width: 100%;
            height: 100%;
        }

        .record-item-id {
            display: table-cell;
            width: 5%;
            margin: 0;
            padding: 0.2em;
            vertical-align: bottom;
            height: 1.5em;
            text-align:right;
        }

        .locked{
            pointer-events:none;
            opacity: 0.5;
            background:rgb(120,160,120);
        }
    </style>
</head>
<body>
<?php
    include_once('./modules/page/header.php');
    include_once('./modules/page/body.php');
?>
<script src='./js/pay.js'></script>
</body>
</html>