<?php

include('../../include/include.php');

$getData = callAPI("GET", "http://localhost/beacon_backend/api/class/read.php", false);
$classList = json_decode($getData, true);

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
					<h3>Class - <span class="semi-bold">View</span></h3>
				</div>
				<div class="row-fluid">
          <div class="span12">
            <div class="grid simple">
              <div class="grid-title">
                <h4>Advance <span class="semi-bold">Options</span></h4>
                <div class="tools">
                  <a href="javascript:;" class="collapse"></a>
                  <a href="#grid-config" data-toggle="modal" class="config"></a>
                  <a href="javascript:;" class="reload"></a>
                  <a href="javascript:;" class="remove"></a>
                </div>
              </div>
              <div class="grid-body ">
                <table class="table" id="dataTable">
                  <thead>
                    <tr>
                      <th>Course</th>
                      <th>Date</th>
                      <th>Start Time</th>
                      <th>End Time</th>
                      <th>Room</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php
                  		foreach($classList as $instance) {
                  			$html = "<tr>";
                  			$html .= "<td><a href='viewOne.php?id=" . $instance['id'] . "'>" . $instance['course'] . "</a></td>";
                        $html .= "<td>" . date('d M Y', strtotime($instance['date'])) . "</td>";
                        $html .= "<td>" . date('H:i', strtotime($instance['startTime'])) . "</td>";
                        $html .= "<td>" . date('H:i', strtotime($instance['endTime'])) . "</td>";
                        $html .= "<td>" . $instance['room'] . "</td>";
                  			$html .= "</tr>";

                  			echo $html;
                  		}
                  	?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
			</div><!-- END CONTENT -->
		</div><!-- END PAGE CONTAINER -->
	</div><!-- END CONTAINER -->
</body>
<?php echo $footer; ?>
<script>
  $(document).ready(function() {
    $("#dataTable").dataTable();
  })
</script>
</html>