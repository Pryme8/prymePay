<style>
    .invoice-header, .company-header{
        position:relative;
    }

    .invoice-header{
        height: 0.85in;
        border-bottom: 2px solid;
    }

    .invoice-date{
        position: absolute;
        right: 0;
        font-size: 1.1em;
        font-weight: bold;
    }

    .invoice-title{
        position: absolute;
        right: 0;
        bottom: 0.6px;
        font-size: 2em;
    }

    .company-logo{
        display: block;
        background-image: url(assets/logo.jpg);
        background-size: 100% auto;
        background-repeat: no-repeat;
        width: 40px;
        height: 60px;
        position: absolute;
        left: 0;
        top: 0;
    }

    .company-name{
        font-size: 1.65em;
        margin-left: -3px;
        height: 1.05em;
        font-weight: bold;
        transform: scaleY(1.2);
        border-bottom: 1px solid;
        text-shadow: 3px 0px #fff, -3px 0px #fff, -3px -2px #fff;
    }

    .company-agent{
        padding-top: 0.1em;
        font-size: 1.3em;
        margin-left: -3px;
    }

    .company-data{
        left: 46px;
        position: absolute;
    }

    .invoice-client-data{
        position: absolute;
        height: 1.5in;
        width: 100%;
        top: 0.9in;
        border-top: 1px solid black;
        border-bottom: 1px solid black;
        display: block;
    }

    .client-data-labels{
        position: absolute;
        left: 0;
        width: 15%;
        text-align: right;
        padding-top: 0.25in;
    }
    .client-data-label{

    }
    .client-data-values{
        position: absolute;
        left: 15%;
        width: 85%;        
        padding-top: 0.25in;
        padding-left: 0.65em;
    }   
    .client-data{

    }

    .invoice-sub-header{
        position: absolute;
        height: 0.8in;
        width: 100%;
        top: 2.4in;
        display: block;
        white-space: nowrap;
    }

    .invoice-sub-section {
        width: calc(33.3% - 2px);
        display: inline-block;
        height: 100%;
    }

    .sub-section-title {
        font-size: 0.9em;
        padding-top: 0.19in;
        border-bottom: 1px solid black;
    }

    .sub-section-block {
        font-size: 0.9em;
        padding-top: 0.36in;
        border-bottom: 1px solid black;
    }

</style>
<div class='invoice-header'>
    <div class='company-header'>
        <div class='company-logo'>

        </div>
        <div class='company-data'>
            <div class='company-name'>
                PrymeDesign, LLC
            </div>
            <div class='thin-line-break'></div>
            <div class='company-agent'>
                Andrew V Butt Sr.
            </div>
        </div>
    </div>

    <div class='invoice-date'><?php echo $dateOfInvoice; ?></div>

    <div class='invoice-title'>Sales Receipt</div>

    <div class='thick-line-break'></div>

    <div class='invoice-client-data'>
        <div class='client-data-labels'>
            <div class='client-contact-label'>Client:</div>
        </div>
        <div class='client-data-values'>
            <div class='client-data' name='contact-name'><?php echo $accountDetails['contactName'];?></div>
            <div class='client-data' name='client-name'><?php echo $accountName; ?></div>
            <div class='client-data' name='client-address-0'><?php echo $accountDetails['streetAddress']; ?></div>
            <div class='client-data' name='client-address-1'><?php echo $accountDetails['addressLine2']; ?></div>
            <div class='client-data' name='client-phone'><?php echo $accountDetails['phone']; ?></div>
        </div>       
    </div> 

    <div class='invoice-sub-header'>
        <div class='invoice-sub-section'>
            <div class='sub-section-title'>Payment Method</div>
            <div class='sub-section-block'></div>
        </div>
        <div class='invoice-sub-section'>
            <div class='sub-section-title'>Check/Transaction No.</div>
            <div class='sub-section-block'></div>
        </div>
        <div class='invoice-sub-section'>
            <div class='sub-section-title'>Job</div>
            <div class='sub-section-block'></div>
        </div>
    </div>
</div>
