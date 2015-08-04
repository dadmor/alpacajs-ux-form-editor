<!-- <script type="text/javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
<script type="text/javascript" src="js/jquery.1.11.1.min.js"></script>
<script type="text/javascript" src="js/alpaca-core.min.js"></script>
<script type="text/javascript" src="js/lodash.js"></script>
<script type="text/javascript" src="js/lodash-deep.js"></script>
<link type="text/css" href="js/alpaca-min.css" rel="stylesheet"/>

<body>

<h1>Form creator</h1>


<div id="main_container" style="float:left; width:70%">
	

</div>

<div id="forms-elements" style="float:right: width:25%; text-align:center">
	<a id="add_input" href="#" class="button action" style="width:200px; margin-bottom:2px">input text</a><Br/>
	<a id="add_select" href="#" class="button action" style="width:200px; margin-bottom:2px">multi choice</a><Br/>
	<a id="add_checkbox" href="#" class="button action" style="width:200px; margin-bottom:2px">single checkbox</a><Br/>
	<a id="add_object" href="#" class="button action" style="width:200px; margin-bottom:2px">container ( fieldset )</a><Br/>
</div>
<br style="clear:both"/>
<h2>Form schema and options output</h2>
<table style="width:100%">
	<tr>
		<td>Schema<textarea id="schema_output"></textarea></td>
		<td>Options<textarea id="options_output"></textarea></td>
	</tr>
</table>	

</body>

<style>
/* normalize - delete this section if you wand add editor into WordPress plugins*/
#main_container{
	font-family: arial;
	font-size:13px;
}
#main_container fieldset{
	border:0;
}
#main_container .helper-fieldset-tab{

}
input[type="text"] {
  display: block;
  margin: 0;
  width: 100%;
  font-family: sans-serif;
  font-size: 14px;
  appearance: none;
  box-shadow: none;
  border-radius: none;

  padding: 5px;
  border: solid 1px #dcdcdc;
  transition: box-shadow 0.3s, border 0.3s;
}
input[type="text"]:focus {
  outline: none;
}

#schema_output, #options_output{
	
	width:100%;
	height:300px;
	border:1px solid #ccc;
	font-size:11px;

}
/* ------------------------------------------------------------ */
/* extra standalone */
.helper-item-details select{
	border: 1px solid #dcdcdc;
	background-color: #fff;
	padding: 3px 1px;
	font-size: 14px;
	width: 100%;
}
body{font-family:arial;}

/* ------------------------------------------------------------ */
.alpaca-fieldset-item-container{
	position:relative;
	border:1px solid #B3B3B3; 
	padding: 5px 0px 5px 5px; 
	background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAMElEQVQIW2N89+7df0FBQYb3798zwADjfyBAFgBJMIJUwpUAGSBdKIIwY+CCyOYCAOqoHyYVqHz5AAAAAElFTkSuQmCC) repeat;
	box-shadow: inset 1px 1px 0 rgba(255, 255, 255, 0.8);

	margin-bottom:2px;
	min-height:20px;
	border-radius: 2px;
}
.alpaca-fieldset-item-container:hover{
	background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAMElEQVQIW2Pcc/vBf2cVeYa9dx4ywADjfyBAFgBJMIJUwpUAGSBdKIIwY+CCyOYCAJr8HdrUl9gSAAAAAElFTkSuQmCC) repeat;
	cursor:pointer;
}

fieldset{

	margin: 5px 0px 5px 5px; 
	padding: 5px 0px 5px 5px; 
}


.alpaca-fieldset-item-container span{
	display:none;
}
.helper-object-name{
	color:#444;
	text-shadow:1px 1px 1px #FFFFFF;
}
.alpaca-fieldset-helper{
	display:none;
	}
.helper-fieldset-tab{
	border-radius: 3px 3px 0px 0px;
	border-left:1px solid #bbb;
	border-right:1px solid #bbb;
	border-top:1px solid #bbb;
	border-bottom:1px solid #fff;
	padding:3px;
	background-color: #F7F7F7;
}
.helpar-fieldset-tab-title{
	font-size:16px;
	margin:5px;
}
.helpar-fieldset-tab-header-cell{
	float:left; font-size:11px; width:120px; margin:5px;
}
.helpar-fieldset-tab-header-cell-250{
	float:left; font-size:11px; width:250px; margin:5px
}
.helpar-fieldset-tab-header-cell-right{
	float:right; font-size:11px; width:60px; margin:5px
}

.helper-item-details{
	/* background-color: #F7F7F7; */
	background-color: rgba(255,255,255,0.5);
	margin-top:26px;
	padding:10px;
	margin-left:-5px;
	position:relative;
}
.helper-item-details .context-mnu{
	width:19%; height:100%; position:absolute; left:0; top:0; border-right:1px solid #ccc; background-color:#fff
}
.helper-item-details .context-mnu-item{
	padding:5px; border-bottom:1px solid #ccc
}

.helper-item-details .label{
	width:120px; line-height:30px; float:left
}

</style>

<script type="text/javascript">
			jQuery(document).ready(function($) {
				
				window.fieldsCounter = 0;
				window.targetPath = ['schema.properties'];
				var data = {
			    /* ----------------------------------------------------------------------- */
			    	"options": {
						"fields": {}
			    	},
			    	"schema": {
				      //"title": "Form extended options",
				      //"description": "Define your special display properties",
				      "type": "object",
				      "properties": {	        
				        "ajax_callback": {
							"type": "string",
							"title": "callback AJAX function name",
							"description": "name of java script callback function. You couuld add any functions to your scripts like name=function(response);",
							"default": "add_event_callback",
				        },
				        "ajax_callback1": {
							"type": "string",
							"title": "callback AJAX function name",
							"description": "name of java script callback function. You couuld add any functions to your scripts like name=function(response);",
							"default": "add_event_callback",
				        },
				        
				      }
				    }
				}

				
	            /* ----------------------------------------------------------------------- */

	           

			window._parent;				
			var _UXFORM = {
			    open_field_options : function(_this){
			    	//console.log('%c -- open_field_options ------', 'background: #222; color: #bada55');               
			        //tb_show('Field options','#TB_inline?height=360&width=300&inlineId=prev');
			        var input ='<div class="helper-item-details">';
				        input += '<div class="context-mnu"> ';
				        	input += '<div class="context-mnu-item">Basic</div>';
				        	input += '<div class="context-mnu-item">Advanced</div>';
				        	input += '<div class="context-mnu-item">Dependency</div>';
				        	input += '<div class="context-mnu-item">Specials</div>';
				        input += '</div>';
				        input += '<div style="width:80%; float:right">';
				        	
				        	input += '<label class="label">type</label>';
				        	input += '<select><option>Array</option><option>Checkbox</option><option>File</option><option>Hidden</option></select><br/>';
				       	 	
				       	 	input += '<label class="label">name</label>';
				       	 	input += '<input class="input-helper" type="text" name="name" data-type="shema-key">';
				        	
				        	input += '<label class="label">label</label>';
				        	input += '<input class="input-helper" type="text" name="label" data-type="option">';
				        	
				        	input += '<label class="label">placeholder</label>';
				        	input += '<input class="input-helper" type="text" name="placeholder" data-type="option">';
				        	
				        	input += '<label class="label">default value</label><input type="text">';
						input += '</div>';
						input += '<br style="clear:both">';
					input += '</div>';
					$('.alpaca-fieldset-item-container .helper-item-details').remove();
			        _this.append(input);

			    },

				add_new_element : function( type, _enum ){
					//console.log('%c -- add_new_element ----------', 'background: #222; color: #bada55');
					//path = window.targetPath + '.' + "new_" + type + "_" + window.fieldsCounter;
					path = window.targetPath + '.' + "element_" + window.fieldsCounter;
					//console.log('%c path:'+path, 'background: #ccc; color: blue');

					_.deepSet(data, path+'.type', type);
					_.deepSet(data, path+'.title', "New element");
					_.deepSet(data, path+'.description', "example description");

				    if(_enum != ''){
				    	_.deepSet(data, path+'.enum', _enum);
				    }

				    if(type == 'object'){
				    	_.deepSet(data, path+'.type', type);
					 	_.deepSet(data, path+'.title', "Object title");
					 	_.deepSet(data, path+'.properties', false);
			    	}

				    window.fieldsCounter ++;
				    
				    $('#main_container').children().remove();

				    //console.log(data);
				    funcrion_render_alpaca(data);
				},
				change_path_deep : function(_this){

					window.targetPath = [];
					if( _this.parent('fieldset').attr('data-first-container') != 'true'){
						this.objects_array(_this);
					}else{
						window.targetPath = 'schema.properties';
					}
				},

				remove_element : function( _this ){
					
					if(_this.closest('fieldset').attr('data-first-container') != 'true'){
						//window.targetPath = '';
						//objects_array(_this.closest('fieldset'));
					}else{
						window.targetPath = 'schema.properties';
					}
					this.deepDelete(window.targetPath+'.'+_this.closest('.alpaca-fieldset-item-container').attr('data-alpaca-item-container-item-key'), data);
					$('#main_container').children().remove();
				    funcrion_render_alpaca(data);

				},

				objects_array : function( _this ){
					
					target = _this.attr('data-path');
					target +=  window.targetPath;
					window.targetPath = '.' + target;
					window._parent = _this.parent('fieldset').parents('fieldset').children('.helper-fieldset-tab');

					if(window._parent.attr('data-path') != 'schema.properties'){
						this.objects_array(window._parent);
					}else{
						window.targetPath = 'schema.properties'+window.targetPath
						return false;
					}
				},

				deepDelete : function(target, context) {
				  context = context || window;
				  var targets = target.split('.');
				  if (targets.length > 1)
				    this.deepDelete(targets.slice(1).join('.'), context[targets[0]]);
				  else
				    delete context[target];
				},

				deepADD : function(target, context) {
				  context = context || window;
				  var targets = target.split('.');
				  if (targets.length > 1)
				    this.deepDelete(targets.slice(1).join('.'), context[targets[0]]);
				  else
				    delete context[target];
				},

				swith_fields_to_min_mode : function (){

					/* build first fieldset */
					$("#main_container").children('fieldset').attr('data-first-container','true');

					/* Add fieldsef tab */
					var input = '';
					input +='<div class="helper-fieldset-tab" data-path="schema.properties">';
					input +='<div class="helpar-fieldset-tab-title">Main container</div>';
					input +='<div class="helpar-fieldset-tab-header-cell" >Field name</div>';
					input +='<div class="helpar-fieldset-tab-header-cell-250">Field label</div>';
					input +='<div class="helpar-fieldset-tab-header-cell">Field type</div>';
					input +='<div class="helpar-fieldset-tab-header-cell-right">remove</div>';
					input +='<br style="clear:both">';
					input +='</div>';
					input +='';
					input +='';
					$("fieldset").prepend(input);
				
					
					/* add helpers to editor mode */
					$( ".alpaca-fieldset-item-container" ).each(function( index ) {
  						
  						$( this ).append('<div style="position:absolute; left:5px; top:5px" class="helper-object-name">' + $(this).attr('data-alpaca-item-container-item-key') + '</div>');
  						$( this ).append('<div style="position:absolute; right:5px; top:5px" class="helper-object-remove">[remove]</div>');

						if( $( this ).children().get(0).nodeName == 'FIELDSET'){
							
							$( this ).children().css('display','block');
							$( this ).find('legend').css('display','none');
							$( this ).css({"border":"0px","background":"none","box-shadow":"none"});

							/* add path marker */
							$( this ).find('.helper-fieldset-tab').attr('data-path',$(this).attr('data-alpaca-item-container-item-key')+'.properties'); 
						}
					});
				
				},

				add_option : function(){
					alert(window.targetPath)
				}

			};



			/* ACTIONS EVENTS HANDLERS */

			$(document).on("click", "div .helper-object-remove", function(e) { 
				_UXFORM.remove_element($(this));
				//e.stopPropagation();
			});

			$(document).on("click", "div.alpaca-fieldset-item-container", function(e) { 
			//$(".alpaca-fieldset-item-container").live('click', function(e) {  
				_UXFORM.open_field_options($(this));
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
				_UXFORM.add_new_element('boolean','');
			});

			$('#add_object').click(function(){
				_UXFORM.add_new_element('object','');
			});

			$(document).on("click", "div.helper-fieldset-tab", function(e) { 
			//$('fieldset').live('click', function(e) {
				_UXFORM.change_path_deep($(this));
				e.stopPropagation();
			});

			$(document).on("change", "input.input-helper", function(e) { 
				console.log(data);
				console.log(window.targetPath);
				console.log($(this).val());
				console.log($(this).attr('name'));
				_UXFORM.add_option();
			});

			/* INIT  */
		    funcrion_render_alpaca = function (data){

				data["postRender"] = function(control){
					_UXFORM.swith_fields_to_min_mode(control);
				}
				$("#schema_output").text(JSON.stringify(data.schema));
				$("#options_output").text(JSON.stringify(data.options));
		    	
		    	$("#main_container").alpaca(data);
	        }

		    funcrion_render_alpaca(data);
			 
		});
		</script>