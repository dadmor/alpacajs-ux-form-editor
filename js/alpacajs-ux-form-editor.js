		/* short nodes references */
		_fs = '.alpaca-fieldset';
		_ic = '.alpaca-fieldset-item-container';
		_ic_key = 'data-alpaca-item-container-item-key';
		_dfc = 'data-first-container';
			
		var data = {
	    /* ----------------------------------------------------------------------- */
	    	"options": {
				"fields": {}
	    	},
	    	"schema": {
				"type": "object",
				"properties": {}
			}, 
		    "view":"VIEW_WEB_DISPLAY_LIST"
		    
		};				
        /* ----------------------------------- */
		/* ALPACAJS UX EDITOR CLASS version 1.0  */
		/* author: Grzegorz Durtan (dadmor)    */
		/* license: GPL2                       */
		
		var _UXFORM = {
			/* DATA */
			path : '',
			paths_helper:{
				'keys_array' : [],
				'acctual_schema_path' : 'schema.properties.',
				'acctual_options_path' : ''
			},
			fields_counter : 0,
			/* METHODS */
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

				var element_name = "element_" + this.fields_counter;
				/* Update json data (schema) */
				path = this.paths_helper.acctual_schema_path + element_name;
				//alert(path);
				
				_.deepSet(data, path+'.type', type);
			   
			    if(_enum != ''){
			    	_.deepSet(data, path+'.enum', _enum);
			    }
			    if(type == 'object'){
			    	_.deepSet(data, path+'.type', type);
				 	_.deepSet(data, path+'.title', "Object title");
				 	_.deepSet(data, path+'.properties', false);
		    	}
		    	if(type == 'array'){
			    	_.deepSet(data, path+'.type', type);
				 	_.deepSet(data, path+'.items', false);
				}
			    this.fields_counter ++;
			    $('#main_container').children().remove();
			    funcrion_render_alpaca(data);
			},

			change_path : function(_path){
				
				this.path = _path;
			},

			create_schema_path : function(_path){
				
				var schema_path = 'schema.properties.';
				
				if(_path != '/'){

					_path = _path.split("/");
					$.each(_path, function( index, value ) {
					 	if(index > 0){
 							schema_path = schema_path + value + '.properties.';
					 	}
					});
				}else{
					//var schema_path = 'schema.properties.';
				}

				
				return schema_path;
			},

			remove_element : function( _this ){
				this.deepDelete(this.paths_helper.acctual_schema_path+_this.parent().attr(_ic_key), data);
				$('#main_container').children().remove();
			    funcrion_render_alpaca(data);

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
						$( this ).html('<div>'+$(this).attr(_ic_key)+'</div>');
					}
					$( this ).append('<div class="helper-object-remove">[remove]</div>')



				});
		
			},
			// CREARTE ALPACA PATHS METHODS
			set_form_keys_array : function(_this){
				
				
				this.paths_helper.keys_array.push(_this.attr(_ic_key))
				var find_parent = _this.parents('li');
				try {
				   find_parent[0]['localName']
				   this.set_form_keys_array(find_parent );
				}
				catch (e) {
					this.paths_helper.keys_array.reverse();
					this.set_schema_path(this.paths_helper.keys_array);
					this.set_options_path(this.paths_helper.keys_array);				
					//return this.paths_helper.keys_array;
				}

			},
			set_schema_path : function(form_keys_array){
				
				var path = 'schema.properties.'
				$.each(form_keys_array, function( index, value ) {
					if(value == undefined){
						return false;
					}
					path = path+value;
					if( _.deepGet(data, path+'.type') == 'object' ){
						path = path+'.properties.';
					}	
					if( _.deepGet(data, path+'.type') == 'array' ){
						path = path+'.items.';
					}					
				});

				this.paths_helper.acctual_schema_path = path;
				
			},
			set_options_path : function(form_keys_array){
				
				var path = 'options.fields.'
				$.each(form_keys_array, function( index, value ) {
					if(value == undefined){
						return false;
					}
					path = path+value;
					if( _.deepGet(data, path+'.type') == 'object' ){
						path = path+'.fields.';
					}	
					if( _.deepGet(data, path+'.type') == 'array' ){
						path = path+'.items.';
					}					
				});
				this.paths_helper.acctual_options_path = path;
			},
			colorize_path : function(path){
				path.reverse();
				$("#main_container li").removeClass('alpaca_container_selected');
				$("#main_container li["+_ic_key+"='" + path[0] + "']" ).addClass('alpaca_container_selected');
			},

			add_option_value : function(_this){
				
				var targetPath = this.paths_helper.acctual_options_path + '.'+$(_this).attr('name');
				_.deepSet(data, targetPath, $(_this).val());
			},

			get_option_value : function(label){
				var output = _.deepGet(data, label);
				if(output != undefined){
					return output;
				}else{
					return "";
				}
			}

			

		};
		/* ----------------------------------- */