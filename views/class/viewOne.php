<?php

include('../../include/include.php');

if(!isset($_GET["id"])) {
  header("Location: ../class/view.php");
}

$id = $_GET["id"];
$getData = callAPI("GET", "http://localhost/beacon_backend/api/class/readOne.php?id=" . $id, false);
$detail = json_decode($getData, true);

$getData = callAPI("GET", "http://localhost/beacon_backend/api/class_has_student/readStudentsInClass.php?class_id=" . $id, false);
$classStudentList = json_decode($getData, true);

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
					<li><a href="#" class="active">View Classes</a> </li>
				</ul>
				<div class="page-title"> <i class="icon-custom-left"></i>
					<h3>Class - <span class="semi-bold">Detail</span></h3>
				</div>
				<div class="row" >
          <div class="col-md-12">
            <div class="grid simple">
              <div class="grid-title no-border">
                <h4>Class Detail</h4>
                <div class="tools custom-tools">
                  <a href="edit.php?id=<?php echo $detail['id']; ?>">Edit</a>
                  <a href="#" id="deleteButton">Delete</a>
                  <a href="javascript:;" class="collapse"></a>
                </div>
              </div>
              <div class="grid-body no-border">
                <form id="pageForm">
                <div class="row">
                  <div class="col-md-8 col-sm-8 col-xs-8" >
                    <div class="form-group">
                      <label class="form-label">Course</label>
                      <!-- <span class="help">asdf</span> -->
                      <!-- <span>This Field Is Required</span> -->
                      <div class="controls">
                        <input disabled type="text" class="form-control" value="<?php echo $detail['course']; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Date</label>
                      <div class="controls">
                        <input disabled type="text" class="form-control" value="<?php echo date('d M Y', strtotime($detail['date'])); ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Start Time</label>
                      <div class="controls">
                        <input disabled type="text" class="form-control" value="<?php echo date('H:i', strtotime($detail['startTime'])); ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="form-label">End Time</label>
                      <div class="controls">
                        <input disabled type="text" class="form-control" value="<?php echo date('H:i', strtotime($detail['endTime'])); ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Room</label>
                      <div class="controls">
                        <input disabled type="text" class="form-control" value="<?php echo $detail['room']; ?>">
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
                <h4>Class Students</h4>
                <div class="tools custom-tools">
                  <a href="../class_has_student/edit.php?id=<?php echo $detail['id']; ?>">Edit</a>
                  <a href="javascript:;" class="collapse"></a>
                </div>
              </div>
              <div class="grid-body no-border">
                <table class="table" id="classStudentTable">
                  <thead>
                    <tr>
                      <th>Student ID</th>
                      <th>Name</th>
                      <th>Major</th>
                      <th>Attend Time</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    foreach($classStudentList as $instance) {
                      $html = "<tr>";
                      $html .= "<td>" . $instance['studentId'] . "</td>";
                      $html .= "<td>" . $instance['student'] . "</td>";
                      $html .= "<td>" . $instance['major'] . "</td>";
                      $html .= "<td>" . ($instance['attendTime'] != "Not attended" ? date('H:i', strtotime($instance['attendTime'])) : $instance['attendTime']) . "</td>";
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
    $("#deleteButton").click(function() {
      let studentId = new URLSearchParams(window.location.search).get('id');
      $.post("/beacon_backend/api/class/delete.php", {id: studentId}, function(data, status) {
        if(data.message == "success") {
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

    $("#classStudentTable").dataTable()
  });
</script>
</html>