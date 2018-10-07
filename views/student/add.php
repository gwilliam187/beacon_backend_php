<?php

include('../../include/include.php');

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
					<li><a href="#" class="active">Add Student</a> </li>
				</ul>
				<div class="page-title"> <i class="icon-custom-left"></i>
					<h3>Student - <span class="semi-bold">Add</span></h3>
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
                    <div class="col-md-8 col-sm-8 col-xs-8" >
                      <div class="form-group">
                        <label class="form-label">Student ID</label>
                        <!-- <span class="help">asdf</span> -->
                        <!-- <span>This Field Is Required</span> -->
                        <div class="controls">
                          <input type="text" name="id" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="form-label">Name</label>
                        <div class="controls">
                          <input type="text" name="name" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="form-label">Entrance Date</label>
                        <div class="controls">
                          <input type="date" name="entrance_date" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="controls">
                          <input type="text" name="pass" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="form-label">Major</label>
                        <div class="controls">
                          <select name="major" class="form-control">
                            <?php
                              foreach($majorList as $major) {
                                $html = "<option value='" . $major["id"] . "'>" . $major['name'] . "</option>";
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
      // alert($("input[name='entrance_date']").val())
      // alert(data)
      $.post("/beacon_backend/api/student/create.php", data, function(data, status) {
        if(status == "success") {
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