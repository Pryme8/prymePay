<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PrymePay</title>
    <meta name="description" content="Quickly Keep track of hours and make Pryme Invoices!">
    <meta name="PrymeDesign LLC">    
    <style>
    html {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        font-family: 'Signika', sans-serif;
        font-size: 20px;
    }
    *, *:before, *:after {
        -webkit-box-sizing: inherit;
        -moz-box-sizing: inherit;
        box-sizing: inherit;
    }  
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
            display: block;            
        }

        .record-item{
            position:relative;
        }

        .record-item textarea{
            resize: none;
        }

        .record-item input{
            font-size: 0.9em;
            text-align:center;
        }

        .record-item:nth-child(even){
            background:gainsboro;
        }

        .record-item-head {
            display: inline-block;
            width: calc(100% / 8);
            margin: 0;
            padding: 0.2em;
            border-right: 1px solid gray;
        }

        .record-item-head:last-child {
            border-right:none;
        }
        .record-item-header {
            border-bottom: 1px solid;
            border-top: 3px solid;
            margin-top: 1em;
            padding-top: 0.5em;
        }

        .record-item-field, .record-item-id {
            display: inline-block;
            width: calc(100% / 8);
            margin: 0;
            padding: 0.2em;
            vertical-align: bottom;
            height: 3em;
            text-align: right;
        }
        .record-item-id {    
            text-align:right;
        }        
        .record-item-field > * {
            padding: 0;
            margin: 0;
            width: 100%;
            height: 100%;
        }       

        .locked{
            pointer-events:none;
            opacity: 0.5;
            background:rgb(120,160,120);
        }

        .sortable.descending::after{
            content: '\21E9';
        }
        .sortable.ascending::after{
            content: '\21E7';
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