<?php

include('../../include/include.php');

$getData = callAPI("GET", "http://localhost/beacon_backend/api/course/read.php", false);
$courseList = json_decode($getData, true);

$getData = callAPI("GET", "http://localhost/beacon_backend/api/room/read.php", false);
$roomList = json_decode($getData, true);

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
					<li><a href="#" class="active">Add Class</a> </li>
				</ul>
				<div class="page-title"> <i class="icon-custom-left"></i>
					<h3>Class - <span class="semi-bold">Add</span></h3>
				</div>
				<div class="row" >
          <div class="col-md-12">
            <div class="grid simple">
              <div class="grid-title no-border">
                <!-- <h4>Add Room</h4> -->
                <!-- <div class="tools">
                  <a href="javascript:;" class="collapse"></a>
                  <a href="javascript:;" class="reload"></a>
                </div> -->
              </div>
              <div class="grid-body no-border">
                <br>
                <form id="pageForm">
                  <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-8">
                    	<div class="form-group">
                        <label class="form-label">Course</label>
                        <div class="controls">
                          <select name="course" class="form-control">
                            <?php
                              foreach($courseList as $major) {
                                $html = "<option value='" . $major["id"] . "'>" . $major['name'] . "</option>";
                                echo $html;
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="form-label">Date</label>
                        <div class="controls">
                          <input type="date" name="date" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="form-label">Start Time</label>
                        <div class="controls">
                          <input type="time" name="start_time" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="form-label">End Time</label>
                        <div class="controls">
                          <input type="time" name="end_time" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="form-label">Room</label>
                        <div class="controls">
                          <select name="room" class="form-control">
                            <?php
                              foreach($roomList as $room) {
                                $html = "<option value='" . $room["id"] . "'>" . $room['name'] . "</option>";
                                echo $html;
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
  								</div>
                  <div>
  	              	<button class="custom-submit-button">Add</button>
  	              </div>
                </form>
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
    $("#pageForm").submit(function(e) {
      e.preventDefault();
      var data = $(this).serialize();
      $.post("/beacon_backend/api/class/create.php", data, function(data, status) {
        if(data.message == "success") {
          $("#pageForm").prepend(
            "<div class='alert alert-success'>" +
              "<button class='close' data-dismiss='alert'></button>" +
              "Success: The record has been added." +
            "</div>"
          );
        } else {
          $("#pageForm").prepend(
            "<div class='alert alert-error'>" +
              "<button class='close' data-dismiss='alert'></button>" +
              "Error: Transaction Failed." +
            "</div>"
          );
        }
      });
    })
  })
</script>
</html>