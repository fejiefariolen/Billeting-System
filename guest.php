<?php
include ("library/connection.php");
session_start();
if (!isset($_SESSION['user_id'])) 
{
	header("location:logout.php");
}

$_SESSION['active'] = 'guest';

?>
<!doctype html>
<html lang="en">

<?php include("templates/header.php") ?>

<body>
	<div class="wrapper">
	    <div class="sidebar" data-background-color="brown" data-active-color="danger">
	    <!--
			Tip 1: you can change the color of the sidebar's background using: data-background-color="white | brown"
			Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
		-->
			<div class="logo">
				<a href="index.php" class="simple-text">
					Base Billeting System
				</a>
			</div>
			
	    	<div class="sidebar-wrapper">
				
	            <?php
	            switch ($_SESSION['type']) 
	            {
	            	case 'admin':
	            	include 'navigation/admin.php';
	            		break;
	            	case 'cashier':
	           		include ("navigation/cashier.php");
	            		break;
	            	case 'mp':
	            	include ("navigation/mp.php");
	            		break;
	            	default:
	            		header("location:login.php");
	            		break;
	            }

	            ?>
	    	</div>
	    </div>
	    <div class="main-panel">
			<nav class="navbar navbar-default">
	            <div class="container-fluid">
					<div class="navbar-minimize">
						<button id="minimizeSidebar" class="btn btn-fill btn-icon"><i class="fa fa-chevron-left"></i></button>
					</div>
	                <div class="navbar-header">
	                    <button type="button" class="navbar-toggle">
	                        <span class="sr-only">Toggle navigation</span>
	                        <span class="icon-bar bar1"></span>
	                        <span class="icon-bar bar2"></span>
	                        <span class="icon-bar bar3"></span>
	                    </button>
	                    <a class="navbar-brand" href="#">
							Guest
						</a>
	                </div>
	                <?php
	             include ("includes/navbar.php");
	                ?>
	            </div>
	        </nav>

	            <div class="content">
	            <div class="container-fluid">
	            	<?php
	            	echo isset($_SESSION['message']) ? $_SESSION['message'] : '';
	            	unset($_SESSION['message']);
	            	?>
	            	
	                <div class="row">
	                    <div class="col-md-12">
							
	                        <div class="card">
	                            <div class="content">
	                                <div class="toolbar">
	                                   
	                                </div>
                                    <div class="fresh-datatables">
										<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
										<thead>
											<tr>
												<th>Guest ID</th>
												<th>Guest Name</th>
												<th>Unit Assignment</th>
												<th>Contact No.</th>
												<th>Address</th>
												<th>Guest Type</th>
												<th>Status</th>
												<th class="disabled-sorting">Actions</th>
											</tr>
										</thead>
										
										<tbody>
											
											<?php
											$users = $dbConn->query("SELECT * FROM tbl_guests ");
											while ($row = $users->fetch(PDO::FETCH_ASSOC)) 
											{
											?>
											<tr>
												<td><?php echo $row['guest_id'];?></td>
												<td>
													<?php echo $row['rank'];?>
													<?php echo $row['guest_name'];?>
													<?php echo $row['BOS'];?>
												</td>
												<td><?php echo $row['unit']?></td>
												<td><?php echo $row['contact_number']?></td>
												<td><?php echo $row['address']?></td>
												<td><?php echo $row['guest_type']?></td>

												<td>
													<span class="label label-success"><?php echo $row['status']?></span>
												
												</td>

												<td>
												<?php if($_SESSION['type'] == 'admin'){ ?>
													
													<button class="btn btn-primary btn-sm update" data-target="#<?php echo $row['guest_id']?>" data-toggle="modal">
														<i class="fa fa-edit"></i>
													</button>
												<?php }  else { echo'NOT ALLOWED';}?>
												</td>

											</tr>

								<div class="modal fade" id="<?php echo $row['guest_id']?>">
					            <div class="modal-dialog ">
					              <div class="modal-content">
					                <form method="post" action="execute/editguest.php">
					                  <div class="modal-header">
					                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					                    <h4 class="modal-title" id="myModalLabel">Update Guest</h4>
					                  </div>

					                  <div class="modal-body">
					                  <input type="hidden" value="<?php echo $row['guest_id'];?>" name="guest_id">
					                   
					                    <div class="row">
					                      <div class="col-md-6 col-offset-md-6">
					                        <div class="form-group">
					                          <label>Rank / Name / Serial / BOS </label>
					                          <input type="text" class="form-control " name="guest_name" required value="<?php echo $row['guest_name']; ?>">
					                        </div>
					                      </div>

					                      <div class="col-md-6">
					                        <div class="form-group">
					                          <label>Unit Assignment</label>
					                          <input type="text" class="form-control " name="unit" required value="<?php echo $row['unit']; ?>">
					                        </div>
					                      </div>
					                      
					                    </div>

					                    <div class="row">					                    	
					                      <div class="col-md-6">
					                        <div class="form-group">
					                          <label>Contact</label>
					                          <input type="number" class="form-control" name="contact" required value="<?php echo $row['contact_number']; ?>">
					                        </div>
					                      </div>

					                      <div class="col-md-6">
					                       <div class="form-group">
					                      	<label> GuestType </label>
					                      	<select class="form-control" name="guest_type" required>
					                        	<option value="VIP">VIP</option>
                                                <option value="Officer">Regular Oficer</option>
                                                <option value="EP">Enlisted Personnel</option>
                                                <option value="Dependents">Dependents</option>
                                                <option value="Retired">Retired</option>
					                      	</select>
					                   	 </div>
					                   	 </div>
					                 
                                                
                                     
                                           	

					                    </div>


					                    <div class="row">
					                      <div class="col-md-6">
					                        <div class="form-group">
					                          <label>Address</label>
					                          <textarea class="form-control" name="address"><?php echo $row['address']; ?></textarea>
					                        </div>
					                      </div>


					                        <div class="col-md-6">
					                       <div class="form-group">
					                      	<label> Status </label>
					                      	<select class="form-control" name="status" required>
					                      		<option value="Pending">PENDING</option>
					                        	<option value="In">IN</option>
                                                <option value="Out">OUT</option>

                                                
					                      	</select>
					                   	 </div>

					                    </div>
					                   
					                    
					                   
					                    
					                   
					                  </div>
					                  <div class="modal-footer">
					                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					                    <button type="submit" name="submit" class="btn btn-success btn-theme">Submit</button>
					                  </div>
					                </form>
					              </div>
					            </div>
					          </div>
										
											<?php
											}
											?>
											
										   </tbody>
									    </table>
									</div>


	                            </div>
	                        </div><!--  end card  -->
	                    </div> <!-- end col-md-12 -->
	                </div> <!-- end row -->
	            </div>
	        </div>
	        
             <?php include ("/templates/footer.php"); ?>
	    </div>
	    
	</div>

   
	
</body>

    <!--   Core JS Files. Extra: PerfectScrollbar + TouchPunch libraries inside jquery-ui.min.js   -->
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/jquery-ui.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!-- Vector Map plugin -->
	<script src="assets/js/jquery-jvectormap.js"></script>


    <!-- Paper Dashboard PRO Core javascript and methods for Demo purpose -->
	<script src="assets/js/paper-dashboard.js"></script>

    <!--   Sharrre Library    -->
    <script src="assets/js/jquery.sharrre.js"></script>

    <!-- Paper Dashboard PRO DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>

	<!--  Plugin for DataTables.net  -->
	<script src="assets/js/jquery.datatables.js"></script>

	<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
	<script src="assets/js/moment.min.js"></script>

	<!--  Date Time Picker Plugin is included in this js file -->
	<script src="assets/js/bootstrap-datetimepicker.js"></script>

	<!--  Select Picker Plugin -->
	<script src="assets/js/bootstrap-selectpicker.js"></script>
	<script type="text/javascript">
	    $(document).ready(function() {

	    	$('.update').click( function()
	    	{
	    		$('#card').css('z-index',0);
	    		$('.navbar').css('z-index',0);
	    		
	    	});

	    	$('.datepicker').on('click',function()
	    	{
	    		$('#card').css('z-index',4);
	    	});

	    	$('.submit').on('click',function()
	    	{
	    		$('#card').css('z-index',4);
	    	});

	        $('#datatables').DataTable({
	            "pagingType": "full_numbers",
	            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
	            responsive: true,
	            language: {
	            search: "_INPUT_",
		            searchPlaceholder: "Search records",
		        }
	        });

            // Init DatetimePicker
            demo.initFormExtendedDatetimepickers();
	    });
	</script>

</html>
