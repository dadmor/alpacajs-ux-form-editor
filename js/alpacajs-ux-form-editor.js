		/* short nodes references */
		_fs = '.alpaca-fieldset';
		_ic = '.alpaca-fieldset-item-container';
		_ic_key = 'data-alpaca-item-container-item-key';
		_dfc = 'data-first-container';
		
		/* ----------------------------------- */
		/* ALPACAJS UX EDITOR CLASS version 1.0  */
		/* author: Grzegorz Durtan (dadmor)    */
		/* license: GPL2                       */
		
		var _UXFORM = {
			
			/* PROPERTIES */
			data : {
		
				"options": {
					"fields": {}
				},
				"schema": {
					"type": "object",
					"properties": {}
				}, 
				"view":"VIEW_WEB_DISPLAY_LIST"
			},
			
			path : '',
			paths_helper:{
				'schema_keys_array' : [],
				'acctual_schema_path' : 'schema.properties.',
				'acctual_options_path' : 'options.fields.',
			},
			selected_type : '',
			fields_counter : 0,
			
			/* METHODS */

			/* ------------------------------------------------------ */
			/* RENDER RORM -------------------------------------------*/
			
			funcrion_render_alpaca : function (_data){
				/* -------------------------------------- */
				this.data = _data;
				_this = this;
				/* -------------------------------------- */
				_data["postRender"] = function(control){
					_this.swith_fields_to_min_mode(control);
					_this.colorize_path(_this.paths_helper.keys_array);
					
					/* sortable */
					$( "#main_container ol" ).sortable({
					  start: function( event, ui ) {
					  	$(this).css({'background-color':'#FDFFC7', 'outline': '#FDFFC7 solid 10px'});

					  },
					  stop: function( event, ui ) {
					  	$(this).css({'background-color':'#fff', 'outline': 'none'});
					  },

					});
					$( "#main_container ol" ).disableSelection();
				
				}
				
				/* Helper function */
				window.update_textareas(_data['options'],_data['schema']);
				$("#main_container").alpaca(_data);
			},
			swith_fields_to_min_mode : function (control){
				/* reference to class instance */
				_this = this;
				$( _ic ).each(function( index ) {
					if(  $(this).children('fieldset').hasClass('alpaca-fieldset')  ){
						$( this ).find('legend').html('<span class="title">'+$(this).attr(_ic_key)+'</span> <span> [CONTAINER] click to add elements inside me.</span>');
					}else{
						$( this ).html('<div class="helper-object-key">'+$(this).attr(_ic_key)+'</div>');
					}
					$( this ).append('<div class="helper-object-properties"><i class="fa fa-cogs"></i></div> <div class="helper-object-remove"><i class="fa fa-trash"></i></div>' )
				});
			},
			colorize_path : function(path){
				if(path == undefined){
					return false;
				};
				path.reverse();
				//$("#main_container li").removeClass('alpaca_container_selected');
				//$("#main_container li["+_ic_key+"='" + path[0] + "']" ).addClass('alpaca_container_selected');
			},
			/* ------------------------------------------------------ */
			/* ELEMENT PROPERTIES FORM -------------------------------*/
			render_field_options : function(_this){
				// _this -> $(this)
				var __this = this;
				var targetPath = this.paths_helper.acctual_options_path;

				/* GET REST JSON from URL */
				var jqxhr = $.getJSON( "json/editor-properties-fields.json", function(data) {
					var tease_array = data;
					$.each(tease_array, function( index, value ) {
						if(value['value'] == 'key'){
							tease_array[index]['value'] = __this.get_last_from_path(__this.paths_helper.acctual_schema_path);
						}
						if(value['value'] == 'option-value'){
							tease_array[index]['value'] = __this.get_option_value(targetPath+'.'+value['name']) 
						}
					});
					$('.alpaca-fieldset-item-container .helper-item-details').remove();

					$('#helper-container-tpl').tmpl([{}]).appendTo(_this);
					
					$(_this).css('display','none');
					$(_this).css('opacity', 0)
					
					$('#helper-input-tpl').tmpl(tease_array).appendTo(_this.find('.helper-items-body'));

					$('html, body').animate({
				        scrollTop: parseInt(_this.offset().top) - 20
				    }, 500);
					
					$(_this).slideDown(100);
					$(_this).animate(
						{ opacity: 1 },
						{ queue: false, duration: 300 }
					);	

				})					
				.fail(function() {
					alert( "load element error" );
				});

				/* init wordpress extentions */
				
				/* iam container */
/*				if(  _this.children('fieldset').hasClass('alpaca-fieldset')  ){
					window.wordpress_autocomple_names('wp_actions');
				}*/
				/* iam in container */
/*				if(_this.parents('li').children('fieldset').hasClass('alpaca-fieldset')){
					console.log(_this.parents('li').attr(_ic_key));
					window.wordpress_autocomple_names(_this.parents('li').attr(_ic_key));	
				}*/

			},
			add_option_value : function(_this, name){
				//this.paths_helper.keys_array
				var targetPath = this.paths_helper.acctual_options_path + '.' +name;
				_.deepSet(this.data, targetPath, $(_this).val());
			},
			get_option_value : function(label){
				var output = _.deepGet(this.data, label);
				if(output != undefined){
					return output;
				}else{
					return "";
				}
			},
			add_schema_value : function(_this, name){
				var targetPath = this.paths_helper.acctual_schema_path + '.' +name;
				_.deepSet(this.data, targetPath, $(_this).val());
			},
			get_schema_value : function(label){
				var output = _.deepGet(this.data, label);
				if(output != undefined){
					return output;
				}else{
					return "";
				}
			},

			add_new_element : function( type, object_name ){
				
				$('#main_container').children().remove();
				this.fields_counter ++;
				
				var rnd = Math.floor(Math.random() * 899999) + 100000;
				var element_name = "id_" + rnd; // + "_" + this.fields_counter;
				
				
				if(type == 'string'){	
					var path = this.create_path_to_new_element( element_name );				
					_.deepSet(this.data, path['schema_path'] + '.type', type);
					this.funcrion_render_alpaca(this.data);
				}
				if(type == 'object'){
					var path = this.create_path_to_new_element( element_name );
					_.deepSet(this.data, path['schema_path'] + '.type', type);
					_.deepSet(this.data, path['schema_path'] +'.title', "Object title");
					_.deepSet(this.data, path['schema_path'] +'.properties', false);
					this.funcrion_render_alpaca(this.data);
				}

				if(type == 'array'){
					var path = this.create_path_to_new_element( element_name );
					_.deepSet(this.data, path['schema_path'] +'.type', type);
					_.deepSet(this.data, path['schema_path'] +'.items', false);
					_.deepSet(this.data, path['schema_path'] +'.items.type', 'object');
					_.deepSet(this.data, path['schema_path'] +'.items.properties', 'false');
					this.funcrion_render_alpaca(this.data);
				}

				if(type == 'object-schema'){					
					
					var _this = this;
					var path = _this.create_path_to_new_element( object_name );
					var schema = {
						'post_title':{'type':'string','title':'Insert post title'},
						'post_excerpt':{'type':'string','title':'Insert post excerpt'},
						'post_content':{'type':'string','title':'Insert post content'}
					};

					/* GET REST JSON from URL */
					var jqxhr = $.getJSON( "json/"+object_name+"-schema.json", function(data) {
						
						_.deepSet(_this.data, path['schema_path'] +'.type', 'object');
						_.deepSet(_this.data, path['schema_path'] +'.title', "Object title");
						_.deepSet(_this.data, path['schema_path'] +'.properties', data);
						_this.funcrion_render_alpaca(_this.data);
					
					})					
					.fail(function() {
						alert( "load element error" );
					});
				}
			},
			create_path_to_new_element: function(element_name){
				/* Update json data (schema) */
				schema_path = this.paths_helper.acctual_schema_path;
				options_path = this.paths_helper.acctual_schema_path;
				
				if( this.selected_type == 'object' ){
					
					schema_path += '.properties.';
					options_path += '.fields.';

				}else{
					if(this.selected_type != ''){
						/* if selected textfield remove last key from path */
						schema_path = this.get_path_without_last(schema_path) + '.';
						options_path = this.get_path_without_last(options_path) + '.';
					}
				}
				var path = {};
				path['schema_path'] = schema_path + element_name;
				path['options_path'] = options_path + element_name;
				return path;   
			},

			remove_element : function( _this ){
				/* get parent to set path on parent */
				var parent = _this.closest('li');
				this.deepDelete(this.paths_helper.acctual_schema_path, this.data);
				this.deepDelete(this.paths_helper.acctual_options_path, this.data);
				$('#main_container').children().remove();
				this.funcrion_render_alpaca(this.data);
				this.get_paths( parent );
			},

			deepDelete : function(target, context) {				
				context = context || window;
				var targets = target.split('.');
				if (targets.length > 1)
					this.deepDelete(targets.slice(1).join('.'), context[targets[0]]);
				else
				delete context[target];
			},

			// CREARTE ALPACA PATHS METHODS
			get_paths : function(_this){
				this.paths_helper.keys_array.push(_this.attr(_ic_key))
				var find_parent = _this.parents('li');
				try {
					find_parent[0]['localName']
					this.get_paths(find_parent );
				}
				catch (e) {
					this.paths_helper.keys_array.reverse();
					this.prepare_paths(this.paths_helper.keys_array);					
				}
			},

			prepare_paths : function(form_keys_array){
				var schema_path = 'schema.properties.';
				var options_path = 'options.fields.';
				_this = this;
				$.each(form_keys_array, function( index, value ) {
					if(value == undefined){
						return false;
					}
					schema_path = schema_path + value;
					options_path = options_path + value;

					if (index != (form_keys_array.length-1)){
						if( _.deepGet(_this.data, schema_path+'.type') == 'object' ){
							schema_path = schema_path+'.properties.';
							options_path = options_path+'.fields.';
						}	
						if( _.deepGet(_this.data, schema_path+'.type') == 'array' ){
							schema_path = schema_path+'.items.properties.';
							options_path = options_path+'.fields.items.';
						}
					}else{
						_this.selected_type = _.deepGet(_this.data, schema_path+'.type');
					}
				});
				this.paths_helper.acctual_schema_path = schema_path;
				this.paths_helper.acctual_options_path = options_path;
				//console.log('Seleced path:'+schema_path);
			},

			rename_schema_key : function( _this ){

				var new_name = _this.val();
				var old_name = _this.parents('li').attr( _ic_key );
				
				var schema_colection = this.get_parents_colection( this.paths_helper.acctual_schema_path );
				var position = this.get_index_by_key( schema_colection, old_name );
				var new_schema_colection = this.add_object_between_colection( schema_colection, position, new_name, schema_colection[old_name] );
				var path_to_set = this.get_path_without_last( this.paths_helper.acctual_schema_path );
				
				_.deepSet( this.data, path_to_set, new_schema_colection );
				this.deepDelete(this.paths_helper.acctual_schema_path, this.data);

				var options_colection = this.get_parents_colection( this.paths_helper.acctual_options_path );
				if(options_colection != undefined){
					var position = this.get_index_by_key( options_colection, old_name );
					var new_options_colection = this.add_object_between_colection( options_colection, position, new_name, options_colection[old_name] );
					var path_to_set = this.get_path_without_last( this.paths_helper.acctual_options_path );
					
					_.deepSet( this.data, path_to_set, new_options_colection );
					this.deepDelete(this.paths_helper.acctual_options_path, this.data);
				}

				return new_name;
			},

			/* KEY COLECTIONS */
			/* objects with elements from container */
			get_parents_colection : function( path ){
				var name = this.get_last_from_path( path );
				var path = this.get_path_without_last( path );
				return  _.deepGet( this.data, path, name );
			},
			get_path_without_last : function( _path ){
				_path = _path.split(".");	
				_path.pop();
				return _path.join(".");
			},
			get_last_from_path : function( _path) {
				var last = _path.split(".");	
				return last[last.length-1];
			},
			get_index_by_key : function( colection , key){
				var _index = 0;
				$.each(colection, function(index, value){
					if( index == key ){
						return false;
					}
					_index++;
				});
				return _index;
			},
			add_object_between_colection : function(colection, position, obj_key, obj_val){
				
				var first_object = {};
				var last_object = {};
				var added_object = {};
				
				added_object[obj_key] = obj_val;
				var counter = 0;
				$.each(colection, function(index, value){
					if(counter < position){
						first_object[index] = value;
					}else{
						last_object[index] = value;
					}
					counter++	
				});

				return _.merge(first_object, added_object, last_object);

			}
		};
		/* ----------------------------------- */