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
		    }
		   ,"view":"VIEW_WEB_DISPLAY_LIST"
		    
		};				
        /* ----------------------------------- */
		/* ALPACAJS UX EDITOR CLASS version 0.3  */
		/* author: Grzegorz Durtan (dadmor)    */
		/* license: GPL2                       */
		
		var _UXFORM = {
			/* DATA */
			path : '/',
			fields_counter : 0,
			/* METHODS */
		    render_field_options : function(_this){

				var targetPath = this.get_options_target_path(_this);
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
				path = this.create_schema_path(this.path) + "element_" + this.fields_counter;
				
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

				$('#container-header-tpl').tmpl([{}]).prependTo($('#main_container'));

				/* reference to class instance */
				_this = this;
				
				/* build first fieldset marker */
				$("#main_container").children(_fs).attr(_dfc,'true');

				/* add paths to all items containers */
				$( _ic ).each(function( index ) {
					var alpaca_field = control.childrenByPropertyId[$(this).attr('data-alpaca-item-container-item-key')];
					$(this).attr('data-type',alpaca_field['type']);
					$(this).attr('data-path',alpaca_field['path']);

					if(alpaca_field['type'] == 'object'){
						$('#container-header-tpl').tmpl([{}]).prependTo(this);
					}

				});

				/* add helpers to editor mode */
				/*$( _ic ).each(function( index ) {
						
						$( this ).append('<div style="position:absolute; left:5px; top:5px" class="helper-object-name">' + $(this).attr(_ic_key) + '</div>');
						$( this ).append('<div style="position:absolute; right:5px; top:5px; text-decoration:underline; color:#687A7E" class="helper-object-remove">[remove]</div>');

					if( $( this ).children().get(0).nodeName == 'FIELDSET'){
						
						$( this ).children().css('display','block');
						$( this ).find('legend').css('display','none');
						$( this ).css({"border":"0px","background":"none","box-shadow":"none"});

						
						$( this ).find('.helper-fieldset-tab').attr('data-path',$(this).attr(_ic_key)+'.properties'); 
					}
				});*/
			
			},

			add_option_value : function(_this){
				
				var targetPath = this.get_options_target_path(_this)+'.'+$(_this).attr('name');
				_.deepSet(data, targetPath, $(_this).val());
			},

			get_option_value : function(label){
				var output = _.deepGet(data, label);
				if(output != undefined){
					return output;
				}else{
					return "";
				}
			},

			get_options_target_path : function(_this){
				
				var key = _this.closest(_ic).attr(_ic_key);
				var opt_pth = window.targetPath;
				opt_pth = opt_pth.substring(7);
				opt_pth = opt_pth.replace(/properties/g, "fields");
				opt_pth = 'options.'+opt_pth+'.'+key;
				return opt_pth;
			}

		};
		/* ----------------------------------- */

		/* ACTIONS EVENTS HANDLERS */

		$(document).on("click", "div .helper-object-remove", function(e) { 
			_UXFORM.remove_element($(this));
			//e.stopPropagation();
		});

		$(document).on("click", "div.alpaca-fieldset-item-container", function(e) { 
		//$(".alpaca-fieldset-item-container").live('click', function(e) {  
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

		$(document).on("click", "div.helper-fieldset-tab", function(e) { 
		//$('fieldset').live('click', function(e) {
			_UXFORM.change_path( $(this).parent().attr('data-path') );
			$('.helper-fieldset-tab').parent().removeClass('helper-selected');
			$(this).parent().addClass('helper-selected');
			e.stopPropagation();
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
			}
			$("#schema_output").text(JSON.stringify(data['schema']));
			$("#options_output").text(JSON.stringify(data['options']));
	    	$("#main_container").alpaca(data);

        }

	    funcrion_render_alpaca(data);
		 
	});


</script>