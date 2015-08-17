<!-- <script type="text/javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
<script type="text/javascript" src="js/jquery.1.11.1.min.js"></script>
<script type="text/javascript" src="js/alpaca-core.min.js"></script>
<script type="text/javascript" src="js/lodash.js"></script>
<script type="text/javascript" src="js/lodash-deep.js"></script>

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

<script id="container-header-tpl" type="text/x-jquery-tmpl">
	<div class="helper-fieldset-tab" data-path="${path}">
		<div class="helpar-fieldset-tab-title">Main container</div>
	</div>
</script>

<script id="container-header-tpl-2" type="text/x-jquery-tmpl">
	<div class="helper-fieldset-tab" data-path="${path}">
	<div class="helpar-fieldset-tab-title">Main container</div>
	<div class="helpar-fieldset-tab-header-cell" >Field name</div>
	<div class="helpar-fieldset-tab-header-cell-250">Field label</div>
	<div class="helpar-fieldset-tab-header-cell">Field type</div>
	<div class="helpar-fieldset-tab-header-cell-right">remove</div>
	<br style="clear:both">
	</div>
</script>

<script type="text/javascript">
	jQuery(document).ready(function($) {

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
		    "postRender": function(control) {
				/* removed on bottom this code */
		    },"view":"VIEW_WEB_DISPLAY_LIST"
		    
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

				/* Update json data (schema) */
				path = this.paths_helper.acctual_schema_path + "element_" + this.fields_counter;
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
				
				if(_this.closest(_fs).attr(_dfc) != 'true'){
					//window.targetPath = '';
					//objects_array(_this.closest('fieldset'));
				}else{
					window.targetPath = 'schema.properties';
				}
				this.deepDelete(window.targetPath+'.'+_this.closest(_ic).attr(_ic_key), data);
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
						$( this ).find('legend').html('<span>'+$(this).attr('data-alpaca-item-container-item-key')+'</span> <span> [click to add elements inside me]</span>');
					}else{
						$( this ).html('<div>'+$(this).attr('data-alpaca-item-container-item-key')+'</div>');
					}

				});
		
			},
			// CREARTE ALPACA PATHS METHODS
			set_form_keys_array : function(_this){
				
				
				this.paths_helper.keys_array.push(_this.attr('data-alpaca-item-container-item-key'))
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

		/* ACTIONS EVENTS HANDLERS */

		$(document).on("click", "div .helper-object-remove", function(e) { 
			_UXFORM.remove_element($(this));
			//e.stopPropagation();
		});

		$(document).on("click", "li.alpaca-fieldset-item-container", function(e) { 
		//$(".alpaca-fieldset-item-container").live('click', function(e) {

			if(  $(this).children('fieldset').hasClass('alpaca-fieldset')  ){
				$(this).css('border','1px solid blue');
			}else{
				$(this).parents('li').css('border','1px solid rgb(95,148,156)');
				$(this).parents('li').css('background','rgba(95,148,156,0.1)');
			}		
			

			_UXFORM.paths_helper.keys_array = [];
			_UXFORM.set_form_keys_array( $(this) );
			//console.log(this.paths_helper.keys_array);  

			_UXFORM.render_field_options($(this));
			e.stopPropagation();
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



		/*$(document).on("click", "div.helper-fieldset-tab", function(e) { 
		//$('fieldset').live('click', function(e) {
			_UXFORM.change_path( $(this).parent().attr('data-path') );
			$('.helper-fieldset-tab').parent().removeClass('helper-selected');
			$(this).parent().addClass('helper-selected');
			e.stopPropagation();
		});*/

		$(document).on("change", "input.input-helper", function(e) { 
			if($(this).attr('data-type') == 'option'){
				_UXFORM.add_option_value($(this));
			}
			
		});

		/* INIT  */
	    funcrion_render_alpaca = function (data){

			data["postRender"] = function(control){
				_UXFORM.swith_fields_to_min_mode(control);
			}
			$("#schema_output").text(JSON.stringify(data['schema']));
			$("#options_output").text(JSON.stringify(data['options']));
	    	$("#main_container").alpaca(data);

        }

	    funcrion_render_alpaca(data);
		 
	});


</script>