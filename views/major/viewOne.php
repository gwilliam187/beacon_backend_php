<?php

include('../../include/include.php');

if(!isset($_GET["id"])) {
	header("Location: ../major/view.php");
}

$id = $_GET["id"];
$getData = callAPI("GET", "http://localhost/beacon_backend/api/major/readOne.php?id=" . $id, false);
$result = json_decode($getData, true);

$getCourses = callAPI("GET", "http://localhost/beacon_backend/api/course/read.php", false);
$courseList = json_decode($getCourses, true);

$getMajorCourses = callAPI("GET", "http://localhost/beacon_backend/api/major_has_course/readWhereMajor.php?major_id=" . $id, false);
$majorCourseList = json_decode($getMajorCourses, true);

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
					<li><a href="#" class="active">View Majors</a> </li>
				</ul>
				<div class="page-title"> <i class="icon-custom-left"></i>
					<h3>Major - <span class="semi-bold">Detail</span></h3>
				</div>
				<div class="row" >
					<div class="col-md-12">
						<div class="grid simple">
							<div class="grid-title no-border">
								<h4>Major Details</h4>
								<div class="tools custom-tools">
									<a href="edit.php?id=<?php echo $result['id']; ?>">Edit</a>
									<a href="#" id="deleteButton">Delete</a>
								</div>
							</div>
							<div class="grid-body no-border">
								<br>
								<form id="pageForm">
								<div class="row">
									<div class="col-md-8 col-sm-8 col-xs-8" >
										<div class="form-group">
											<label class="form-label">Major Name</label>
											<!-- <span class="help">asdf</span> -->
											<!-- <span>This Field Is Required</span> -->
											<div class="controls">
												<input disabled type="text" name="room_name" class="form-control" value="<?php echo $result['name']; ?>">
											</div>
										</div>
									</div>
								</div>
							</form>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="grid simple">
							<div class="grid-title no-border">
								<h4>Major Courses</h4>
							</div>
							<div class="grid-body no-border">
								<form id="majorCourseForm" action="#">
									<div class="row">
										<div class="col-sm-12">
											<select name="course_id">
												<?php
													foreach($courseList as $instance) {
														$html = "<option value='" . $instance['id'] . "'>" . $instance['name'] . "</option>";
														echo $html;
													}
												?>
											</select>
											<select name="semester" class="dropdown100px">
												<option value="1">Semester 1</option>
												<option value="2">Semester 2</option>
												<option value="3">Semester 3</option>
												<option value="4">Semester 4</option>
												<option value="5">Semester 5</option>
												<option value="6">Semester 6</option>
												<option value="7">Semester 7</option>
												<option value="8">Semester 8</option>
											</select>
											<input type="hidden" name="major_id" value="<?php echo $id?>">
											<button id="addCourseToMajorButton" class="buttonAdjacentInput">Add to Major</button>
										</div>
									</div>
								</form>
							</div>
							<div class="grid-body no-border">
								<table class="table" id="courseTable">
									<thead>
										<tr>
											<th>Course</th>
											<th>Semester</th>
											<th>Remove</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach($majorCourseList as $instance) {
												$html = "<tr data-course='" . $instance['courseId'] . "'>";
												$html .= "<td>" . $instance['course'] . "</td>";
												$html .= "<td>" . $instance['semester'] . "</td>";
												$html .= "<td><button class='removeCourseButton'>Remove</button></td>";
												$html .= "</tr>";

												echo $html;
											}
										?>
									</tbody>
								</table>
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
		$("#courseTable").DataTable();

		$("#deleteButton").click(function() {
			let roomId = new URLSearchParams(window.location.search).get('id');
			$.post("/beacon_backend/api/major/delete.php", {id: roomId}, function(data, status) {
				if(status == "success") {
					$("#pageForm").prepend(
						"<div class='alert alert-success'>" +
							"<button class='close' data-dismiss='alert'></button>" +
							"Success: The record has been deleted." +
						"</div>"
					);
				} else {
					$("#pageForm").prepend(
						"<div class='alert alert-error'>" +
							"<button class='close' data-dismiss='alert'></button>" +
							"Error: Transaction failed." +
						"</div>"
					);
				}
			});
		});

		$("#majorCourseForm").submit(function(e) {
			e.preventDefault()
			let formVal = $(this).serialize()
			$.post("/beacon_backend/api/major_has_course/create.php", formVal, function(data, status) {
				if(data.message == "success") {
					$("#majorCourseForm").prepend(
						"<div class='alert alert-success'>" +
							"<button class='close' data-dismiss='alert'></button>" +
							"Success: The record has been created." +
						"</div>"
					)
				} else {
					$("#majorCourseForm").prepend(
						"<div class='alert alert-error'>" +
							"<button class='close' data-dismiss='alert'></button>" +
							"Error: Transaction failed." +
						"</div>"
					)	
				}
			})
		})

		$(".removeCourseButton").click(function() {
			let formVal = {
				"major_id": $("input[name='major_id']").val(),
				"course_id": $(this).closest('tr').data('course')
			}
			$.post("/beacon_backend/api/major_has_course/delete.php", formVal, function(data, status) {
				if(data.message == "success") {
					$("#majorCourseForm").prepend(
						"<div class='alert alert-success'>" +
							"<button class='close' data-dismiss='alert'></button>" +
							"Success: The record has been deleted." +
						"</div>"
					)
				} else {
					$("#majorCourseForm").prepend(
						"<div class='alert alert-error'>" +
							"<button class='close' data-dismiss='alert'></button>" +
							"Error: Transaction failed." +
						"</div>"
					)	
				}
			})
		})
	});
</script>
</html>