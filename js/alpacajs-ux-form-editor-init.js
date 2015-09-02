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
				_UXFORM.render_field_options($(this),'basic');
			}

			_UXFORM.colorize_path(_UXFORM.paths_helper.keys_array);

	    });


		$(document).on("click", "div.helper-item-details", function(e) { 
		//$(".helper-item-details").live('click', function(e) {                 
	        e.stopPropagation();
	    });

	    $(document).on("click", "div.context-mnu-item", function(e) { 
		//$(".helper-item-details").live('click', function(e) {                 
	        e.stopPropagation();
	        $('.context-mnu-item').removeClass('selected_button');
	        $(this).addClass('selected_button');
	        _UXFORM.render_field_options($(this).parents('li'),$(this).attr('data-selected'));

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

		$(document).on("change", ".input-helper", function(e) { 
			//alert('change'+$(this).attr('data-type'));

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

			if($(this).attr('name') == 'type'){
				$(this).parents('li').attr('data-ftype', $(this).val());
				alert('MVP say: close and open bar to reload options');
			}

		});

		/* INIT  */

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