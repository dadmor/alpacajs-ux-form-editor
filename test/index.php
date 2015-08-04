<script type="text/javascript" src="../js/jquery.1.11.1.min.js"></script>
<script type="text/javascript" src="../js/alpaca-core.min.js"></script>
<link type="text/css" href="../js/alpaca-min.css" rel="stylesheet"/>

<div id="main_container">
</div>

<script>
	$("#main_container").alpaca({
		"options":<?php echo $_POST['options_output']?>,
		"schema":<?php echo $_POST['schema_output']?>
	});
</script>