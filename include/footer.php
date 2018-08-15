<?php

$footer = '
<!-- BEGIN CORE JS FRAMEWORK-->
<script src="../../assets/plugins/pace/pace.min.js" type="text/javascript"></script>
<!-- BEGIN JS DEPENDECENCIES-->
<script src="../../assets/plugins/jquery/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="../../assets/plugins/bootstrapv3/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../assets/plugins/jquery-block-ui/jqueryblockui.min.js" type="text/javascript"></script>
<script src="../../assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
<script src="../../assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js" type="text/javascript"></script>
<script src="../../assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
<script src="../../assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="../../assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
<!-- END CORE JS DEPENDECENCIES-->
<!-- BEGIN CORE TEMPLATE JS -->
<script src="../../webarch/js/webarch.js" type="text/javascript"></script>
<script src="../../assets/js/chat.js" type="text/javascript"></script>
<!-- END CORE TEMPLATE JS -->
<!-- BEGIN PAGE LEVEL JS -->
<script src="../../assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="../../assets/plugins/jquery-ricksaw-chart/js/raphael-min.js"></script>
<script src="../../assets/plugins/jquery-ricksaw-chart/js/d3.v2.js"></script>
<script src="../../assets/plugins/jquery-ricksaw-chart/js/rickshaw.min.js"></script>
<script src="../../assets/plugins/jquery-sparkline/jquery-sparkline.js"></script>
<script src="../../assets/plugins/skycons/skycons.js"></script>
<script src="../../assets/plugins/owl-carousel/owl.carousel.min.js" type="text/javascript"></script>
<!-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script> -->
<!-- <script src="../../assets/plugins/jquery-gmap/gmaps.js" type="text/javascript"></script> -->
<script src="../../assets/plugins/Mapplic/js/jquery.easing.js" type="text/javascript"></script>
<script src="../../assets/plugins/Mapplic/js/jquery.mousewheel.js" type="text/javascript"></script>
<script src="../../assets/plugins/Mapplic/js/hammer.js" type="text/javascript"></script>
<script src="../../assets/plugins/Mapplic/mapplic/mapplic.js" type="text/javascript"></script>
<script src="../../assets/plugins/jquery-flot/jquery.flot.js" type="text/javascript"></script>
<script src="../../assets/plugins/jquery-metrojs/MetroJs.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN CORE TEMPLATE JS -->
<!-- <script src="../../assets/js/dashboard_v2.js" type="text/javascript"></script> -->
<script>
	$(document).ready(function() {
		var path = window.location.pathname;
		var dir = path.substring(path.indexOf("/", 1)+7, path.lastIndexOf("/"));
		
		if(dir == "home") {
			$(".side-home").addClass("active");
		} else if(dir == "attendance") {
			$(".side-attendance").addClass("active");
		} else if(dir == "class") {
			$(".side-class").addClass("active");
		} else if(dir == "course") {
			$(".side-course").addClass("active");
		} else if(dir == "student") {
			$(".side-student").addClass("active");
		} else if(dir == "major") {
			$(".side-major").addClass("active");
		} else if(dir == "room") {
			$(".side-room").addClass("active");
		}
	});
</script>
';
?>