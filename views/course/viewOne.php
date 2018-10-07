<?php

include('../../include/include.php');

if(!isset($_GET["id"])) {
  header("Location: ../course/view.php");
}

$id = $_GET["id"];
$getData = callAPI("GET", "http://localhost/beacon_backend/api/course/readOne.php?id=" . $id, false);
$result = json_decode($getData, true);

$getStudents = callAPI("GET", "http://localhost/beacon_backend/api/course_has_student/readStudentsInCourse.php?course_id=" . $id, false);
$studentList = json_decode($getStudents, true);

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
					<li><a href="#" class="active">View Course</a> </li>
				</ul>
				<div class="page-title"> <i class="icon-custom-left"></i>
					<h3>Course - <span class="semi-bold">Detail</span></h3>
				</div>
				<div class="row" >
          <div class="col-md-12">
            <div class="grid simple">
              <div class="grid-title no-border">
                <h4>Course Details</h4>
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
                <h4>Course Students</h4>
                <div class="tools custom-tools">
                  <a href="../course_has_student/edit.php?id=<?php echo $result['id']; ?>">Edit</a>
                </div>
              </div>
              <div class="grid-body no-border">
                <table class="table" id="allStudentTable">
                  <thead>
                    <tr>
                      <th>Student ID</th>
                      <th>Name</th>
                      <th>Major</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      foreach($studentList as $instance) {
                        $html = "<tr>";
                        $html .= "<td>" . $instance['studentId'] . "</td>";
                        $html .= "<td>" . $instance['student'] . "</td>";
                        $html .= "<td>" . $instance['major'] . "</td>";
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
    $('#allStudentTable').dataTable()

    $("#deleteButton").click(function() {
      let roomId = new URLSearchParams(window.location.search).get('id');
      $.post("/beacon_backend/api/course/delete.php", {id: roomId}, function(data, status) {
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
  });
</script>
</html>