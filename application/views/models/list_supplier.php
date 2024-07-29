<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
										<thead>
											<tr>
												<th class="hidden-xs">Company</th>
												
												<th>Email Address</th>
												<th>Phone</th>
												<th>City</th>
												<th>Country</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
                                        <?php 
										//$this->load->database();
										//$supplierslist=$this->data['suppliers'];
										//$suppliers=$this->$suppliers;
										foreach ($suppliers as $row)
										{
										?>
											<tr>
												<td><?php echo $row['supp_company_name'] ?></td>
												<td><?php echo $row['supp_email'] ?></td>
												<td><?php echo $row['supp_company_phone'] ?> 	</td>
												<td><?php echo $row['supp_city'] ?></td>
												<td>
												<?php 
												echo $row['country_short_name'] 
												?></td>
												<td align="right">
														<p>
															
															
                                                            
                                                            
															<!--<a id="modal_ajax_suppliers_update_btn" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit Category">-->
                                                           
                                                          
                                                         <a onClick="click_supplier_update_btn(<?php echo $row['supp_id'] ?>)" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers">
															<i class="glyphicon fa fa-edit"></i></a>
                                                            
                                                            <?php if($row['supp_status']==1){ ?>
                                                            <a class="btn btn-xs btn-green tooltips" data-placement="top" data-original-title="Disable supplier" onClick="disableSupplierData(<?php echo $row['supp_id'] ?>)">
															<i class="glyphicon fa fa-check"></i></a>
                                                            <?php } ?>
                                                            
															<?php if($row['supp_status']==2){ ?>
                                                            <a class="btn btn-xs btn-warning tooltips" data-placement="top" data-original-title="Enable supplier" onClick="enableSupplierData(<?php echo $row['supp_id'] ?>)">
															<i class="glyphicon fa fa-minus-circle"></i></a>
                                                            <?php } ?>
                                                            
                                                            
															<a class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Delete supplier" onClick="deleteSupplierData(<?php echo $row['supp_id'] ?>)">
															<i class="glyphicon fa fa-trash-o"></i></a>
														</p>
												</td>
											</tr>
                                            <?php }
										?>
										</tbody>
									</table>
                                    
		<script>
			jQuery(document).ready(function() {
				//Main.init();
				TableData.init();
				UIModals.init();
				
				//loadSupplierDataList();// load supplier data
				
			});
			</script>