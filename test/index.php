<script type="text/javascript" src="../js/jquery.1.11.1.min.js"></script>
<script type="text/javascript" src="../js/alpaca-core.min.js"></script>
<link type="text/css" href="../js/alpaca-min.css" rel="stylesheet"/>
<h2>Form example:</h2>
<div id="main_container"></div>
<form method="post" action="../index.php">
	<hr>
	<button>< back to editor</button>
	<hr>
	<h2>Options:</h2>
	<textarea name="options_output" style="width:100%; height:200px"><?php echo $_POST['options_output']?></textarea>
	<h2>Schema:</h2>
	<textarea name="schema_output" style="width:100%; height:200px"><?php echo $_POST['schema_output']?></textarea>
</form>
<script>
	$("#main_container").alpaca({
		"options":<?php echo $_POST['options_output']?>,
		"schema":<?php echo $_POST['schema_output']?>
	});
</script>

