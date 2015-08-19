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
					//$( "#main_container ol" ).sortable();
					//$( "#main_container ol" ).disableSelection();
				
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
					$( this ).append('<div class="helper-object-remove">[remove]</div>')
				});
			},
			colorize_path : function(path){
				if(path == undefined){
					return false;
				};
				path.reverse();
				$("#main_container li").removeClass('alpaca_container_selected');
				$("#main_container li["+_ic_key+"='" + path[0] + "']" ).addClass('alpaca_container_selected');
			},

			/* ------------------------------------------------------ */
			/* ELEMENT PROPERTIES FORM -------------------------------*/
			render_field_options : function(_this){
				var targetPath = this.paths_helper.acctual_options_path;
				var tease_array = [
					{	
						'label':'label',
						'name':'label',
						'type':'option',
						'value':this.get_option_value(targetPath+'.label')
					},{
						'label':'placeholder',
						'name':'placeholder',
						'type':'option',
						'value':this.get_option_value(targetPath+'.placeholder')
					},{							
						'label':'helper',
						'name':'helper',
						'type':'option',
						'value':this.get_option_value(targetPath+'.helper')
					},{							
						'label':'inputType',
						'name':'inputType',
						'type':'option',
						'value':this.get_option_value(targetPath+'.inputType')
					},{							
						'label':'maskString',
						'name':'maskString',
						'type':'option',
						'value':this.get_option_value(targetPath+'.maskString')
					},{							
						'label':'size',
						'name':'size',
						'type':'option',
						'value':this.get_option_value(targetPath+'.size')
					},{							
						'label':'type',
						'name':'type',
						'type':'option',
						'value':this.get_option_value(targetPath+'.type')
					},{							
						'label':'fieldClass',
						'name':'fieldClass',
						'type':'option',
						'value':this.get_option_value(targetPath+'.fieldClass')
					}
					];
				$('.alpaca-fieldset-item-container .helper-item-details').remove();
				$('#helper-container-tpl').tmpl([{}]).appendTo(_this);
				
				$(_this).css('display','none');
				$(_this).css('opacity', 0)
				
				$('#helper-input-tpl').tmpl(tease_array).appendTo(_this.find('.helper-items-body'));
				
				$(_this).slideDown(100);
				$(_this).animate(
					{ opacity: 1 },
					{ queue: false, duration: 300 }
				);

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

			add_new_element : function( type, _enum ){
				
				var rnd = Math.floor(Math.random() * 899999) + 100000;
				var element_name = "id_" + rnd; // + "_" + this.fields_counter;
				
				/* Update json data (schema) */
				schema_path = this.paths_helper.acctual_schema_path;
				options_path = this.paths_helper.acctual_schema_path;
				
				if( this.selected_type == 'object' ){
					schema_path += '.properties.';
					options_path += '.fields.';
				}else{
					if(this.selected_type != ''){
						/* if selected textfield remove last key from path */
						var rem = schema_path.split(".");
						rem.pop();
						schema_path = rem.join(".");
						schema_path+='.';

						var rem = options_path.split(".");
						rem.pop();
						options_path = rem.join(".");
						options_path+='.';
					}
				}

				schema_path += element_name;
				options_path += element_name;

				_.deepSet(this.data, schema_path+'.type', type);
				
				if(_enum != ''){
					_.deepSet(this.data, schema_path+'.enum', _enum);
				}

				if(type == 'object'){
					_.deepSet(this.data, schema_path+'.type', type);
					_.deepSet(this.data, schema_path+'.title', "Object title");
					_.deepSet(this.data, schema_path+'.properties', false);
				}

				if(type == 'array'){
					_.deepSet(this.data, schema_path+'.type', type);
					_.deepSet(this.data, schema_path+'.items', false);
					_.deepSet(this.data, schema_path+'.items.type', 'object');
					_.deepSet(this.data, schema_path+'.items.properties', 'false');
				}
				this.fields_counter ++;
				$('#main_container').children().remove();
				this.funcrion_render_alpaca(this.data);
			},

			remove_element : function( _this ){
				/* get parent to set path on parent */
				var parent = _this.closest('li');
				this.deepDelete(this.paths_helper.acctual_schema_path, this.data);
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
				console.log('Seleced path:'+schema_path);
			},

			rename_schema_key : function( _this ){

				var new_name = _this.val();
				var old_name = _this.parents('li').attr(_ic_key);
				var colection = this.get_parents_colection(this.paths_helper.acctual_schema_path);
				
				console.log(colection);
				var position = this.get_index_by_key( colection, old_name );
				this.add_object_between_colection(colection,position,'new_object',{a:'b'});
				alert('finished here');
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
				var counter = 0;
				$.each(colection, function(index, value){
					if(counter < position){
						first_object[index] = value;
					}else{
						last_object[index] = value;
					}
					counter++	
				});

				console.log(first_object);

				console.log(last_object);


			},


			rename_schema_key2 : function( _this ){
				
				var new_name = _this.val();
				var old_name = _this.parents('li').attr(_ic_key);

				var temp_node  = _.deepGet(this.data, this.paths_helper.acctual_schema_path);
				this.deepDelete(this.paths_helper.acctual_schema_path, this.data);

				var rem = this.paths_helper.acctual_schema_path.split(".");
				rem.pop();
				var schema_path = rem.join(".");
				//schema_path += '.';
				
				_.deepSet(this.data, schema_path + '.' + new_name, temp_node);

				return new_name;
				
			}

		};
		/* ----------------------------------- */