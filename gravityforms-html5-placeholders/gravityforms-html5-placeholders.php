<?php
/*
Plugin Name: Gravity Forms HTML5 Placeholders
Description: Adds HTML5 placeholder support to Gravity Forms' fields with a javascript fallback. Javascript & jQuery are required.
Version: 0.1
Plugin URI: https://github.com/jstnkrr/gravityforms-html5-placeholders
Author: Justin Kerr <justin@undefined.ca>
Author URI: http://www.undefined.ca

Instructions:
Add placeholder text in the field editor.

*/


/* Add a custom field to the field editor (See editor screenshot) */
add_action("gform_field_standard_settings", "gfhp_standard_settings", 10, 2);

function gfhp_standard_settings($position, $form_id){

	// Create settings on position 25 (right after Field Label)
	if ($position == 25) {
		?>
		<li class="admin_label_setting field_setting" style="display: list-item; ">
			<label for="field_placeholder">Placeholder Text
				<a class="gf_tooltip tooltip tooltip_form_field_description" title="&lt;h6&gt;Placeholder&lt;/h6&gt;Enter the placeholder/default text for this field." onclick="return false;" href="#">
					<i class="fa fa-question-circle"></i>
				</a>
			</label>
			<input type="text" id="field_placeholder" class="fieldwidth-3" size="35" onkeyup="SetFieldProperty('placeholder', this.value);">
		</li>
	<?php
	}
}

/* Now we execute some javascript technicalitites for the field to load correctly */

add_action("gform_editor_js", "gfhp_gform_editor_js");

function gfhp_gform_editor_js(){
?>
<script>
	//binding to the load field settings event to initialize the checkbox
	jQuery(document).bind("gform_load_field_settings", function(event, field, form){
		jQuery("#field_placeholder").val(field["placeholder"]);
	});
</script>
<?php

}



/* We use jQuery to read the placeholder value and inject it to its field */

add_action('gform_register_init_scripts',"gfhp_gform_register_init_scripts", 10, 2);

function gfhp_gform_register_init_scripts($form, $is_ajax=false){

	$plugin_url = plugins_url( basename(dirname(__FILE__)) );

	$placholders = array();
	foreach($form['fields'] as $i=>$field) {
		if (isset($field['placeholder']) && !empty($field['placeholder'])) {
			$placholders["#input_{$form['id']}_{$field['id']}"] = $field['placeholder'];
		}
	}
	echo "<script>";
	echo "var jquery_placeholder_url = '" . $plugin_url . "/js/vendor/jquery.placeholder-1.0.1.js';";
	echo "var gf_placeholders = " . json_encode($placholders) . ";";
	echo "</script>";
	echo "<script src='{$plugin_url}/js/gf.placeholders.js'></script>";

}
