<?php

include('../../include/include.php');

if(!isset($_GET["id"])) {
  header("Location: ../class/view.php");
}

$id = $_GET["id"];
$getData = callAPI("GET", "http://localhost/beacon_backend/api/class/readOne.php?id=" . $id, false);
$classDetail = json_decode($getData, true);

$getData = callAPI("GET", "http://localhost/beacon_backend/api/class_has_student/readStudentsNotAttendedInClass.php?class_id=" . $id, false);
$studentNotAttendedInClassList = json_decode($getData, true);

$getData = callAPI("GET", "http://localhost/beacon_backend/api/class_has_student/readStudentsAttendedInClass.php?class_id=" . $id, false);
$studentAttendedInClassList = json_decode($getData, true);

?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>Home</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<?php echo $head; ?>
	</head>
	<body>
		<?php echo $navbar; ?>
		<div class="page-container row-fluid"><!-- BEGIN CONTAINER -->
		<?php echo $sidebar; ?>
			<div class="page-content"><!-- BEGIN PAGE CONTAINER-->
				<div class="content">
					<ul class="breadcrumb">
						<li><p>YOU ARE HERE</p></li>
						<li><a href="#" class="active">View Course Students</a></li>
						<li><a href="#" class="active">View Courses</a></li>
					</ul>
					<div class="page-title"> <i class="icon-custom-left"></i>
						<h3>
							<?php 
								echo $classDetail["course"] . " - " . 
									date('d M Y', strtotime($classDetail["date"])) . " (" .
									date('H:i', strtotime($classDetail["startTime"])) . " - " .
									date('H:i', strtotime($classDetail["endTime"])) . ")"; 
							?>
						</h3>
					</div>
					<div class="row" >
			  		<div class="col-md-12">
							<div class="grid simple">
				  			<div class="grid-title no-border">
									<h4>Add Attendance</h4>
				  			</div>
				  			<div class="grid-body no-border">
									<table class="table" id="addAttendanceTable">
										<input type="hidden" name="date" value="<?php echo $classDetail['date']; ?>">
									  <thead>
											<tr>
											  <th class="checkboxColumn"></th>
											  <th>Student ID</th>
											  <th>Name</th>
											  <th>Major</th>
											  <th>Attend Time</th>
											</tr>
									  </thead>
									  <tbody>
										<?php
										  foreach($studentNotAttendedInClassList as $instance) {
												$html = "<tr>";
												$html .= "<td class='checkboxColumn'><input type='checkbox' value='" . $instance['studentId'] . "'></td>";
												$html .= "<td>" . $instance['studentId'] . "</td>";
												$html .= "<td>" . $instance['student'] . "</td>";
												$html .= "<td>" . $instance['major'] . "</td>";
												$html .= "<td><input type='time' name='attend_time' class='min-height-25'></td>";
												$html .= "</tr>";

												echo $html;
										  }
										?>
									  </tbody>
									</table>
									<button id="addAttendanceButton">Add Attendance</button>
				  			</div>
							</div>
			  		</div>
			  		<div class="col-md-12">
			  			<div class="grid simple">
			  				<div class="grid-title no-border">
									<h4>Edit Attendance</h4>
				  			</div>
				  			<div class="grid-body no-border">
				  				<table class="table" id="editAttendanceTable">
										<input type="hidden" name="date" value="<?php echo $classDetail['date']; ?>">
									  <thead>
											<tr>
											  <th class="checkboxColumn"></th>
											  <th>Student ID</th>
											  <th>Name</th>
											  <th>Major</th>
											  <th>Attend Time</th>
											</tr>
									  </thead>
									  <tbody>
										<?php
										  foreach($studentAttendedInClassList as $instance) {
											$html = "<tr>";
											$html .= "<td class='checkboxColumn'><input type='checkbox' value='" . $instance['studentId'] . "'></td>";
											$html .= "<td>" . $instance['studentId'] . "</td>";
											$html .= "<td>" . $instance['student'] . "</td>";
											$html .= "<td>" . $instance['major'] . "</td>";
											$html .= "<td><input type='time' name='attend_time' value='" . date('H:i', strtotime($instance['attendTime'])) . "' class='min-height-25'></td>";
											$html .= "</tr>";

											echo $html;
										  }
										?>
									  </tbody>
									</table>
									<button id="editAttendanceButton">Edit Attendance</button>
				  			</div>
			  			</div>
			  		</div>
			  		<div class="col-md-12">
							<div class="grid simple">
				  			<div class="grid-title no-border">
									<h4>Remove Attendance</h4>
				  			</div>
				  			<div class="grid-body no-border">
									<table class="table" id="removeAttendanceTable">
									  <thead>
										<tr>
										  <th class="checkboxColumn"></th>
										  <th>Student ID</th>
										  <th>Name</th>
										  <th>Major</th>
										  <th>Attend Time</th>
										</tr>
									  </thead>
									  <tbody>
										<?php
										  foreach($studentAttendedInClassList as $instance) {
												$html = "<tr>";
												$html .= "<td class='checkboxColumn'><input type='checkbox' value='" . $instance['studentId'] . "'></td>";
												$html .= "<td>" . $instance['studentId'] . "</td>";
												$html .= "<td>" . $instance['student'] . "</td>";
												$html .= "<td>" . $instance['major'] . "</td>";
												$html .= "<td>" . date('H:i', strtotime($instance['attendTime'])) . "</td>";
												$html .= "</tr>";

												echo $html;
										  }
										?>
									  </tbody>
									</table>
									<button id="removeStudentsButton">Remove Attendance</button>
				  			</div>
							</div>
			  		</div>
					</div><!-- END ROW -->
				</div><!-- END CONTENT -->
			</div><!-- END PAGE CONTAINER -->
		</div><!-- END CONTAINER -->
	</body>
	<?php echo $footer; ?>
	<script>
	  $(document).ready(function() {
			$('#addAttendanceTable').dataTable()
			$('#editAttendanceTable').dataTable()
			$('#removeAttendanceTable').dataTable()

			$("#addAttendanceButton").click(function() {
			  let classId = new URLSearchParams(window.location.search).get('id')

			  let selectedRows = $("#addAttendanceTable input[type='checkbox']:checked")
			  $.each(selectedRows, function(index, rowId) {
			  	let formVal = {
			  		"class_id": classId,
						"student_id": $(this).val(),
						"date": $("input[name='date']").val(),
						"attend_time": $(this).closest("tr").find("input[name='attend_time']").val()
			  	}
			  	$.post("/beacon_backend/api/class_has_student/create.php", formVal, function(data, status) {
						if(data.message == "success") {
							$("#addAttendanceTable").before(
								"<div class='alert alert-success'>" +
									"<button class='close' data-dismiss='alert'></button>" +
									"Success: The record has been created." +
								"</div>"
							)
						} else {
							$("#addAttendanceTable").before(
								"<div class='alert alert-error'>" +
									"<button class='close' data-dismiss='alert'></button>" +
									"Error: Transaction failed." +
								"</div>"
							)	
						}
				  })
			  })
			});

			$("#editAttendanceButton").click(function() { // Not working yet
			  let classId = new URLSearchParams(window.location.search).get('id')

			  let selectedRows = $("#editAttendanceTable input[type='checkbox']:checked")
			  $.each(selectedRows, function(index, rowId) {
			  	let formVal = {
			  		"class_id": classId,
						"student_id": $(this).val(),
						"date": $("input[name='date']").val(),
						"attend_time": $(this).closest("tr").find("input[name='attend_time']").val()
			  	}
			  	$.post("/beacon_backend/api/class_has_student/update.php", formVal, function(data, status) {
						if(data.message == "success") {
							$("#editAttendanceTable").before(
								"<div class='alert alert-success'>" +
									"<button class='close' data-dismiss='alert'></button>" +
									"Success: The record has been created." +
								"</div>"
							)
						} else {
							$("#editAttendanceTable").before(
								"<div class='alert alert-error'>" +
									"<button class='close' data-dismiss='alert'></button>" +
									"Error: Transaction failed." +
								"</div>"
							)	
						}
				  })
			  })
			});

			$("#removeStudentsButton").click(function() {
			  let classId = new URLSearchParams(window.location.search).get('id')

			  let selectedRows = $("#removeAttendanceTable input[type='checkbox']:checked")
			  $.each(selectedRows, function(index, rowId) {
			  	let formVal = {
			  		"class_id": classId,
						"student_id": $(this).val()
			  	}
					$.post("/beacon_backend/api/class_has_student/delete.php", formVal, function(data, status) {
						if(data.message == "success") {
							$("#removeAttendanceTable").before(
								"<div class='alert alert-success'>" +
									"<button class='close' data-dismiss='alert'></button>" +
									"Success: The record has been created." +
								"</div>"
							)
						} else {
							$("#removeAttendanceTable").before(
								"<div class='alert alert-error'>" +
									"<button class='close' data-dismiss='alert'></button>" +
									"Error: Transaction failed." +
								"</div>"
							)	
						}
				  })
			  })
			});
	  });
	</script>
</html>