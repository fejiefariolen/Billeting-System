<?php
include ("library/connection.php");
session_start();
if (!isset($_SESSION['user_id'])) 
{
	header("location:logout.php");
}

$_SESSION['active'] = 'transactions';

?>

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
	            	case 'receptionist':
	            	include 'receptionist.php';
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
							Transactions
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
	            	
	            	<div class="nav-tabs-navigation">
				                        <div class="nav-tabs-wrapper">
					                        <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
					                            <li class="active"><a href="#home" data-toggle="tab">Accomodation Facility</a></li>
					                            <li><a href="#profile" data-toggle="tab">Ameneties</a></li>
					                           
					                        </ul>
				                        </div>
				                    </div>
				                    <div id="my-tab-content" class="tab-content text-center">
				                        <div class="tab-pane active" id="home">
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
												<th>Transaction ID </th>
												<th>Guest Name</th>
												<th>Payment Date</th>
												<th>Total Payment</th>
												<th>Amount Tender</th>
												<th>Change</th>
												
												
												
												<th class="disabled-sorting">Actions</th>
											</tr>
										</thead>
										
										<tbody>
											
											<?php
											$users = $dbConn->query("SELECT * FROM tbl_transactions");
											while ($row = $users->fetch(PDO::FETCH_ASSOC)) 
											{
											?>
											<tr>
												<td><?php echo $row['id'];?></td>
												
												<td><?php 
												$getname = $dbConn->query("SELECT * FROM tbl_guests where guest_id = '".$row['guest_id']."' ");
												$disname = $getname->fetch(PDO::FETCH_ASSOC);
												echo $disname['guest_name'];
												?></td>

												<td><?php echo $row['date_payment']?></td>
												<td><?php echo $row['total_payment']?></td>
												<td><?php echo $row['amount_tender']?></td>
												<td><?php echo $row['change1']?></td>
												<td>
													<a href="print_acc.php?id=<?php echo $row['id']?>" class="btn btn-info">
													PRINT
													</a>
													
												</td>
											</tr>
										
										
											<?php
											}
											?>
											
										   </tbody>
									    </table>
									</div>


	                            </div>
	                        </div><!--  end card  -->
	                    </div> <!-- end col-md-12 -->
	                </div>
				                        </div>
				                        <div class="tab-pane" id="profile">
				                             <div class="row">
	                    <div class="col-md-12">
							
	                        <div class="card">
	                            <div class="content">
	                                <div class="toolbar">
	                                   
	                                </div>
                                    <div class="fresh-datatables">
										<table id="datatables1" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
										<thead>
											<tr>
												<th>Transaction ID </th>
												<th>Guest Name</th>
												<th>Ameneties Name</th>
												<th>Total Payment</th>
												<th>Amount Tender</th>
												<th>Change</th>
												
												
												
												<th class="disabled-sorting">Actions</th>
											</tr>
										</thead>
										
										<tbody>
											
											<?php
											$users = $dbConn->query("SELECT * FROM tbl_transactions_am");
											while ($row = $users->fetch(PDO::FETCH_ASSOC)) 
											{
											?>
											<tr>
												<td><?php echo $row['id'];?></td>
												<td><?php 
												$getname = $dbConn->query("SELECT * FROM tbl_guests where guest_id = '".$row['guest_id']."' ");
												$disname = $getname->fetch(PDO::FETCH_ASSOC);
												echo $disname['guest_name'];
												?></td>
												<td><?php 
												$getroom = $dbConn->query("SELECT * FROM tbl_ameneties where ameneties_id = '".$row['room_id']."' ");
												$disroom = $getroom->fetch(PDO::FETCH_ASSOC);
												echo $disroom['ameneties_name'];
												 ?></td>
												<td><?php echo $row['total_payment']?></td>
												<td><?php echo $row['amount_tender']?></td>
												<td><?php echo $row['change1']?></td>
												<td>
													<a href="print_am.php?id=<?php echo $row['id']?>" class="btn btn-info" target="_blank">
													PRINT
													</a>
													
												</td>
											</tr>
											
											<?php
											}
											?>
											
										   </tbody>
									    </table>
									</div>


	                            </div>
	                        </div><!--  end card  -->
	                    </div> <!-- end col-md-12 -->
	                </div>
				                        </div>
				                        
				                    </div>
	               <!-- end row -->
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

	        $('#datatables,#datatables1').DataTable({
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
