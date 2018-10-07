<?php

include('../../include/include.php');

if(!isset($_GET["id"])) {
  header("Location: ../student/view.php");
}

$id = $_GET["id"];
$getData = callAPI("GET", "http://localhost/beacon_backend/api/student/readOne.php?id=" . $id, false);
$result = json_decode($getData, true);

$getData = callAPI("GET", "http://localhost/beacon_backend/api/major/read.php", false);
$majorList = json_decode($getData, true);

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
					<li><a href="#" class="active">Edit Student</a> </li>
				</ul>
				<div class="page-title"> <i class="icon-custom-left"></i>
					<h3>Student - <span class="semi-bold">Edit</span></h3>
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
                  <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                  <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-8">
                      <div class="form-group">
                        <label class="form-label">Student ID</label>
                        <!-- <span class="help">asdf</span> -->
                        <!-- <span>This Field Is Required</span> -->
                        <div class="controls">
                          <input disabled type="text" name="id" class="form-control" value="<?php echo $result['id']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="form-label">Name</label>
                        <div class="controls">
                          <input type="text" name="name" class="form-control" value="<?php echo $result['name']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="form-label">Entrance Date</label>
                        <div class="controls">
                          <input type="date" name="entrance_date" class="form-control" value="<?php echo $result['entranceDate']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="controls">
                          <input type="text" name="pass" class="form-control" value="<?php echo $result['pass']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="form-label">Major</label>
                        <div class="controls">
                          <select name="major" class="form-control">
                            <?php
                              foreach($majorList as $major) {
                                $html = "<option value=" . $major["id"][$i] . " " . 
																		(($major["id"] == $result["majorId"]) ? 'selected="selected"' : "") . 
																		">" . $major["name"]."</option>";
                                echo $html;
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
  								</div>
                  <div>
  	              	<button class="custom-submit-button">Update</button>
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
      $.post("/beacon_backend/api/student/update.php", data, function(data, status) {
        if(status == "success") {
          $("#pageForm").prepend(
            "<div class='alert alert-success'>" +
              "<button class='close' data-dismiss='alert'></button>" +
              "Success: The record has been updated." +
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
    })
  })
</script>
</html>