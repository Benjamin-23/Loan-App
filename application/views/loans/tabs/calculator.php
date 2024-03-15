<script src="http://momentjs.com/downloads/moment.js"></script>


<div style="text-align: center">
    <h3><?= $this->lang->line('loan_type_payment_sched'); ?></h3>
    <div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
    <ul id="error_message_box"></ul>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">
    Loan Amount:
    </label>
    <div class="col-sm-2">
        <input type="hidden" id="amount" name="amount" value="<?=$loan_info->loan_amount;?>" />
        <?php
        echo form_input(
                array(
                    'name' => 'amount1',
                    'id' => 'amount1',
                    'value' => $loan_info->loan_amount,
                    'class' => 'form-control',
                    'type' => 'number',
                    'step' => 'any',
                )
        );
        ?>
    </div>
</div>


<div class="hr-line-dashed"></div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        Interest Rate:
    </label>
    <div class='col-sm-2'>
        <div class="input-group">
            <input type="text" class="form-control" name="interest_rate" id="interest_rate" value="<?= $c_payment_scheds["interest_rate"] ?>" />
            <span class="input-group-addon">%</span>
        </div>
    </div>
</div>

<div class="hr-line-dashed"></div>

<div class="form-group">
    <label class="col-sm-2 control-label">
        <?= $this->lang->line('loan_type_term'); ?>:
    </label>
    <div class="col-sm-2">
        <input type="text" name="term" id="term" class="form-control" value="<?= $c_payment_scheds["term"]; ?>" />
    </div>
    <div class="col-sm-2">
        <select class="form-control" name="term_period" id="term_period">
            <option value="day" <?= $c_payment_scheds["term_period"] === "day" ? 'selected="selected"' : ''; ?>><?= $this->lang->line('common_day'); ?></option>
            <option value="week" <?= $c_payment_scheds["term_period"] === "week" ? 'selected="selected"' : ''; ?>><?= $this->lang->line('common_week'); ?></option>
            <option value="month" <?= $c_payment_scheds["term_period"] === "monthly" ? 'selected="selected"' : ''; ?>><?= $this->lang->line('common_month'); ?></option>
            <option value="year" <?= $c_payment_scheds["term_period"] === "yearly" ? 'selected="selected"' : ''; ?>><?= $this->lang->line('common_year'); ?></option>
        </select>
    </div>
</div>

<div class="hr-line-dashed"></div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        Start Date:
    </label>
    <div class='col-sm-2'>
        <div class="input-group date">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>                                        
            <input type="text" class="form-control" name="start_date" id="start_date" value="" />
        </div>
    </div>
</div>


<div class="hr-line-dashed"></div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        Payment Amount:
    </label>
    <div class="col-sm-2">
        <div id="loan-total-amount">0.00</div>
    </div>
</div>
<div class="hr-line-dashed"></div>


<div class="form-group">
    <label class="col-sm-2 control-label">
        &nbsp;
    </label>
    <div class="col-sm-4">
        <button class="btn btn-primary" type="button" id="btn-loan-calculator">Calculate</button>
    </div>
</div>
<div class="hr-line-dashed"></div>

<div class="form-group">
    <label class="col-sm-2 control-label"> &nbsp; </label>
    <div class="col-sm-10">
        <div id="div-payment-scheds">
            
            <?php if (count($c_payment_scheds["payment_breakdown"]["balance"]) > 0): ?>
                <table class="table table-bordered">
                    <tr>
                        <td style="text-align:center">Date</td>
                        <td style="text-align:center">Payment Amount</td>
                        <td style="text-align:center">Principal Amount</td>
                        <td style="text-align:center">Interest Amount</td>
                        <td style="text-align:center">Balance Owed</td>
                    </tr>
                    <?php for ($i = 0; $i < count($c_payment_scheds["payment_breakdown"]["balance"]); $i++): ?>
                        <tr>
                            <td><input type="hidden" name="payment_date[]" class="form-control" value="<?= $c_payment_scheds["payment_breakdown"]["schedule"][$i]; ?>" /><?= $c_payment_scheds["payment_breakdown"]["schedule"][$i]; ?></td>
                            <td><input type="hidden" name="payment_amount[]" class="form-control" value="<?= $c_payment_scheds["payment_breakdown"]["amount"][$i]; ?>"/><?= $c_payment_scheds["payment_breakdown"]["amount"][$i]; ?></td>
                            <td><?= $c_payment_scheds["payment_breakdown"]["amount"][$i] - $c_payment_scheds["payment_breakdown"]["interest"][$i]; ?></td>
                            <td><input type="hidden" name="payment_interest[]" class="form-control" value="<?= $c_payment_scheds["payment_breakdown"]["interest"][$i]; ?>"/><?= $c_payment_scheds["payment_breakdown"]["interest"][$i]; ?></td>
                            <td><input type="hidden" name="payment_balance[]" class="form-control" value="<?= $c_payment_scheds["payment_breakdown"]["balance"][$i]; ?>"/><?= $c_payment_scheds["payment_breakdown"]["balance"][$i]; ?></td>
                        </tr>
                    <?php endfor; ?>
                </table>
            <?php endif; ?>
            
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#btn-loan-calculator").click(function(){
            
            if ( $("#start_date").val() == '' )
            {
                alertify.alert("Please enter the start date");
                return false;
            }
            
            
            var frequency = 1;
            var term = $("#term").val();
            var period = $("#term_period").val();            
            switch(period)
            {
                case "day":
                    frequency = 365;
                    break;
                case "week":
                    frequency = 52;
                    break;
                case "month":
                    frequency = 12;
                    break;
                case "year":
                    frequency = 1;
                    break;
            }
            
            var loan_amount = $("#amount1").val();
            var interest_rate = ($("#interest_rate").val() / 100) / frequency;
            
            var payment_amount = 0;
            
            var r = (1 + interest_rate) ;
            var pow = Math.pow(r, term);
            
            payment_amount = loan_amount * ( (interest_rate * pow)  / (pow - 1) );
            
            $("#loan-total-amount").html( addCommas( payment_amount.toFixed(2) ) );
            
            var table_scheds = '<table class="table table-bordered">';
            
            table_scheds += '<tr>';
            table_scheds += '<td style="text-align:center">Date</td>';
            table_scheds += '<td style="text-align:center">Payment Amount</td>';
            table_scheds += '<td style="text-align:center">Principal Amount</td>';
            table_scheds += '<td style="text-align:center">Interest Amount</td>';
            table_scheds += '<td style="text-align:center">Balance Owed</td>';
            table_scheds += '</tr>';
            
            var total_amount = 0;
            for (var i=0; i < term; i++)
            {
                var compound_interest = (loan_amount * interest_rate);
                var principal_amount = (payment_amount - compound_interest).toFixed(2);
                var balance_owed = (loan_amount - principal_amount).toFixed(2);
                
                total_amount += payment_amount;
                
                var payment_date = new Date( $("#start_date").val() );
                
                switch( $("#term_period").val() )
                {
                    case "day":
                        payment_date.setDate( payment_date.getDate() + (i+1) );
                        break;
                    case "week":
                        payment_date.setDate( payment_date.getDate() + ((i+1)*7) );
                        break;
                    case "month":
                        payment_date.setMonth( payment_date.getMonth( ) + (i+1) );
                        break;
                    case "year":
                        payment_date = new Date ( payment_date.getFullYear() + (i+1), payment_date.getMonth(), payment_date.getDate() );
                        break;
                }
                
                var d_date = (payment_date.getMonth() + 1) + "/" + payment_date.getDate() + "/" + payment_date.getFullYear();
                
                var inputs = '<input type="hidden" name="payment_date[]" value="'+ d_date +'" />\n\
                           <input type="hidden" name="payment_balance[]" value="'+ balance_owed +'" />\n\
                           <input type="hidden" name="payment_interest[]" value="'+ compound_interest.toFixed(2) +'" />\n\
                           <input type="hidden" name="payment_amount[]" value="'+ payment_amount.toFixed(2) +'" />\n\
                            ';
                
                
                table_scheds += '<tr>';
                table_scheds += '<td>' + inputs +  d_date + '</td>';
                table_scheds += '<td>' + addCommas(payment_amount.toFixed(2)) + '</td>';
                table_scheds += '<td>' + addCommas(principal_amount) + '</td>';
                table_scheds += '<td>' + addCommas(compound_interest.toFixed(2)) + '</td>';
                table_scheds += '<td>' + addCommas(balance_owed) + '</td>';
                table_scheds += '</tr>';
                
                loan_amount = balance_owed;
            }
            table_scheds += '</table>';
            
            $("#amount").val(total_amount);
            $("#sp-current-balance").html( addCommas(total_amount.toFixed(2)) );
            $("#current_balance").val( total_amount.toFixed(2) );
            
            $("#div-payment-scheds").html( table_scheds );
            
        });
    });
    
    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
</script>