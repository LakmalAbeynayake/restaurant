<?php $this->load->view("common/header"); ?>
<style type="text/css">
    .table>thead:first-child>tr:first-child>th,
    .table>thead:first-child>tr:first-child>td,
    .table-striped thead tr.primary:nth-child(2n+1) th {
        background-color: #428bca;
        border-color: #357ebd;
        border-top: 1px solid #357ebd;
        color: white;
        text-align: center;
    }

    .box .box-content {
        background: white none repeat scroll 0 0;
        padding: 20px;
    }
    
    /*check*/
    .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20rem; }
    .toggle.ios .toggle-handle { border-radius: 20rem; }
    
    .modal-dialog{
        width: auto !important;
        margin: 0 !important;
    }
</style>
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
<!-- end: HEAD -->
<!-- start: BODY -->
<link rel="stylesheet" href="<?php echo asset_url(); ?>css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/select2/select2.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">


<body>
    <!-- start: HEADER -->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <!-- start: TOP NAVIGATION CONTAINER -->
        <div class="container">
            <div class="navbar-header">
                <!-- start: RESPONSIVE MENU TOGGLER -->
                <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                    <span class="clip-list-2"></span>
                </button>
                <!-- end: RESPONSIVE MENU TOGGLER -->
                <!-- start: LOGO -->
                <?php $this->load->view("common/logo"); ?>
                <!-- end: LOGO -->
            </div>
            <div class="navbar-tools">
                <!-- start: TOP NAVIGATION MENU -->
                <?php $this->load->view("common/notifications.php"); ?>
                <!-- end: TOP NAVIGATION MENU -->
            </div>
        </div>
        <!-- end: TOP NAVIGATION CONTAINER -->
    </div>
    <!-- end: HEADER -->
    <!-- start: MAIN CONTAINER -->
    <div class="main-container">
        <div class="navbar-content">
            <!-- start: SIDEBAR -->
            <?php $this->load->view("common/navigation"); ?>
            <!-- end: SIDEBAR -->
        </div>
        <!-- start: PAGE -->
        <div class="main-content">
            <!-- end: SPANEL CONFIGURATION MODAL FORM -->
            <div class="container">
                <!-- start: PAGE HEADER -->
                <div class="row">
                    <div class="col-sm-12">
                        <!-- start: PAGE TITLE & BREADCRUMB -->
                        <ol class="breadcrumb">
                            <li>
                                <a href="<?php echo base_url('dashboard'); ?>">
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('products'); ?>">
                                    Product
                                </a>
                            </li>
                            <li class="active">
                                <?php echo $product_details->product_name; ?>
                            </li>
                            <li class="search-box">
                                <form class="sidebar-search">
                                    <div class="form-group">
                                        <input type="text" placeholder="Start Searching...">
                                        <button class="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </li>
                        </ol>
                        <div class="page-header" style="">
                            <h1>Product <strong><?php echo $product_details->product_name; ?></strong>  </h1>
                        </div>
                    </div>
                </div>
                <!-- end: PAGE HEADER -->
                <!-- start: PAGE CONTENT -->
                <div class="row">
                    <div class="col-sm-12">
                        
                        <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Location * </label>
                                                <select id="location_id" class="form-control search-select" onchange="get_recipe(),get_prices(),get_movements()">
                                                    <!-- <option value=""> xx Select Warehouse xx </option>-->
                                                    <?php $ss_warehouse_id = $this->session->userdata('ss_warehouse_id'); 
                                                            foreach ($locations as $row){
                                                            $sel = $ss_warehouse_id == $row->id ? ' selected="selected"' : '';
                                                    ?>
                                                        <option <?php echo $sel; ?> value="<?php echo $row->id; ?>"> <?php echo $row->name; ?> </option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                        
                        <div class="tabbable">
                            <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
                                <li class="active">
                                    <a data-toggle="tab" href="#panel_overview">
                                        Product Details
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#price_management">
                                        Price Management
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#recipe_management">
                                        Recipe Management
                                    </a>
                                </li>
                                <li >
                                    <a data-toggle="tab" href="#bin_card">
                                        Bin Card
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#stock">
                                        Stock
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="panel_overview" class="tab-pane in active">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="text-transform:capitalize"><strong><?php echo $product_details->product_name; ?></strong></div>
                                        <div class="panel-body">
                                            <div class="box-content">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                                <img class="img-responsive img-thumbnail" alt="<?php echo $product_details->product_name; ?>" src="<?php echo $product_details->product_image ?? "data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAAeAAD/4QMvaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzEzOCA3OS4xNTk4MjQsIDIwMTYvMDkvMTQtMDE6MDk6MDEgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo5RjhGRDhDMjg2OEQxMUU3OTkxQ0Y0M0JBQ0I2RENFQyIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo5RjhGRDhDMzg2OEQxMUU3OTkxQ0Y0M0JBQ0I2RENFQyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjlGOEZEOEMwODY4RDExRTc5OTFDRjQzQkFDQjZEQ0VDIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjlGOEZEOEMxODY4RDExRTc5OTFDRjQzQkFDQjZEQ0VDIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+/+4ADkFkb2JlAGTAAAAAAf/bAIQAEAsLCwwLEAwMEBcPDQ8XGxQQEBQbHxcXFxcXHx4XGhoaGhceHiMlJyUjHi8vMzMvL0BAQEBAQEBAQEBAQEBAQAERDw8RExEVEhIVFBEUERQaFBYWFBomGhocGhomMCMeHh4eIzArLicnJy4rNTUwMDU1QEA/QEBAQEBAQEBAQEBA/8AAEQgAqgCqAwEiAAIRAQMRAf/EAGgAAQEBAQEBAAAAAAAAAAAAAAAFBAMCAQEBAAAAAAAAAAAAAAAAAAAAABAAAgECAwUIAwEBAAAAAAAAAAECAwQRUhQhMZGhEkFRcYHBMhMzsSJyYdERAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AN4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAdbeg608N0VvYHIFNW9BLDoXntPvwUckeAEsFT4KOSPAfBRyR4ASwVPgo5I8B8FHJHgBLBU+CjkjwHwUckeAEsFT4KOSPAfBRyR4ASwVPgo5I8B8FHJHgBLBU+CjkjwM9zaxUXOmsMN8QMYAAAAAAABusPZLx9DCbrD65ePoByvZyVVJNpYLYjh1zzPidr77l/KPFvRdaeG6K3sDx1zzPiOueZ8SlGhSisFBeLWLOda0pzi3BdMuzDcwMPXPM+I655nxPLTTwe9AD11zzPiOueZ8TyAPXXPM+I655nxPIA9dc8z4jrnmfE8gD18k8z4lR7YPHtRJKz9nkBJAAAAAAAAN1h9cvH0MJusPrl4+gHG++5fyjtYYfHLvx9Djffcv5R4t67ozxe2L3oCmDxGtSmsYyRyrXVOmmovqn2JbgMlzh888O85Btttva3vAAA0W1s6r6pbILmB8t7Z1f2lsh3954rUZUpdMt3Y+8ppJLBbEtyPNSnGpFxktn4AlA6VqMqUumW7sfecwBWfs8iSVn7PICSAAAAAAAAbrD65ePoYTdYfXLx9AON99y/lepnNF99y/lflmcAD6k5NRisW9yKFC2jTj+y6pS3/8AnA0XNs6T6o7YPkLa2dR9c9kPyAtrZ1H1z2QXM3pJLBbEgkksFsSPoAAAeKlONSLjJbPwTq1GVKXTLd2PvKh4qU41IuMls/AEorP2eRJKz9nkBJAAAAAAAAN1h9cvH0MJusPrl4+gHG++5fyvyzgk5NRisW9yO999y/lflnaxhHoc8P2xwx/wD3b26pLF7Zve+47gAfGk1g9qe9BJJYLYkfQAAAAAAAABHe8rP2eRJe8rP2eQEkAAAAAAAA3WH1y8fQwm6wf6SX+gcb77l/K/LOlpWpQpYTkk8XsF3RqzqKUI4rDA4aavkfIDdqaGdDU0M6MOmr5HyGmr5HyA3amhnQ1NDOjDpq+R8hpq+R8gN2poZ0NTQzow6avkfIaavkfIDdqaGdDU0M6MOmr5HyGmr5HyA3amhnQ1NDOjDpq+R8hpq+Rgcis/Z5E7TV8jKMtkHj2ICSAAAAAAAAdKNaVGfUtqe9HMAUFeUGsW2n3NH3V2+bkycAKOrt83JjV2+bkycAKOrt83JjV2+bkycAKOrt83JjV2+bkycAKOrt83JjV2+bkycAKOrt83JjV2+bkycAKOrt83JnC4u+uLhT2Re9vtMoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/9k="; ?>">
                                                                <div class="padding10" id="multiimages">
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-6 col-md-8">
                                                                <div class="table-responsive">
                                                                    <table class="table table-borderless table-striped dfTable table-right-left">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="col-xs-3 col-md-4">Barcode</td>
                                                                                <td style="col-xs-9 col-md-8">
                                                                                    <img class="pull-left" alt="<?php echo $product_details->product_code; ?>" src="<?php echo base_url() . 'products/gen_barcode/' . $product_details->product_code . '/40'; ?>">
                                                                                </td>
                                                                            </tr>
                                                                            <!--<tr>
                                                                                <td>Product Name</td>
                                                                                <td><?php echo $product_details->product_name; ?></td>
                                                                            </tr>-->
                                                                            <tr>
                                                                                <td class="col-xs-3 col-md-4">Product Code</td>
                                                                                <td class="col-xs-9 col-md-8"><?php echo ucfirst($product_details->product_code); ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="col-xs-3 col-md-4">Category</td>
                                                                                <td class="col-xs-9 col-md-8"><?php echo $product_details->cat_name; ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="col-xs-3 col-md-4">Weight / Volume / Length</td>
                                                                                <td class="col-xs-9 col-md-8"><span id="psize"><?php echo $product_details->product_size; ?></span> <?php echo $product_details->unit_name; ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="col-xs-3 col-md-4">Product Cost</td>
                                                                                <td class="col-xs-9 col-md-8">
                                                                                    <?php echo $product_details->product_cost; ?>
                                                                                    <input type="hidden" id="product_cost" value="<?php echo $product_details->product_cost; ?>">
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="col-xs-3 col-md-4">Latest Price</td>
                                                                                <td class="col-xs-9 col-md-8"><?php echo $product_details->product_price; ?></td>
                                                                            </tr>
                                                                            <tr class="collapse">
                                                                                <td>Tax Rate</td>
                                                                                <td><?php echo $product_details->name; ?> <?php echo $product_details->rate; ?>%</td>
                                                                            </tr>
                                                                            <tr class="collapse">
                                                                                <td>Alert Quantity</td>
                                                                                <td><?php echo $product_details->product_alert_qty; ?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div class="col-sm-12">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">Product Details</div>
                                                                    <div class="panel-body">
                                                                        <p><?php echo $product_details->product_details; ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="panel panel-default">
                            										<div class="panel-heading">
                            											<i class="clip-pie"></i>
                            											Sub Products
                            											<div class="panel-tools">
                            												<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                            												</a>
                            												<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
                            													<i class="fa fa-wrench"></i>
                            												</a>
                            												<a class="btn btn-xs btn-link panel-refresh" href="#">
                            													<i class="fa fa-refresh"></i>
                            												</a>
                            												<a class="btn btn-xs btn-link panel-close" href="#">
                            													<i class="fa fa-times"></i>
                            												</a>
                            											</div>
                            										</div>
                            										<div class="panel-body">
                            											<div class="flot-mini-container">
                            												<table class="table table-borderless table-striped dfTable table-right-left">
                            												    <thead>
                            												        <tr>
                                												        <th>
                                												            Item Name
                                												        </th>
                                												        <th>
                                												            Item Code
                                												        </th>
                                												        <th>
                                												            Item Volume / Length / Weight
                                												        </th>
                                												        <th>
                                												            Actions
                                												        </th>
                                												    </tr>
                            												    </thead>
                            												    <tbody>
                            												        
                            												    </tbody>
                            												    <tfoot>
                            												        <tr>
                            												            <td colspan="4">
                            												                <button id="add_sub" type="button" class="btn btn-success pull-right"><strong>Add Item <i class="fa fa-plus"></i> </strong></button>
                            												            </td>
                            												        </tr>
                            												    </tfoot>
                            												</table>
                            											</div>
                            										</div>
                            									</div>
                                                            </div>
                                                        </div>
                                                        <div class="buttons">
                                                            <div class="btn-group btn-group-justified">
                                                                <div class="btn-group">
                                                                    <a title="" class="tip btn btn-primary" href="#" onClick="print_barcode(<?php echo $product_details->product_id; ?>); return false;" data-original-title="Barcode">
                                                                        <i class="fa fa-print"></i> <span class="hidden-sm hidden-xs">Print Barcode</span>
                                                                    </a>
                                                                </div>
                                                                <div class="btn-group" <?php echo $this->session->userdata('ss_group_id') == 4 ? 'style="display:none"' : ""; ?>>
                                                                    <a title="" class="tip btn btn-warning tip" href="<?php echo base_url(); ?>products/edit/<?php echo $product_details->product_id; ?>" data-original-title="Edit Product">
                                                                        <i class="fa fa-edit"></i> <span class="hidden-sm hidden-xs">Edit</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!--PRICE MANAGEMENT-->
                                <div id="price_management" class="tab-pane">
                                    <form id="price_form">
                                        <div class="col-sm-6">
                                                    <table class="table" id="prices_table">
                                                        <thead>
                                                            <tr>
                                                                <th>Price Type</th>
                                                                <th>Value</th>
                                                                <!--<th>Actions</th>-->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    No data available
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <button type="button" <?php echo $this->session->userdata('ss_group_id') == 4 ? 'style="display:none"' : ""; ?> class="btn btn-success pull-right" onClick="check()"> <b>Add New Price</b> </button>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                        <span class="clearfix"></span>
                                        <div class="panel-footer">
                                            <button type="button" class="pull-right btn btn-info" id="save_prices" disabled <?php echo $this->session->userdata('ss_group_id') == 4 ? 'style="display:none"' : ""; ?>><b>SAVE</b></button>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                    <!--$jsonData = '{"lo1":[{"pt_id":1,"amount":"420.00"},{"pt_id":2,"amount":"510.00"}]}';-->
                                    <!--Price List-->
                                    
                                    <div class="clearfix"></div>
                                </div>

                                <!--RECIPE MANAGEMENT-->
                                <div id="recipe_management" class="tab-pane">
                                    <form id="recipe_items_form">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <i class="icon-arrow"></i>
                                                Add Recipe Items<strong> Note: Pick a measuring unit as per your comfort and maintain it everywhere. </strong>
                                            </div>
                                            <div class="panel-body">
                                                <div class="well well-sm">
                                                    <div class="input-group wide-tip">
                                                        <div style="padding-left: 10px; padding-right: 10px;" class="input-group-addon"> <i class="fa fa-2x fa-barcode addIcon"></i> </div>
                                                        <input type="text" placeholder="Add Items" id="add_recipe_items" class="form-control input-lg" value="" name="add_recipe_items" style="border-radius: 6px;font-size: 18px;height: 46px;line-height: 1.33;padding: 10px 16px;">
                                                        <div style="padding-left: 10px; padding-right: 10px;" class="input-group-addon"></div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="control-group table-group"> <br>
                                                        <div class="controls table-controls">
                                                            <table class="table items table-striped table-bordered table-condensed table-hover" id="recipe_item_table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Description</th>
                                                                        <th class="text-right col-sm-4">Note</th>
                                                                        <th class="text-right col-sm-1" style="width:150px">Cost per unit <span class="currency"></span> <button type="button" class="btn btn-warning" onclick="load_latest()"> load latest </button>  </th>
                                                                        <th class="text-right col-sm-1" style="width:150px">Qty  <span class="currency"></span> </th>
                                                                        <th class="text-right col-sm-1" style="width:150px">Subtotal</th>
                                                                        <th style="width: 30px !important; text-align: center;">toggle</th>
                                                                        <th style="width: 30px !important; text-align: center;"><i class="fa fa-trash-o"></i></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody></tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th class="text-right col-sm-4"></th>
                                                                        <th class="text-right col-sm-1" style="width:150px"></th>
                                                                        <th class="text-right col-sm-1" style="width:150px"></th>
                                                                        <th class="text-right col-sm-1" style="width:150px" id="total_cost">Total Cost</th>
                                                                        <th style="width: 30px !important; text-align: center;"></th>
                                                                        <th style="width: 30px !important; text-align: center;"><i class="fa fa-trash-o"></i></th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <input type="button" style="margin-right:10px;" id="save_recipe_form" name="save_recipe_form" value="Set Items" class="pull-right btn btn-primary  <?php echo $this->session->userdata('ss_group_id') == 4 ? 'collapse' : ''; ?> ">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end cost -->
                                        <input name="warehouse_id" class="warehouse_id" type="hidden" value="1">
                                        <input type="hidden" name="product_id" value="<?php echo $product_details->product_id; ?>">
                                    </form>
                                </div>
                                <div id="bin_card" class="tab-pane">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <!--<h3 class="bold">Bin Card</h3>-->
                                            <div class="col-md-12">
                                                <div class="col-md-3 form-group">
                                                    <label>Date</label>
                                                    <input type="date" id="date" class="form-control">
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <label>Date To (Optional)</label>
                                                    <input type="date" id="date_to"  class="form-control">
                                                </div>
                                                <div class="col-md-3 form-group" style="display:flex">
                                                    <button class="btn btn-info" onClick="get_movements()">
                                                        <i class="fa fa-refresh"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped table-condensed" id="bin_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Log ID</th>
                                                            <th>Date & Time</th>
                                                            <th>Created On</th>
                                                            <th>Movement Type</th>
                                                            <th>Referance ID</th>
                                                            <th>Moved in / out</th>
                                                            <th>Quantity</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                            <tr><td colspan="4">Not Found !</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="stock" class="tab-pane">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h3 class="bold">Warehouse Quantity</h3>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed dfTable two-columns">
                                                    <thead>
                                                        <tr>
                                                            <th>Warehouse Name</th>
                                                            <th>Quantity (Racks)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if (empty($warehouses)) {
                                                            echo "<tr><td>No Found !</td></tr>";
                                                        } else {
                                                            foreach ($warehouses as $key => $wh) {
                                                                echo "<tr><td>$wh->name ($wh->code)</td><td><strong>$wh->quantity</strong></td></tr>";
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end: PAGE CONTENT-->
            </div>
            <!-- end: PAGE -->
        </div>
        <!-- end: MAIN CONTAINER -->
        <!-- start: FOOTER -->
        <div class="footer clearfix">
            <div class="footer-inner">
                2014 &copy; clip-one by cliptheme.
            </div>
            <div class="footer-items">
                <span class="go-top"><i class="clip-chevron-up"></i></span>
            </div>
        </div>
        <!-- end: FOOTER -->
        <!-- start: RIGHT SIDEBAR -->
        <!-- end: RIGHT SIDEBAR -->
        <div id="event-management" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title">Event Management</h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-light-grey">
                            Close
                        </button>
                        <button type="button" class="btn btn-danger remove-event no-display">
                            <i class='fa fa-trash-o'></i> Delete Event
                        </button>
                        <button type='submit' class='btn btn-success save-event'>
                            <i class='fa fa-check'></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Price Type Modal -->
        <div class="modal fade" id="priceTypeModal" tabindex-d="-1" role="dialog" aria-labelledby="priceTypeModalLabel" aria-hidden="true">
            <div class="modal-dialog-d" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="priceTypeModalLabel">Select Price Type <small>: <?php echo $product_details->product_name; ?></small></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Price Type Options -->
                        <select id="priceTypeSelect" class="form-control">
                            <?php
                            // Loop through priceTypes and generate options dynamically
                            foreach ($price_types as $priceType) {
                                echo "<option value='{$priceType->pt_id}'>{$priceType->pt_name}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="showSelectedPriceType()">Select</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- start ajax model -->
        <div id="ajax-modal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" style="display: none;"></div>
        <!-- end ajax model -->
        <!-- start: MAIN JAVASCRIPTS -->
        <?php $this->load->view("common/footer"); ?>
        <!-- end: MAIN JAVASCRIPTS -->
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script>
        <script src="<?php echo asset_url(); ?>js/jquery-ui.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
        <script>
            const merge_on = 0;
            <?php $price_types_json = json_encode($price_types); ?>
            var priceTypes = <?php echo $price_types_json; ?>;
            var priceTypesMapped = [];
            $(priceTypes).each((a, b) => {
                priceTypesMapped[b.pt_id] = b;
            });
            
            $(document).ready(function() {
                //$('#location_id').on('change',get_recipe());
                get_recipe();
                get_prices();
                //get_movements();
                $('body').removeClass('modal-open');
            });

            function print_barcode(product_id) {
                window.open('<?php echo base_url() ?>products/single_barcode/' + product_id, 'barcode', 'width=900,height=600,scrollbars=yes,menubar=yes,status=no,resizable=yes,screenx=0,screeny=0');
            }
            /*Hash*/
            function handleHashTag() {
                // Get the hash tag from the URL
                var hash = window.location.hash;
    
                // Check if the hash tag is not empty
                if (hash !== "") {
                    // Remove the '#' symbol from the hash tag
                    var tabId = hash.substring(1);
    
                    // Click on the relevant tab pane
                    //$("#" + tabId).click();
                    $('[href="#'+tabId+'"]').click();
                    
                    if(tabId == 'bin_card'){
                        get_movements();
                    }
                }
            }

            // Call the function on page load
            handleHashTag();
    
            $(window).on('hashchange', function() {
                handleHashTag();
            });
            function onTabChange() {
                var activeTabId = $('.nav-tabs .active a').attr('href');
                console.log('Active Tab ID:', activeTabId);
                window.location.hash = activeTabId;
            }

            // Attach the event handler to the Bootstrap Tab's 'shown.bs.tab' event
            $('a[data-toggle="tab"]').on('shown.bs.tab', onTabChange);
            /*End hash*/

            /*Recipe Management*/
            $("#add_recipe_items").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url(); ?>products/suggestions',
                        data: {
                            'cost': 1,
                            'term': request.term,
                            'location': $("#warehouse_id").val(),
                            'this_id': <?php echo $product_details->product_id; ?>
                        },
                        dataType: 'json',
                        success: (data) => {
                            response(data)
                        }
                    });
                },
                //source: '<?php echo base_url(); ?>products/suggestions?w=' + $("#warehouse_id").val(),
                minLength: 1,
                autoFocus: false,
                delay: 5,
                response: function(event, ui) {
                    if (ui.content.length == 1 && ui.content[0].product_id != 0) {
                        //ui.item = ui.content[0];
                        //$(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                        //$(this).autocomplete('close');
                        //$(this).removeClass('ui-autocomplete-loading');
                        $('body').removeClass('modal-open');
                    } else if (ui.content.length == 0) {
                        var noResult = {
                            value: "",
                            label: "No matching result found! Service might be out of stock in the selected warehouse."
                        };
                        ui.content.push(noResult);
                        $('body').removeClass('modal-open');
                    } else {
                        $('body').removeClass('modal-open');
                    }
                },
                select: function(event, data) {
                    $('body').removeClass('modal-open');
                    //alert( "You selected: " + data.item.product_id );
                    if (data.item.value) {
                        if ($('#row_e_' + parseInt(data.item.product_id)).length) {
                            calculateTotal();
                            displayNotice('page', 'Already added item');
                        } else {
                            add_to_recipe_list(data.item.product_id, data.item.product_code, data.item.product_name, data.item.product_cost, data.item.unit_code);
                            calculateTotal();
                        }
                        $("#add_recipe_items").val('');
                        return false;
                    }
                    $(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading');
                    $('body').removeClass('modal-open');
                }
            });
            
            $("#save_recipe_form").click(function() {
                var fields = $("#recipe_items_form").serialize();
                console.log(fields);
                $.ajax({
                    url: "<?php echo base_url(); ?>products/save_recipe_items",
                    type: "POST",
                    dataType: "json",
                    data: fields + '&location_id=' + $('#location_id').val(),
                    success: function(response) {
                        console.log($(response));
                        if (response.status){
                            displayNotice('page', 'Updated successfully');
                            setTimeout(()=>{
                                window.location.reload();
                            },700);
                        }
                    },
                    error: function(error) {
                        var tableRow = '<tr><td colspan="3">No Data available</td></tr>';
                        $('#prices_table tbody').append(tableRow);
                        console.error("Error:", error);
                    }
                });
            });
            
        function add_to_recipe_list(item_id, item_code, item_name, item_cost, unit_code, quantity = 1, is_active = 1) {
            var sub_tot = item_cost * quantity;
            var nxtCount = parseInt(item_id);
        
            // Construct the HTML string
            var htmlString = `<tr class="child" data-item-id="${nxtCount}" id="row_e_${nxtCount}">
                <td>${item_name} (${item_code}) <input type="hidden" name="row_e[${nxtCount}][item_id]" value="${item_id}"></td>
                <td><input style="width:100%; text-align:right" type="text" <?php echo $this->session->userdata('ss_group_id') == 4 ? 'readonly' : ''; ?> name="row_e[${nxtCount}][bkng_itm_note]" id="item_note_${nxtCount}" value=""></td>
                <td class="text-right"><input style="width:100px; text-align:right" <?php echo $this->session->userdata('ss_group_id') == 4 ? 'readonly' : ''; ?> type="text" name="row_e[${nxtCount}][itm_cst]" id="itm_cst_${nxtCount}" onclick="this.select();" onchange="allowDecimals(this);calculateTotal();" value="${item_cost}"> </td>
                <td class="text-right"><input style="width:100px; text-align:right" <?php echo $this->session->userdata('ss_group_id') == 4 ? 'readonly' : ''; ?> type="text" name="row_e[${nxtCount}][itm_qty]" id="itm_qty_${nxtCount}" onclick="this.select();" onchange="allowDecimals(this);calculateTotal();" value="${quantity}"> </td>
                <td class="text-right"><input style="width:100px; text-align:right" <?php echo $this->session->userdata('ss_group_id') == 4 ? 'readonly' : ''; ?> type="text" name="row_e[${nxtCount}][itm_stt]" id="itm_stt_${nxtCount}" onclick="this.select();" onchange="allowDecimals(this);calculateTotal();" value="${sub_tot}" readonly> </td>
                <td> <?php echo $this->session->userdata('ss_group_id') != 4 ? '<input type="checkbox" ${parseInt(is_active) == 1 ? "checked" : ""} data-toggle="toggle" data-size="sm" data-style="ios" data-onstyle="success" data-offstyle="danger" onchange="toggle_recipe_item(this)">' : ''; ?> </td>
                <td><a class="remove-item  <?php echo $this->session->userdata('ss_group_id') == 4 ? 'collapse' : ''; ?> "><i class="fa fa-times" title="Remove" style="cursor:pointer;"></i></a></td>
            </tr>`;
        
            // Prepend the HTML string to the table body
            $('#recipe_item_table tbody').prepend(htmlString);
        
            // Initialize bootstrap toggle
            $('input[type="checkbox"]').bootstrapToggle();
        
            // Calculate total
            calculateTotal();
        }
        function calculateTotal() {
            var total_cost = 0;
            var rowCount = parseInt($('#recipe_item_table > tbody > tr').length);
            if (rowCount) {
                $('#recipe_item_table > tbody > tr').each(function(a, b) {
                    var item_id = $(this).data('item-id');
                    var price = $('#itm_cst_' + item_id).val();
                    var qty = $('#itm_qty_' + item_id).val();
                    var sub_total = parseFloat(price) * qty;
                    $('#itm_stt_'+item_id).val(sub_total);
                    total_cost += sub_total;
                });
            }
            $('#total_cost').text("Total Cost: "+ total_cost);
        }
        // Event delegation for remove-item click event
        $(document).on('click', '.remove-item', function() {
            $(this).closest('tr').remove();
            calculateTotal();
        });
    
            function delete_item(a) {
                $(a).closest('tr').remove();
                $("#save_recipe_form").click();
                displayNotice('Booking', 'Item has been deleted successfully!');
                calculateTotal();
                return false;
            }
            
            function allowDecimals(input) {
                // Validate the input value to allow decimals
                var numericValue = parseFloat(input.value);
            
                if (isNaN(numericValue)) {
                    input.value = 0; // Clear the input if not a valid number
                } else {
                    // Set the input value to the validated numeric value
                    input.value = numericValue.toFixed(3); // Adjust the decimal places as needed
                }
            }
            
            function toggle_recipe_item(elem) {
                var tr = $(elem).closest('tr');
                var ingredient_id = $(tr).data('item-id');
                var prop = $(elem).prop('checked');
                /*alert('on the dev');*/
                $.ajax({
                    url: "<?php echo base_url('products/toggle_recipe_item')?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        'location_id': $('#location_id').val(),
                        'product_id': <?php echo $product_details -> product_id; ?> ,
                        'ingredient_id' : ingredient_id,
                        'prop': prop ? 1 : 0
                    },
                    statusCode: {
                        200: function(response) {
                            // Handle a successful response with status code 200
                            bootbox.alert("Success");
                        },
                        201: function(response) {
                            // Handle a successful response with status code 201
                            bootbox.alert("Created");
                        },
                        404: function() {
                            // Handle a not found response with status code 404
                            bootbox.alert("Not Found");
                        },
                        500: function() {
                            console.log(JSON.stringify(response));
                            // Handle a server error response with status code 500
                            bootbox.alert("Internal Server Error");
                        }
                        // Add more status code handlers as needed
                    }
                });
            }
            //$('[href="#price_management"]').on('click',get_recipe());
            
            function get_recipe() {
                $('#recipe_item_table tbody').empty();
                $.ajax({
                    url: "<?php echo base_url('products/get_recipe')?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        'location_id': $('#location_id').val(),
                        'product_id': <?php echo $product_details -> product_id; ?> ,
                    },
                    success: function(response) {
                        // Handle successful response
                        //console.log("Success:", response);
                        $.each(response, (a, b) => {
                            console.log("a:", a);
                            console.log("b:", b);
                            add_to_recipe_list(parseInt(b.ingredient_id), b.product_code, b.product_name, parseFloat(b.cost_per_item), '', b.quantity, b.is_active);
                        });
                    },
                    error: function(error) {
                        // Handle error
                        console.error("Error:", error);
                    }
                });
            }
            
            function get_movements(){
                const date = $('#date').val();
                const date_to = $('#date_to').val();
                // bin_table
                $.ajax({
                    url: "<?php echo base_url('products/get_movements')?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        'date' : date,
                        'date_to' : date_to,
                        'location_id': $('#location_id').val(),
                        'product_id': <?php echo $product_details -> product_id; ?>
                    },
                    success: function(response) {
                        $('body').removeClass('modal-open');
                        $('#bin_table tbody').empty();
                        var data = response.data;
                        
                        if(merge_on){
                            var last_movement_type = ''; // Track the last movement type
                            var last_origin = ''; // Track the last origin
                            var last_quantity = 0; // Track the last quantity
                            var last_log_id = ''; // Track the last log_id
                            var last_movement_date = ''; // Track the last movement_date
                            var last_created_on_date = ''; // Track the last movement_date
                            var merged_log_id = ''; // Track the merged log_id for sales movements
                        
                            $.each(data, (index, movement) => {
                                console.log('Current Movement:', movement);
                                if (movement.movement_type === last_movement_type && movement.origin === 'sale') {
                                    console.log('last_movement_type --:', last_movement_type);
                                    console.log('movement.movement_type --:', movement.movement_type);
                                    console.log('movement.origin --:', movement.origin);
                                    
                                    // If the current movement type is the same as the previous one and origin is the same
                                    // Merge the quantities if it's a sales movement
                                    if (movement.movement_type === 'out' && movement.origin === 'sale') {
                                        last_quantity += parseFloat(movement.quantity);
                                        if (!merged_log_id) {
                                            // Start a new merged_log_id range
                                            console.log('Last Log ID:', last_log_id);
                                            console.log('Merged Log ID:', merged_log_id);
                                            console.log('movement.log_id:', movement.log_id);
                                            merged_log_id = movement.log_id;//(last_log_id === '' ? movement.log_id : last_log_id);
                                        }
                                    }
                                } else {
                                    // If the current movement type is different from the previous one or origin is different
                                    // Display the movement separately
                                    if (last_movement_type !== '') {
                                        add_to_bin({
                                            log_id: (merged_log_id ? merged_log_id + ' to ' + last_log_id : last_log_id),
                                            movement_date: last_movement_date,
                                            created_on: last_created_on_date,
                                            movement_type: last_movement_type,
                                            origin: last_origin,
                                            origin_id: '',
                                            quantity: last_quantity,
                                            merged_log_id: merged_log_id // Assign merged_log_id if it exists
                                        });
                                    }
                                    //if(last_origin != 'sale')
                                        merged_log_id = ''; // Reset merged_log_id for the next sequence
                                        
                                    // Update last_movement_type, last_origin, last_log_id, last_movement_date, and last_quantity
                                    last_movement_type = movement.movement_type;
                                    last_origin = movement.origin;
                                    last_log_id = movement.log_id;
                                    last_movement_date = movement.movement_date;
                                    last_created_on_date: movement.created_on,
                                    last_quantity = parseFloat(movement.quantity);
                                }
                            });
                        
                            // Add the last movement
                            if (last_movement_type !== '') {
                                add_to_bin({
                                    log_id: (merged_log_id ? merged_log_id + ' to ' + last_log_id : last_log_id),
                                    movement_date: last_movement_date,
                                    created_on: last_created_on_date,
                                    movement_type: last_movement_type,
                                    origin: last_origin,
                                    origin_id: '',
                                    quantity: last_quantity,
                                    merged_log_id: merged_log_id // Assign merged_log_id if it exists
                                });
                            }
                        }else{
                            $.each(data, (index, movement) => {
                                add_to_bin(movement);
                            });
                        }
                        
                        
                        // **
                        // UNCOMMENT BELOW FOR MERGE BY MOVEMENT TYPE
                        // -- start
                        // **
                        /*
                        */
                        // **
                        // UNCOMMENT ABOVE FOR MERGE BY MOVEMENT TYPE
                        // -- end
                        // **
                    },
                    error: function(error) {
                        // Handle error
                        console.error("Error:", error);
                    }
                });
            }
            
            function add_to_bin(b) {
                /*console.log(b);*/
                var tr = '';
                
                if(merge_on){
                    if (b.movement_type === 'out' && b.merged_log_id) {
                    // If it's a sales movement and merged_log_id is present
                    tr = `<tr>
                                <td>${b.merged_log_id}</td> 
                                <td>${b.movement_date}</td> 
                                <td>${b.created_on}</td> 
                                <td>${b.origin}</td>
                                <td>${b.origin_id}</td>
                                <td>${b.movement_type}</td>
                                <td>${b.quantity}</td>
                              </tr>`;
                    } else {
                        tr = `<tr>
                                <td>${b.log_id}</td> 
                                <td>${b.movement_date}</td> 
                                <td>${b.created_on}</td> 
                                <td>${b.origin}</td>
                                <td>${b.origin_id}</td>
                                <td>${b.movement_type}</td>
                                <td>${b.quantity}</td>
                              </tr>`;
                    }
                }else{
                    tr = `<tr>
                            <td>${b.log_id}</td> 
                            <td>${b.movement_date}</td> 
                            <td>${b.created_on}</td> 
                            <td>${b.origin}</td>
                            <td>${b.origin_id}</td>
                            <td>${b.movement_type}</td>
                            <td>${b.quantity}</td>
                          </tr>`;
                }
                
                $('#bin_table tbody').prepend(tr);
            }
            
            function get_name(){
                
            }


            /*function add_to_bin(b) {
                console.log(b);
                var tr = 
                `<tr>
                    <td>${b.log_id}</td> 
                    <td>${b.movement_date}</td> 
                    <td>${b.origin}</td>
                    <td>${b.movement_type}</td>
                    <td>${b.quantity}</td>
                <tr>`;
                
                $('#bin_table tbody').prepend(tr);
            }*/
            /*
            */
            /*Price Management*/
            function check() {
                var product_cost = $('#product_cost').val();
                if (isNaN(product_cost) || !product_cost > 0) {
                    alert("Please enter the product cost! Pricing will run over the product cost.");
                    return false;
                } else {
                    $('#priceTypeModal').modal('show');
                }
            }
            
            function showSelectedPriceType() {
                var product_cost = $('#product_cost').val();
                if (isNaN(product_cost) || !product_cost > 0) {
                    alert("Please enter the product cost! Pricing will run over the product cost.");
                    return false;
                }
                $('#product_cost').attr('readonly', 'true');
                // Close the modal
                $('#priceTypeModal').modal('hide');
                // Get the selected value from the dropdown
                var selectedValue = document.getElementById("priceTypeSelect").value;
                // loop through priceTypes array and find the data of the price type that selected
                $(priceTypes).each((a, b) => {
                    console.log('b', b.pt_id);
                    // if found a match
                    if (b.pt_id == selectedValue) {
                        console.log('b', b);
                        // calculate the price here
                        calculateAndAppendPrice(b);
                        // append the row to $('#prices_table > tbody')
                    }
                });
            }
            
            function calculateAndAppendPrice(selectedPriceType) {
                // Get the required values from the selected price type
                var addOrDeduct = selectedPriceType.add_or_deduct;
                var percentageOrAmount = selectedPriceType.percentage_or_amount;
                var amount = parseFloat(selectedPriceType.amount);
                // Get the required product cost
                var productCost = parseFloat($('#product_cost').val());
                // Calculate the price based on the selected price type
                var calculatedPrice = 0;
                if (addOrDeduct === 'add') {
                    if (percentageOrAmount === 'percentage') {
                        calculatedPrice = productCost + (productCost * amount / 100);
                    } else {
                        calculatedPrice = productCost + amount;
                    }
                } else {
                    if (percentageOrAmount === 'percentage') {
                        calculatedPrice = productCost - (productCost * amount / 100);
                    } else {
                        calculatedPrice = productCost - amount;
                    }
                }
                
                
                if ($('#pt_' + selectedPriceType.pt_id).length > 0) {
                    // Append the calculated price to the list
                    var input_list = '';
                        input_list += '<p style="display: flex;justify-content: space-evenly;"><input type="text" name="prices[' + priceTypesMapped[selectedPriceType.pt_id].pt_id + '][]" value="' + parseFloat(calculatedPrice).toFixed(2) + '" onchange="allowDecimals(this)">'+
                                       //'<button type="button" class="btn btn-warning" title="fix" onclick="fix(this)"><i class="fa fa-gavel"></i></button> ' +
                                       '<button type="button" class="btn btn-danger" title="remove" onclick="remove_price(this)"><i class="fa fa-times"></i></button></p>';

                    /*var tableRow = '<tr id="pt_' + b.pt_id + '" <input type="hidden" name="pt_id[]" value="' + b.pt_id + '">>' +
                        '<td>' + priceTypesMapped[b.pt_id].pt_name + '</td>' +
                        '<td>' + input_list + ' </td>' +
                        '</tr>';*/ 

                    $('#pt_' + selectedPriceType.pt_id +' > td:nth-child(2)').append(input_list);
                }else{
                    // Append the calculated price to the table
                    var tableRow = '<tr id="pt_' + selectedPriceType.pt_id + '" <input type="hidden" name="pt_id[]" value="' + selectedPriceType.pt_id + '">>' +
                                        '<td>' + selectedPriceType.pt_name + '</td>' +
                                        '<td>'+
                                            '<p style="display: flex;justify-content: space-evenly;"> <input type="text" name="prices[' + selectedPriceType.pt_id + '][]" value="' + calculatedPrice.toFixed(2) + '" onchange="allowDecimals(this)">' +
                                            //'<button type="button" class="btn btn-warning" title="fix" onclick="fix(this)"><i class="fa fa-gavel"></i></button> ' +
                                            '<button type="button" class="btn btn-danger" title="remove" onclick="remove_price(this)"><i class="fa fa-times"></i></button> <p></td>' +
                                        '</tr>';
                    $('#prices_table tbody').append(tableRow);
                }
            }
            $(document).on('click','#save_prices',()=>{
               save_price();
            });
            function save_price(){
                var fields = $("#price_form").serialize();
                $.ajax({
                    url: "<?php echo base_url('products/update_prices')?>",
                    type: "POST",
                    dataType: "json",
                    data: fields + '&location_id=' + $('#location_id').val()+ '&product_id=<?php echo $product_details -> product_id; ?>',
                    statusCode: {
                        200: function(response) {
                            // Handle a successful response with status code 200
                            window.location.reload();
                        },
                        201: function(response) {
                            // Handle a successful response with status code 201
                            bootbox.alert("Saved");
                        },
                        404: function() {
                            // Handle a not found response with status code 404
                            bootbox.alert("Not Found");
                        },
                        400: function() {
                            console.log(JSON.stringify(response));
                            // Handle a server error response with status code 400
                        },
                        500: function() {
                            console.log(JSON.stringify(response));
                            // Handle a server error response with status code 500
                            bootbox.alert("Internal Server Error");
                        }
                        // Add more status code handlers as needed
                    },
                    error: function(error) {
                        var tableRow = '<tr><td colspan="3">No Data available</td></tr>';
                        $('#prices_table tbody').append(tableRow);
                        console.error("Error:", error);
                    }
                });
            }
            
            function get_prices() {
                $('#prices_table tbody').empty();
                $.ajax({
                    url: "<?php echo base_url('products/get_product_prices')?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        'location_id': $('#location_id').val(),
                        'product_id': <?php echo $product_details -> product_id; ?> ,
                    },
                    success: function(response) {
                        console.log('response ',response);
                        // Handle successful response
                        console.log("Success:", response);
                        $.each(response, (a, b) => {
                            add_to_price_list(a,b);
                        });
                    },
                    error: function(error) {
                        /*var tableRow = '<tr><td colspan="2"><button type="button" class="btn btn-default pull-right" onClick="check()"> <b>Add New Price</b> </button></td></tr>';
                        $('#prices_table tfoot').append(tableRow);*/
                        // console.error("Error:", error);
                    }
                });
            }

            function add_to_price_list(index,b) {
                console.log('add_to_price_list ',index);
                console.log('add_to_price_list ',b);
                /*
                console.log(priceTypesMapped[b.pt_id]);
                
                console.log(b.amount);*/
                
                var input_list = '';
                
                $.each(b.amount,(c,d)=>{
                    console.log(b);
                    input_list += '<p style="display: flex;justify-content: space-evenly;"><input <?php echo $this->session->userdata('ss_group_id') == 4 ? 'readonly' : ""; ?> type="text" name="prices[' + priceTypesMapped[b.pt_id].pt_id + '][]" value="' + parseFloat(d).toFixed(2) + '" onchange="allowDecimals(this)">'+
                                   //'<button type="button" class="btn btn-warning" title="fix" onclick="fix(this)"><i class="fa fa-gavel"></i></button> ' +
                                   '<button <?php echo $this->session->userdata('ss_group_id') == 4 ? 'style="display:none"' : ""; ?> type="button" class="btn btn-danger" title="remove" onclick="remove_price(this)"><i class="fa fa-times"></i></button></p>';
                });
                
                var tableRow = '<tr id="pt_' + b.pt_id + '" <input type="hidden" name="pt_id[]" value="' + b.pt_id + '">>' +
                    '<td>' + priceTypesMapped[b.pt_id].pt_name + '</td>' +
                    '<td>' + input_list + ' </td>' +
                    '</tr>';
                $('#prices_table tbody').append(tableRow);
            }
            
            /*Ajax*/
            $(document).ajaxStart(() => {
                $('body').modalmanager('loading');
            });
            $(document).ajaxStop(() => {
                $('body').modalmanager('removeLoading');
            });
            
            /*deletes*/
            //remove price
            function remove_price(elem){
                bootbox.confirm('Are you sure?',(a)=>{
                    if(a){
                        if($(elem).closest('tr').find('td:nth-child(2) > p').length == 1){
                            $(elem).closest('tr').remove();
                        }else{
                            $(elem).closest('p').remove();
                        }
                        save_price();
                    }
                });
            }
            $(document).on('change',()=>{
                $('#save_prices').prop('disabled',false);
            });
            
            function load_latest(){
                var rowCount = parseInt($('#recipe_item_table > tbody > tr').length);
                if (rowCount) {
                    $('#recipe_item_table > tbody > tr').each(function(a, b) {
                        var item_id = $(this).data('item-id');
                        get_cost(item_id)
                    });
                }
            }
            
            function get_cost(item_id){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>products/get_cost',
                    data: {
                        'product_id': item_id,
                    },
                    dataType: 'json',
                    success: (data) => {
                        $('#itm_cst_'+item_id).val(parseFloat(data.product_cost));
                        calculateTotal();
                    }
                });
            }
            
            $('#add_sub').on('click',()=>{
                window.location.href = "<?php echo base_url(); ?>products/add?sub=<?php echo $product_details->product_id; ?>";
            });
        </script>
</body>
<!-- end: BODY -->

</html>