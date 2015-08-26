<!-- <script type="text/javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
<script type="text/javascript" src="js/jquery.1.11.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/alpaca-core.min.js"></script>
<script type="text/javascript" src="js/lodash.js"></script>
<script type="text/javascript" src="js/lodash-deep.js"></script>
<script type="text/javascript" src="js/alpacajs-ux-form-editor.js"></script>

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
		<div class="context-mnu-item">Basic</div>
		<div class="context-mnu-item">Advanced</div>
		<div class="context-mnu-item">Dependency</div>
		<div class="context-mnu-item">WP Action</div>
	</div>
	<div class="helper-items-body" style="width:70%; float:right">
		
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

		window.update_textareas = function(options,schema){
			$("#schema_output").text(JSON.stringify(schema));
			$("#options_output").text(JSON.stringify(options));
		}

		/* ACTIONS EVENTS HANDLERS */

		$(document).on("click", "div .helper-object-remove", function(e) { 
			
			e.stopPropagation();

			_UXFORM.paths_helper.keys_array = [];
			_UXFORM.get_paths( $(this).parent() );
			_UXFORM.remove_element( $(this).parent() );
			
		});

		$(document).on("click", "li", function(e) { 
		//$(".alpaca-fieldset-item-container").live('click', function(e) {

			e.stopPropagation();

			_UXFORM.paths_helper.keys_array = [];
			_UXFORM.get_paths( $(this) );



			if( $(this).hasClass("alpaca_container_selected") ){
				$('li').removeClass( "alpaca_container_selected" );

				$(this).find('.helper-item-details').remove();
			}else{
				$('li').removeClass( "alpaca_container_selected" );
				$(this).addClass( "alpaca_container_selected" );
				_UXFORM.render_field_options($(this));

			}

			_UXFORM.colorize_path(_UXFORM.paths_helper.keys_array);

			

	    });

		$(document).on("click", "div.helper-item-details", function(e) { 
		//$(".helper-item-details").live('click', function(e) {                 
	        e.stopPropagation();
	    });

	    $('#add_input').click(function(){
		    _UXFORM.add_new_element('string','');
		});

		$('.new_element').click(function(){
			_UXFORM.add_new_element($(this).attr('data-type'),$(this).attr('data-object-name'));
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
			alert('change'+$(this).attr('data-type'));
			if($(this).attr('data-type') == 'option'){				
				_UXFORM.add_option_value($(this), $(this).attr('name'));
			}
			if($(this).attr('data-type') == 'shema-key'){
				alert('error on this field on children with container');
				var output = _UXFORM.rename_schema_key($(this));
				alert(output);
				$(this).closest('li').children('.helper-object-key').text(output);
				$(this).closest('li').find('.title').text(output);
				$(this).closest('li').attr('data-alpaca-item-container-item-key', output);
			}
			window.update_textareas(_UXFORM.data.options,_UXFORM.data.schema);

		});

		/* INIT  */
	    
	    <?php if(@$_POST["schema_output"] != ''){ ?>
			
			var data = {
				"options":<?php echo $_POST["options_output"]; ?>,
				"schema": <?php echo $_POST["schema_output"]; ?>, 
				"view":"VIEW_WEB_DISPLAY_LIST"
			}
			_UXFORM.funcrion_render_alpaca(data);
	    
	    <?php }else{ ?>

	    	/* standard init method */
 			_UXFORM.funcrion_render_alpaca(_UXFORM.data);

	    <?php } ?>

	    window.run_sortable = function(){

    		

	    }


		window.wordpress_autocomple_names = function (data){
			/* WORDPRESS names mapping */
			dictionary = {
				'wp_actions':[
					'wp_mail',
					'wp_insert_comment',
					'wp_insert_post',
					'wp_insert_user',
					'wp_signon',
					'wp_redirect',
					'register_post_type'
				],
				'wp_insert_post':[
					'post_content',
					'post_name',
					'post_title',
					'post_status',
					'post_type',
					'post_author',
					'ping_status',
					'default_ping_status',
					'post_parent',
					'menu_order',
					'to_ping',
					'pinged',
					'post_password',
					'guid',
					'post_content_filtered',
					'post_excerpt',
					'post_date_gmt',
					'comment_status',
					'post_category',
					'tags_input',
					'tax_input',
					'page_template'
				],
				'wp_insert_user':[
					'user_pass',
					'user_login',
					'user_nicename',
					'user_url',
					'user_email',
					'display_name',
					'nickname',
					'first_name',
					'last_name',
					'description',
					'rich_editing',
					'user_registered',
					'role',
					'jabber',
					'aim',
					'yim'
				]
			};

		    $( "input[name='name']" ).autocomplete({
		      source: dictionary[data],
		      close: function( event, ui ) {
		      	console.log(event);
		        if($(this).attr('data-type') == 'shema-key'){
					
					var output = _UXFORM.rename_schema_key($(event.target));
					$(event.target).parents('li').find('.helper-object-key').text(output);
					/* OR */
					$(event.target).parents('li').find('.alpaca-fieldset-legend').children('.title').text(output);
					
				}
				window.update_textareas(_UXFORM.data.options,_UXFORM.data.schema);
		      },
		    });
		}
	});

</script>

