<!-- <script type="text/javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
<script type="text/javascript" src="js/jquery.1.11.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/alpaca-core.min.js"></script>
<script type="text/javascript" src="js/lodash.js"></script>
<script type="text/javascript" src="js/lodash-deep.js"></script>
<script type="text/javascript" src="js/alpacajs-ux-form-editor.js"></script>
<script type="text/javascript" src="js/alpacajs-ux-form-editor-init.js"></script>


<script type="text/javascript" src="js/main-templates.js"></script>

<link type="text/css" href="css/alpaca-min.css" rel="stylesheet"/>
<link type="text/css" href="css/ux-form-editor-style.css" rel="stylesheet"/>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

<body>
	<div style="font-size:12px; color:#aaa;">Deep beta, many methods is under construction, not stable yet!!!</div>
	<div style="font-size:12px; color:#aaa;">GitHub: <a href="https://github.com/dadmor/alpacajs-ux-form-editor">https://github.com/dadmor/alpacajs-ux-form-editor</a></div>
	<div style="font-size:12px; color:#aaa;">DOCUMENTATION: <a href="http://alpacajs.org/documentation.html">http://alpacajs.org/documentation.html</a></div>
	<div style="font-size:12px; color:#aaa;">Author: Grzegorz Durtan, Owner: BlockBox sp. z o.o. Licence GPL 2.0</div>
	
	<h1 id="form-title">Form creator</h1>

	<div id="main_container" data-path="/" style="float:left; width:70%">
	</div>
	<div id="forms-elements" style="float:right: width:25%; text-align:center; position:fixed; right:20px">
		<a id="add_input" href="#" class="button action" style="width:200px; margin-bottom:2px">+ ADD FIELD (text)</a><Br/>
		<!-- <a id="add_select" href="#" class="button action" style="width:200px; margin-bottom:2px">multi choice</a><Br/>
		<a id="add_checkbox" href="#" class="button action" style="width:200px; margin-bottom:2px">single checkbox</a><Br/> -->
		<a id="add_object" href="#" class="button action" style="width:200px; margin-bottom:2px">CONTAINER (fieldset)</a><Br/>
		<a id="add_array" href="#" class="button action" style="width:200px; margin-bottom:2px">REPEATER (array)</a><Br/>
		<div style="line-height:40px">WordPress Templates</div>
		<a href="#" class="button action new_element" data-object-name="wp_mail" data-type="object-schema" style="width:200px; margin-bottom:2px">wp_mail</a><Br/>
		<a href="#" class="button action new_element" data-object-name="wp_insert_post" data-type="object-schema" style="width:200px; margin-bottom:2px">wp_insert_post</a><Br/>

		<a id=".add_model_insert_post" href="#" class="button action" style="width:200px; margin-bottom:2px">wp_insert_user</a><Br/>
		<a id=".add_model_insert_post" href="#" class="button action" style="width:200px; margin-bottom:2px">wp_signon</a><Br/>
		<a id=".add_model_insert_post" href="#" class="button action" style="width:200px; margin-bottom:2px">wp_redirect</a><Br/>
	</div>

	<br style="clear:both"/>
	<br style="clear:both"/>
	<br style="clear:both"/>
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
		<div class="context-mnu-item {{if selected == 'basic' }}selected_button{{/if}}" data-selected="basic">Basic</div>
		<div class="context-mnu-item {{if selected == 'advanced' }}selected_button{{/if}}" data-selected="advanced">Advanced</div>
		<!--<div class="context-mnu-item {{if selected == 'xxx' }}selected_button{{/if}}" data-selected="dependecny">Dependency</div>-->
	</div>
	<div class="helper-items-body" style="width:70%; float:right">
		
	</div>
	<br style="clear:both">

	</div>
</script>

<script id="helper-input-tpl" type="text/x-jquery-tmpl">
	{{if section == selected_section }}
		{{if input_type == 'text' }}
			<label class="label">${label}</label>
			<input class="input-helper" type="text" name="${name}" data-type="${type}" value="${value}">
		{{/if}}
		{{if input_type == 'select' }}
			<label class="label">${label}</label>
			<select class="input-helper" name="${name}" data-type="${type}">
				{{each(i, result) input_data}}
					{{if result == value }}
						<option value="${result}" selected="selected">${result}</option>
					{{else}}
						<option value="${result}">${result}</option>
					{{/if}}
				{{/each}}
			</select>
		{{/if}}
	{{/if}}
</script>

<script type="text/javascript">


<?php if(@$_POST["schema_output"] != ''){ ?>
	window.post_options = <?php echo stripslashes(@$_POST["options_output"]); ?>;
	window.post_schema = <?php echo stripslashes(@$_POST["schema_output"]); ?>;
	var data = {
		"options":window.post_options,
		"schema": window.post_schema, 
		"view":"VIEW_WEB_DISPLAY_LIST"
	}
	_UXFORM.funcrion_render_alpaca(data);

<?php }else{ ?>

	/* standard init method */
		_UXFORM.funcrion_render_alpaca(_UXFORM.data);

<?php } ?>
</script>



