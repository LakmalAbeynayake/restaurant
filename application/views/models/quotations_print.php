<?php $this->load->view("common/header"); ?>
<div style="top:5px;" class="panel-tools open">
    <button data-toggle="dropdown" class="btn btn-blue dropdown-toggle" onClick="window.print()">
        <i class="fa fa-print"></i>
    </button>
</div>
<style type="text/css">
    th {
        text-align: center !important;
    }
    .report_view_th {
        color: #000 !important;
        text-align: center !important;
    }
    body {
        background-color: #fff !important;
        font-size: 11px;
    }
    p {
        margin: 0;
    }
    .modal-body {
        padding: 2px 15px 15px;
        position: relative;
    }
    body .modal {
        /* new custom width */
        width: 750px;
        /* must be half of the width, minus scrollbar on the left (30px) */
        margin-left: -375px;
    }
    .print-table td,
    th {
        padding: 3px;
        vertical-align: top !important;
    }
    thead {
        display: table-header-group;
    }
    tfoot {
        display: table-footer-group;
    }
</style>
<style type="text/css" media="print">
    .print-table {
        /*page-break-before:avoid;
	page-break-after: avoid;*/
        /*page-break-inside: avoid;*/
        /*page-break-inside:avoid;*/
        width: 100%;
    }
</style>
<!--https://css-tricks.com/almanac/properties/p/page-break/-->
<!--onLoad="window.print()-->
<body onLoad="window.print()">
    <?php $this->load->view("common/report_header.php"); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-6">
                <p>Customer Code: <?php echo $customer_details['cus_code']; ?></p>
                <p>Name and Address: <?php echo $customer_details['cus_name']; ?> <?php echo $customer_details['cus_address']; ?></p>
                <p>Tel: <?php echo $customer_details['cus_phone']; ?></p>
            </div>
            <div class="col-xs-4 pull-right">
                <p>Date: <?php echo display_date_time_format($qts_details['qts_datetime']); ?></p>
            </div>
        </div>
    </div>
    <div class="print-start">
        <table class="print-table" width="100%">
            <thead>
                <tr class="report_view_th">
                    <th colspan="6" class="col-xs-1 text-right">
                        <span style="float:right;">Reference No: <?php echo $qts_details['qts_reference_no']; ?></span>
                    </th>
                </tr>
                <tr class="report_view_th text-center">
                    <th class="col-xs-1">No</th>
                    <th class="col-xs-2">Description</th>
                    <th class="col-xs-1">Quantity</th>
                    <th class="col-xs-1">Unit Price</th>
                    <th class="col-xs-1">Discount</th>
                    <th class="col-xs-2" align="center">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tmpcount = 0;
                foreach ($qts_item_list as $row) {
                    $tmpcount++;
                ?>
                    <tr>
                        <td style="text-align:center; width:40px; vertical-align:middle;"><?php echo $tmpcount ?></td>
                        <td style="vertical-align:middle;">
                            <?php echo $row['product_name']; ?> (<?php echo $row['product_code']; ?>)</td>
                        <td style="width: 80px; text-align:center; vertical-align:middle;"><?php echo number_format($row['quantity'], 2, '.', ''); ?></td>
                        <td style="text-align:right; width:100px;"><?php echo number_format($row['unit_price'], 2, '.', ','); ?></td>
                        <td style="width: 100px; text-align:right; vertical-align:middle;"> (<?php echo $row['discount'] ?>) <?php echo number_format($row['discount_val'], 2, '.', ',') ?></td>
                        <td style="text-align:right; width:120px;"><?php echo number_format($row['gross_total'], 2, '.', ','); ?></td>
                    </tr>
                <?php } ?>
                <?php if ($qts_details['qts_inv_discount']) { ?>
                    <tr>
                        <td style="text-align:right; padding-right:10px;" colspan="5">Order Discount</td>
                        <td style="text-align:right; padding-right:10px;">(<?php echo $qts_details['qts_inv_discount'] ?>)<?php echo number_format($qts_details['qts_inv_discount_amount'], 2, '.', ',') ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td style="text-align:right; font-weight:bold;" colspan="5">Total Amount
                    </td>
                    <td style="text-align:right; padding-right:10px; font-weight:bold; border-top:1px solid #000; border-bottom:1px solid #000;"><?php echo number_format($qts_details['qts_total'], 2, '.', ',') ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <br>
    <!-- payment list -->
    <div class="row">
        <div class="col-xs-12">
            <h5>ADVANCE PAYMENTS</h5>
            <div class="table-responsive">
                <table class="table items table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <tr class="report_view_th">
                            <th>Date</th>
                            <th>Payment Reference</th>
                            <th>Paid by</th>
                            <th class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_paid = 0;
                        foreach ($sale_payments_list as $row) {
                            $total_paid += $row->sale_pymnt_amount;
                        ?>
                            <tr>
                                <td><?php echo display_date_time_format($row->sale_pymnt_date_time) ?></td>
                                <td><?php
                                    echo $row->sale_pymnt_id;
                                    if ($row->user_first_name) echo " Cashier.: " . $row->user_first_name;
                                    if ($row->sale_pymnt_ref_no) echo "<br/>Ref.: " . $row->sale_pymnt_ref_no;
                                    if ($row->sale_pymnt_cheque_no) echo "<br/>Cheque No.: " . $row->sale_pymnt_cheque_no;
                                    if ($row->sale_pymnt_note) echo "<br/>Note: " . $row->sale_pymnt_note;
                                    ?></td>
                                <td><?php echo $row->sale_pymnt_paying_by ?></td>
                                <td class="text-right"><?php echo number_format($row->sale_pymnt_amount, 2, '.', ',') ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><strong>TOTAL PAID </strong></td>
                            <td class="text-right"><strong><?php echo number_format($total_paid, 2, '.', ',') ?></strong></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><strong>BALANCE </strong></td>
                            <td class="text-right"><strong><?php echo number_format($qts_details['qts_total'] - $total_paid, 2, '.', ',') ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <br>
        <br>
        <div class="col-xs-12">
            <div class="col-xs-4"> Prepared by: <br>
                <br>
                ...................
                <br>
                <?php echo $this->session->userdata('ss_user_first_name'); ?> (<?php echo $this->session->userdata('ss_user_group_name'); ?>)
            </div> <!--col-xs-4-->
            <div class="col-xs-4"> Authorized by: <br>
                <br>
                ......................
                <br>
            </div> <!--col-xs-4-->
            <div class="col-xs-4">Goods received in good condition:<br>
                <br>
                .............................
                <br>
            </div> <!--col-xs-4-->
        </div><!--col-xs-12-->
        <?php //$this->load->view("common/print_footer.php"); 
        ?>
    </div><!--print-start-->
</body>