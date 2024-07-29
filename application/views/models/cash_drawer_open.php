<!DOCTYPE html>

<html lang="en" class="no-js">

<!--<![endif]-->

<!-- start: HEAD -->

<head>
    <?php
    header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    ?>
    <title>
        <?php
        if (isset($sub_menu_name))
            echo strtoupper($sub_menu_name . ' - ');
        ?>
        STOCK MANAGEMENT SYSTEM</title>

    <!-- start: META -->

    <meta charset="utf-8" />
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="description" />
    <meta name="author" />
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>thems/images/your-logo-here.png" />
    <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap/css/bootstrap.min.css">
</head>
<style type="text/css">
    body {
        font-family: monospace;
        font-size: 13px;
    }

    th {
        text-align: center !important;
    }

    .report_view_th {
        color: #000 !important;
        text-align: center !important;
    }

    body {
        background-color: #fff !important;
        font-size: 12px;
    }

    p {
        margin: 0;
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
        width: 100%;
    }

    .td_border_bottom_1 {
        border-bottom: 1px solid #666 !important;
    }

    .td_border_bottom_2 {
        border-bottom: 4px double #666 !important;
    }

    .td_border_top_1 {
        border-top: 1px double #666 !important;
    }

    .pagebreak {
        page-break-before: always;
    }

    @page {
        size: auto;
        /* auto is the initial value */
        margin: 0;
        /* this affects the margin in the printer settings */
    }
</style>

<body style="font-size:16px">
    <div class="print_area print" style="width:100%;margin-left:5px;page-break-after:always">
	<p>Drawer open by <?php echo $this->session->userdata('ss_user_first_name'); ?></p>
	
      </div>
    <script>
        setTimeout(function() {
            window.print();
            window.close()

        }, 1000);
    </script>

</body>