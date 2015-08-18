<!-- <script type="text/javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
<script type="text/javascript" src="js/jquery.1.11.1.min.js"></script>
<script type="text/javascript" src="js/alpaca-core.min.js"></script>
<script type="text/javascript" src="js/lodash.js"></script>
<script type="text/javascript" src="js/lodash-deep.js"></script>
<script type="text/javascript" src="js/alpacajs-ux-form-editor.js"></script>

<script type="text/javascript" src="js/main-templates.js"></script>

<link type="text/css" href="css/alpaca-min.css" rel="stylesheet"/>
<link type="text/css" href="css/main-style.css" rel="stylesheet"/>

<body>
	<h1>Form creator</h1>
	<div id="main_container" data-path="/" style="float:left; width:70%">
	</div>
	<div id="forms-elements" style="float:right: width:25%; text-align:center">
		<a id="add_input" href="#" class="button action" style="width:200px; margin-bottom:2px">input text</a><Br/>
		<a id="add_select" href="#" class="button action" style="width:200px; margin-bottom:2px">multi choice</a><Br/>
		<a id="add_checkbox" href="#" class="button action" style="width:200px; margin-bottom:2px">single checkbox</a><Br/>
		<a id="add_object" href="#" class="button action" style="width:200px; margin-bottom:2px">fieldset (container)</a><Br/>
		<a id="add_array" href="#" class="button action" style="width:200px; margin-bottom:2px">array (repeater)</a><Br/>
	</div>

	<br style="clear:both"/>

	<h2>Form schema and options output</h2>
	<form method="post" action="test/index.php">
		<table style="width:100%">
			<tr>
				<td>Schema<textarea id="schema_output" name="schema_output"></textarea></td>
				<td>Options<textarea id="options_output" name="options_output"></textarea></td>
			</tr>
		</table>	
		<table style="width:100%">
			<tr>
				<td>
					<input type="submit" id="renderForm" href="#" class="buttondown" value="Show created form">
				</td>
			</tr>
		</table>	
	</form>
</body>

<script id="helper-container-tpl" type="text/x-jquery-tmpl">
	<div class="helper-item-details">
	<div class="context-mnu"> 
		<div class="context-mnu-item">Basic</div>
		<div class="context-mnu-item">Advanced</div>
		<div class="context-mnu-item">Dependency</div>
		<div class="context-mnu-item">WP Action</div>
	</div>
	<div class="helper-items-body" style="width:80%; float:right">
		<label class="label">name</label>
		<input class="input-helper" type="text" name="name" data-type="shema-key">
	</div>
	<br style="clear:both">
	</div>

</script>

<script id="helper-input-tpl" type="text/x-jquery-tmpl">
	<label class="label">${label}</label>
	<input class="input-helper" type="text" name="${name}" data-type="${type}" value="${value}">
</script>

<script type="text/javascript">
	jQuery(document).ready(function($) {

		/* ACTIONS EVENTS HANDLERS */

		$(document).on("click", "div .helper-object-remove", function(e) { 
			
			_UXFORM.remove_element($(this));
			//e.stopPropagation();
		});

		$(document).on("click", "li.alpaca-fieldset-item-container", function(e) { 
		//$(".alpaca-fieldset-item-container").live('click', function(e) {
			e.stopPropagation();


			if(  $(this).children('fieldset').hasClass('alpaca-fieldset')  ){
				//alert('object');
			}else{			
				//alert('field');
			}	

		
			_UXFORM.paths_helper.keys_array = [];
			_UXFORM.get_paths( $(this) );
			
		

			_UXFORM.colorize_path(_UXFORM.paths_helper.keys_array);
			_UXFORM.render_field_options($(this));
			

			
	    });

		$(document).on("click", "div.helper-item-details", function(e) { 
		//$(".helper-item-details").live('click', function(e) {                 
	        e.stopPropagation();
	    });

	    $('#add_input').click(function(){
		    _UXFORM.add_new_element('string','');
		});

		$('#add_select').click(function(){
			_UXFORM.add_new_element('string',['option1','option2','option3']);
		});

		$('#add_checkbox').click(function(){
			_UXFORM.add_new_element( 'boolean' , '' );
		});

		$('#add_object').click(function(){
			_UXFORM.add_new_element( 'object' , '' );
		});

		$('#add_array').click(function(){
			_UXFORM.add_new_element( 'array' , '' );
		});

		$(document).on("change", "input.input-helper", function(e) { 
			if($(this).attr('data-type') == 'option'){				
				_UXFORM.add_option_value($(this));
			}
			
		});

		/* INIT  */
	    funcrion_render_alpaca = function (data){

			data["postRender"] = function(control){
				_UXFORM.swith_fields_to_min_mode(control);
				_UXFORM.colorize_path(_UXFORM.paths_helper.keys_array);
			}
			$("#schema_output").text(JSON.stringify(data['schema']));
			$("#options_output").text(JSON.stringify(data['options']));
	    	$("#main_container").alpaca(data);

        }

	    funcrion_render_alpaca(data);
		 
	});


</script>