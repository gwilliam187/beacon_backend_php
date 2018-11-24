<?php

include('../../include/include.php');

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
	  </div><!-- END CONTAINER -->
	</body>
	<?php echo $footer; ?>
</html>