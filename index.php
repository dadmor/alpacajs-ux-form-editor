<!-- <script type="text/javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
<script type="text/javascript" src="js/jquery.1.11.1.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="js/alpaca-core.min.js"></script>
<script type="text/javascript" src="js/lodash.js"></script>
<script type="text/javascript" src="js/lodash-deep.js"></script>
<script type="text/javascript" src="js/alpacajs-ux-form-editor.js"></script>

<script type="text/javascript" src="js/main-templates.js"></script>

<link type="text/css" href="css/alpaca-min.css" rel="stylesheet"/>
<link type="text/css" href="css/main-style.css" rel="stylesheet"/>

<body>
	<h1 id="form-title">Form creator</h1>
	<div id="main_container" data-path="/" style="float:left; width:70%">
	</div>
	<div id="forms-elements" style="float:right: width:25%; text-align:center; position:fixed; right:20px">
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

		$(document).on("click", "li.alpaca-fieldset-item-container", function(e) { 
		//$(".alpaca-fieldset-item-container").live('click', function(e) {
			e.stopPropagation();

			if( $(this).hasClass('alpaca_container_selected') ){
				$(this).find('.helper-item-details').remove();
			}else{
				_UXFORM.render_field_options($(this));
			}

			_UXFORM.paths_helper.keys_array = [];
			_UXFORM.get_paths( $(this) );

			_UXFORM.colorize_path(_UXFORM.paths_helper.keys_array);
			
			
			

			$('html, body').animate({
		        scrollTop: parseInt($(this).offset().top) - 20
		    }, 300);

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
				_UXFORM.add_option_value($(this), $(this).attr('name'));
			}
			if($(this).attr('data-type') == 'shema-key'){
				var output = _UXFORM.rename_schema_key($(this));
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


		window.wordpress_autocomple_names = function (data){
			/* WORDPRESS names mapping */
			dictionary = {
				'wp_actions':[
					'wp_insert_post',
					'wp_insert_user',
					'wp_redirect'
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

		$.fn.scrollTo = function( target, options, callback ){
  if(typeof options == 'function' && arguments.length == 2){ callback = options; options = target; }
  var settings = $.extend({
    scrollTarget  : target,
    offsetTop     : 50,
    duration      : 500,
    easing        : 'swing'
  }, options);
  return this.each(function(){
    var scrollPane = $(this);
    var scrollTarget = (typeof settings.scrollTarget == "number") ? settings.scrollTarget : $(settings.scrollTarget);
    var scrollY = (typeof scrollTarget == "number") ? scrollTarget : scrollTarget.offset().top + scrollPane.scrollTop() - parseInt(settings.offsetTop);
    scrollPane.animate({scrollTop : scrollY }, parseInt(settings.duration), settings.easing, function(){
      if (typeof callback == 'function') { callback.call(this); }
    });
  });
}
		 
	});






</script>

<input name="chuj" />