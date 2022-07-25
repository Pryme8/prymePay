<style>
.invoice-summary {
    border-top: 2px solid black;
    border-bottom: 1px solid black;
    height: 1.1in;
    position: relative;
}
.summary-block {
    position: absolute;
    right: 0;
    width: 28%;
    border-left: 16px solid black;
    border-bottom: 1px solid black;
    border-right: 1px solid black;
    white-space: nowrap;
}
.total-discount-label, .total-label, .invoice-total-discount, .invoice-total {
    font-size: 0.75em;
    width: 50%;
    display: inline-block;
    text-align: center;
}
.invoice-total-discount, .invoice-total{
    font-weight:bold;
    text-align: right;
    padding-right:6px;
}
.note:first-line {
  padding: 60px;
}
.summary-notes {
    position: absolute;
    left: 12px;
    top: 20%;
    right: 32%;
}

.invoice-due-label {
    position: absolute;
    right: 18%;
    font-size: 0.9em;
    top: 50%;
}
.invoice-due {
    position: absolute;
    right: 8%;
    font-size: 1.3em;
    top: 67%;
}
.notes-label{
    position: absolute;
    font-size: 0.8em;
    margin-top: 3px;
}
.notes{
    position: relative;
    display: block;    
}
.note{    
    position: absolute;
}

.thin-line{
    height: 1px;
    width: 100%;
    display: block;
    border-bottom: 1px solid black;
    position: absolute;
}
.thin-line:nth-child(3){
    margin-top: 1.2em;
}
.thin-line:nth-child(4){
    margin-top: 2.45em;
}
.thin-line:nth-child(5){
    margin-top: 3.85em;
}

.company-footer{
    position: relative;
    transform: scale(0.65) translate(25%, 0);
    top: 16px;
}

.company-bank{
    font-size: 0.8em;
}


</style>

<div class='invoice-summary'>
    <div class='summary-block'>
        <div class='total-labels'>
            <div class='total-discount-label'>Total Disc.</div>
            <div class='total-label'>Items Total</div>
        </div>
        <div class='invoice-totals'>
            <div class='invoice-total-discount'><?php echo '&#36;'.number_format($itemsDiscountTotal, 2, '.', ''); ?></div>
            <div class='invoice-total'><?php echo '&#36;'.number_format($itemsTotal, 2, '.', ''); ?></div>
        </div>
    </div>
    <div class='summary-notes'>
        <div class='notes-label'>Notes.</div>
        <div class='notes'>
            <span class='note'>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo $noteToClient; ?>
            </span>
        </div>
        <div class='thin-line'></div>
        <div class='thin-line'></div>
        <div class='thin-line'></div>
    </div>
    <div class='invoice-due-label'>Due Date:</div>
    <div class='invoice-due'>Upon Receipt</div>
</div>

<div class='company-footer'>
    <div class='company-logo'>
    </div>
    <div class='company-data'>
        <div class='company-name'>
            PrymeDesign, LLC
        </div>
        <div class='thin-line-break'></div>
        <div class='company-agent'>
            &nbsp 1903 B St. Apt B<br>
            &nbsp Eureka CA, 95501<br>
            &nbsp EIN 85-2920103<br>
            <div class='company-bank'>
            &nbsp BANK: JPMORGAN CHASE BANK, N.A.<br>
            &nbsp SWIFT: CHASUS33<br>
            &nbsp ACCOUNT NAME: PrymeDesign LLC<br>
            &nbsp ACCOUNT NUMBER: 658028318<br>
            &nbsp ROUTING NUMBER: 322271627<br>
            </div>
        </div>
    </div>
</div>