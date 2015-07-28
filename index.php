<script type="text/javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/alpaca-core.min.js"></script>
<script type="text/javascript" src="js/lodash.js"></script>
<script type="text/javascript" src="js/lodash-deep.js"></script>
<link type="text/css" href="//code.cloudcms.com/alpaca/1.5.11/bootstrap/alpaca.min.css" rel="stylesheet"/>




<div id="main_container" style="float:left; width:70%">
	

</div>

<div id="forms-elements" style="float:right: width:25%; text-align:center">
	<a id="add_input" href="#" class="button action" style="width:200px; margin-bottom:2px">input text</a><Br/>
	<a id="add_select" href="#" class="button action" style="width:200px; margin-bottom:2px">multi choice</a><Br/>
	<a id="add_checkbox" href="#" class="button action" style="width:200px; margin-bottom:2px">single checkbox</a><Br/>
	<a id="add_object" href="#" class="button action" style="width:200px; margin-bottom:2px">container ( fieldset )</a><Br/>
	<textarea id="output"></textarea>
</div>

	

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

#output{
	
	width:100%;
	height:300px;
	display:none;
}
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

</style>

<script type="text/javascript">
			jQuery(document).ready(function($) {
alert('jestem')
				window.fieldsCounter = 0;
				window.targetPath = ['schema.properties'];
				var data = {
			    /* ----------------------------------------------------------------------- */
			    	"options": {
			    		"ajax_callback": {
		               		"dependence_three": {
		                    	"rightLabel": "Messages"
		               		},
		               	}
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

				funcrion_render_alpaca = function (data){

					data["postRender"] = function(control){
						swith_fields_to_min_mode(control);
					}
					$("#output").text(JSON.stringify(data));

			    	$("#main_container").alpaca(data);
		        }

		        funcrion_render_alpaca(data);
	            /* ----------------------------------------------------------------------- */

	            $('#add_input').click(function(){
				    add_new_element('string','');
				});

				$('#add_select').click(function(){
					add_new_element('string',['option1','option2','option3']);
				});

				$('#add_checkbox').click(function(){
					add_new_element('boolean','');
				});

				$('#add_object').click(function(){
					add_new_element('object','');
				});

				$(document).on("click", "div.helper-fieldset-tab", function(e) { 
				//$('fieldset').live('click', function(e) {
					
					//if(e.srcElement.localName == 'fieldset'){ 


						
						window.targetPath = [];
						if($(this).attr('data-first-container') != 'true'){
							objects_array(e.target);
						}else{
							window.targetPath = 'schema.properties';
						}
						e.stopPropagation();

						alert(window.targetPath);

					//}

				});
				$(document).on("click", "div.helper-object-remove", function(e) { 
				//$('.helper-object-remove').live('click', function(e) {


					
					if($(this).closest('fieldset').attr('data-first-container') != 'true'){
						window.targetPath = '';
						objects_array($(this).closest('fieldset'));
					}else{
						window.targetPath = 'schema.properties';
					}
					deepDelete(window.targetPath+'.'+$(this).closest('.alpaca-fieldset-item-container').attr('data-alpaca-item-container-item-key'), data);
					$('#main_container').children().remove();
				    funcrion_render_alpaca(data);

				});

				$(document).on("click", "div.alpaca-fieldset-item-container", function(e) { 
				//$(".alpaca-fieldset-item-container").live('click', function(e) {                 

			        //tb_show('Field options','#TB_inline?height=360&width=300&inlineId=prev');
			        var input ='<div class="helper-item-details">';
				        input += '<div style="width:19%; height:100%; position:absolute; left:0; top:0; border-right:1px solid #ccc; background-color:#fff"> ';
				        	input += '<div style="padding:5px; border-bottom:1px solid #ccc">Basic</div>';
				        	input += '<div style="padding:5px; border-bottom:1px solid #ccc">Advanced</div>';
				        	input += '<div style="padding:5px; border-bottom:1px solid #ccc">Dependency</div>';
				        	input += '<div style="padding:5px; border-bottom:1px solid #ccc">Specials</div>';
				        input += '</div>';
				        input += '<div style="width:80%; float:right">';
				       	 	input += '<label style="width:120px; line-height:30px; float:left">name</label><input type="text"><br/>';
				        	input += '<label style="width:120px; line-height:30px; float:left"">label</label><input type="text"><br/>';
				        	input += '<label style="width:120px; line-height:30px; float:left"">field subtype</label><input type="text"><br/>';
				        	input += '<label style="width:120px; line-height:30px; float:left"">placeholder</label><input type="text"><br/>';
				        	input += '<label style="width:120px; line-height:30px; float:left"">default value</label><input type="text"><br/>';
						input += '</div>';
						input += '<br style="clear:both">';
					input += '</div>';
					$('.alpaca-fieldset-item-container .helper-item-details').remove();
			        $(this).append(input);

			    });

				$(document).on("click", "div.helper-item-details", function(e) { 

				//$(".helper-item-details").live('click', function(e) {                 
			        e.stopPropagation();
			    });




				function add_new_element( type, _enum ){
					
					//path = window.targetPath + '.' + "new_" + type + "_" + window.fieldsCounter;
					path = window.targetPath + '.' + "element_" + window.fieldsCounter;

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
				    funcrion_render_alpaca(data);
				}

				var parent;
				
				function objects_array( _this ){
						
						target = $(_this).attr('data-path');
						target +=  window.targetPath;

						window.targetPath = '.' + target;

						parent = $(_this).parents('fieldset');

						if($(parent).attr('data-path') != 'schema.properties'){
							
							objects_array(parent);
						
						}else{
							
							window.targetPath = 'schema.properties'+window.targetPath
							return false;
						}					

				}

				function deepDelete(target, context) {
				  context = context || window;
				  var targets = target.split('.');
				  if (targets.length > 1)
				    deepDelete(targets.slice(1).join('.'), context[targets[0]]);
				  else
				    delete context[target];
				}

				function remove_element(path_to_element){

				}


				function swith_fields_to_min_mode(){

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
				
				}

				function swith_fields_to_normal_mode(){

					$(".alpaca-fieldset-item-container").children().css('display','block');
				
				}
			 
			});
		</script>