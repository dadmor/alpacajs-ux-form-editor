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
				'acctual_options_path' : 'options.fields.'
			},
			fields_counter : 0,
			
			/* METHODS */
			funcrion_render_alpaca : function (_data){
				/* -------------------------------------- */
				this.data = _data;
				_this = this;
				/* -------------------------------------- */
				_data["postRender"] = function(control){
					_this.swith_fields_to_min_mode(control);
					_this.colorize_path(_this.paths_helper.keys_array);
				}
				$("#schema_output").text(JSON.stringify(_data['schema']));
				$("#options_output").text(JSON.stringify(_data['options']));
		    	$("#main_container").alpaca(_data);
	        },

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
				$('#helper-input-tpl').tmpl(tease_array).appendTo(_this.find('.helper-items-body'));
			},

			add_new_element : function( type, _enum ){
				
				var rnd = Math.floor(Math.random() * 899999) + 100000;
				var element_name = "element_" + rnd; // + "_" + this.fields_counter;
				
				/* Update json data (schema) */
				schema_path = this.paths_helper.acctual_schema_path + element_name;
				options_path = this.paths_helper.acctual_schema_path + element_name;
				
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
				
				console.log(this.paths_helper.acctual_schema_path);
				
				this.deepDelete(this.paths_helper.acctual_schema_path, this.data);
				//alert(target);
				$('#main_container').children().remove();
				this.funcrion_render_alpaca(this.data);

			},

			deepDelete : function(target, context) {				
				context = context || window;
				var targets = target.split('.');
				if (targets.length > 1)
					this.deepDelete(targets.slice(1).join('.'), context[targets[0]]);
				else
				delete context[target];
			},

			swith_fields_to_min_mode : function (control){
				/* reference to class instance */
				_this = this;
				$( _ic ).each(function( index ) {
					if(  $(this).children('fieldset').hasClass('alpaca-fieldset')  ){
						$( this ).find('legend').html('<span>'+$(this).attr(_ic_key)+'</span> <span> [click to add elements inside me]</span>');
					}else{
						$( this ).html('<div class="helper-object-key">'+$(this).attr(_ic_key)+'</div>');
					}
					$( this ).append('<div class="helper-object-remove">[remove]</div>')
				});
		
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
					schema_path = schema_path+value;
					options_path = options_path+value;

					if( _.deepGet(_this.data, schema_path+'.type') == 'object' ){
						schema_path = schema_path+'.properties.';
						options_path = options_path+'.fields.';
					}	
					if( _.deepGet(_this.data, schema_path+'.type') == 'array' ){
						schema_path = schema_path+'.items.properties.';
						options_path = options_path+'.fields.items.';
					}

				});
				this.paths_helper.acctual_schema_path = schema_path;
				this.paths_helper.acctual_options_path = options_path;

				//console.log()
			},



			colorize_path : function(path){
				if(path == undefined){
					return false;
				};
				path.reverse();
				$("#main_container li").removeClass('alpaca_container_selected');
				$("#main_container li["+_ic_key+"='" + path[0] + "']" ).addClass('alpaca_container_selected');
			},

			add_option_value : function(_this){
					
				//this.paths_helper.keys_array
				
				var targetPath = this.paths_helper.acctual_options_path + '.'  +$(_this).attr('name');
				
				_.deepSet(this.data, targetPath, $(_this).val());
			},

			get_option_value : function(label){
				var output = _.deepGet(this.data, label);
				if(output != undefined){
					return output;
				}else{
					return "";
				}
			}
		};
		/* ----------------------------------- */