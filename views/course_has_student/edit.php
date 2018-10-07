<?php

include('../../include/include.php');

if(!isset($_GET["id"])) {
  header("Location: ../course/view.php");
}

$id = $_GET["id"];
$getData = callAPI("GET", "http://localhost/beacon_backend/api/course/readOne.php?id=" . $id, false);
$courseDetail = json_decode($getData, true);

$getData = callAPI("GET", "http://localhost/beacon_backend/api/course_has_student/readStudentsNotInCourse.php?course_id=" . $id, false);
$studentNotInCourseList = json_decode($getData, true);

$getData = callAPI("GET", "http://localhost/beacon_backend/api/course_has_student/readStudentsInCourse.php?course_id=" . $id, false);
$studentInCourseList = json_decode($getData, true);

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
						<h3><?php echo $courseDetail["name"]; ?></h3>
					</div>
					<div class="row" >
			  		<div class="col-md-12">
							<div class="grid simple">
				  			<div class="grid-title no-border">
									<h4>Add Course Students</h4>
				  			</div>
				  			<div class="grid-body no-border">
									<table class="table" id="addStudentTable">
									  <thead>
										<tr>
										  <th class="checkboxColumn"></th>
										  <th>Student ID</th>
										  <th>Name</th>
										  <th>Major</th>
										  <th>Start Date</th>
										  <th>End Date</th>
										</tr>
									  </thead>
									  <tbody>
										<?php
										  foreach($studentNotInCourseList as $instance) {
											$html = "<tr>";
											$html .= "<td class='checkboxColumn'><input type='checkbox' value='" . $instance['studentId'] . "'></td>";
											$html .= "<td>" . $instance['studentId'] . "</td>";
											$html .= "<td>" . $instance['student'] . "</td>";
											$html .= "<td>" . $instance['major'] . "</td>";
											$html .= "<td><input type='date' name='start_date' class='min-height-25'></td>";
											$html .= "<td><input type='date' name='end_date' class='min-height-25'></td>";
											$html .= "</tr>";

											echo $html;
										  }
										?>
									  </tbody>
									</table>
									<button id="addStudentsButton">Add to Course</button>
				  			</div>
							</div>
			  		</div>
			  		<div class="col-md-12">
							<div class="grid simple">
				  			<div class="grid-title no-border">
									<h4>Remove Course Students</h4>
				  			</div>
				  			<div class="grid-body no-border">
									<table class="table" id="removeStudentTable">
									  <thead>
										<tr>
										  <th class="checkboxColumn"></th>
										  <th>Student ID</th>
										  <th>Name</th>
										  <th>Major</th>
										  <th>Start Date</th>
										  <th>End Date</th>
										</tr>
									  </thead>
									  <tbody>
										<?php
										  foreach($studentInCourseList as $instance) {
											$html = "<tr>";
											$html .= "<td class='checkboxColumn'><input type='checkbox' value='" . $instance['studentId'] . "'></td>";
											$html .= "<td>" . $instance['studentId'] . "</td>";
											$html .= "<td>" . $instance['student'] . "</td>";
											$html .= "<td>" . $instance['major'] . "</td>";
											$html .= "<td class='startDateColumn' data-start-date='" . $instance['startDate'] . "'>" . $instance['startDate'] . "</td>";
											$html .= "<td>" . $instance['endDate'] . "</td>";
											$html .= "</tr>";

											echo $html;
										  }
										?>
									  </tbody>
									</table>
									<button id="removeStudentsButton">Remove from Course</button>
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
			$('#addStudentTable').dataTable()
			$('#removeStudentTable').dataTable()

			$("#addStudentsButton").click(function() {
			  let courseId = new URLSearchParams(window.location.search).get('id')

			  let selectedRows = $("#addStudentTable input[type='checkbox']:checked")
			  $.each(selectedRows, function(index, rowId) {
			  	let formVal = {
			  		"course_id": courseId,
						"student_id": $(this).val(),
						"start_date": $(this).closest("tr").find("input[name='start_date']").val(),
						"end_date": $(this).closest("tr").find("input[name='end_date']").val()
			  	}
			  	$.post("/beacon_backend/api/course_has_student/create.php", formVal, function(data, status) {
						if(data.message == "success") {
							$("#addStudentTable").before(
								"<div class='alert alert-success'>" +
									"<button class='close' data-dismiss='alert'></button>" +
									"Success: The record has been created." +
								"</div>"
							)
						} else {
							$("#addStudentTable").before(
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
			  let courseId = new URLSearchParams(window.location.search).get('id')

			  let selectedRows = $("#removeStudentTable input[type='checkbox']:checked")
			  $.each(selectedRows, function(index, rowId) {
			  	let formVal = {
			  		"course_id": courseId,
						"student_id": $(this).val(),
						"start_date": $(this).closest('tr').children('td.startDateColumn').data('start-date')
			  	}
					$.post("/beacon_backend/api/course_has_student/delete.php", formVal, function(data, status) {
						if(data.message == "success") {
							$("#removeStudentTable").before(
								"<div class='alert alert-success'>" +
									"<button class='close' data-dismiss='alert'></button>" +
									"Success: The record has been created." +
								"</div>"
							)
						} else {
							$("#removeStudentTable").before(
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