<?php

include('../../include/include.php');

if(!isset($_GET["id"])) {
  header("Location: ../room/view.php");
}

$id = $_GET["id"];
$getData = callAPI("GET", "http://localhost/beacon_backend/api/room/readOne.php?id=" . $id, false);
$result = json_decode($getData, true);

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
					<li><a href="#" class="active">View Rooms</a> </li>
				</ul>
				<div class="page-title"> <i class="icon-custom-left"></i>
					<h3>Room - <span class="semi-bold">Detail</span></h3>
				</div>
				<div class="row" >
          <div class="col-md-12">
            <div class="grid simple">
              <div class="grid-title no-border">
                <!-- <h4>Add Room</h4> -->
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
                      <label class="form-label">Room Name</label>
                      <!-- <span class="help">asdf</span> -->
                      <!-- <span>This Field Is Required</span> -->
                      <div class="controls">
                        <input disabled type="text" name="room_name" class="form-control" value="<?php echo $result['name']; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Beacon UID</label>
                      <div class="controls">
                        <input disabled type="text" name="room_name" class="form-control" value="<?php echo $result['beacon']; ?>">
                      </div>
                    </div>
                  </div>
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
    $("#deleteButton").click(function() {
      let roomId = new URLSearchParams(window.location.search).get('id');
      $.post("/beacon_backend/api/room/delete.php", {id: roomId}, function(data, status) {
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