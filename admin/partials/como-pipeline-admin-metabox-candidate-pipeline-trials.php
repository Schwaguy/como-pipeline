<div class="pipeline-details">
<?php
/**
 * Provide the view for a metabox
 *
 * @link 		http://slushman.com
 * @since 		1.0.0
 *
 * @package 	Como_Pipeline
 * @subpackage 	Como_Pipeline/admin/partials
 */
wp_nonce_field( $this->plugin_name, 'candidate_pipeline_trials' );
$setatts 					= array();
$setatts['class'] 			= 'repeater';
$setatts['id'] 				= 'candidate-trials';
$setatts['label-add'] 		= 'Add Trial';
$setatts['label-edit'] 		= 'Edit Trial'; 
$setatts['label-header'] 	= 'Trial Name';
$setatts['label-remove'] 	= 'Remove Trial';
$setatts['title-field'] 	= 'trial-name'; // which field provides the title for each fieldset?
$setatts['columns'] 		= 3;
$i 							= 0;
	
//Trial Title	
$setatts['fields'][$i]['text']['class'] 				= 'widefat trial-name repeater-title';
$setatts['fields'][$i]['text']['description'] 			= '';
$setatts['fields'][$i]['text']['id'] 					= 'trial-name';
$setatts['fields'][$i]['text']['label'] 				= 'Name';
$setatts['fields'][$i]['text']['name'] 					= 'trial-name';
$setatts['fields'][$i]['text']['placeholder'] 			= 'Trial Name';
$setatts['fields'][$i]['text']['type'] 					= 'text';
$setatts['fields'][$i]['text']['value'] 				= '';
$i++;
	
// Trial Abbreviation	
$setatts['fields'][$i]['text']['class'] 				= 'widefat trial-abbreviation';
$setatts['fields'][$i]['text']['description'] 			= 'For smaller screens';
$setatts['fields'][$i]['text']['id'] 					= 'trial-abbreviation';
$setatts['fields'][$i]['text']['label'] 				= 'Abbreviation';
$setatts['fields'][$i]['text']['name'] 					= 'trial-abbreviation';
$setatts['fields'][$i]['text']['placeholder'] 			= 'Trial Abbreviation';
$setatts['fields'][$i]['text']['type'] 					= 'text';
$setatts['fields'][$i]['text']['value'] 				= '';
$i++;	
	
// Trial Progress
$setatts['fields'][$i]['number']['class'] 				= 'trial-progress';
$setatts['fields'][$i]['number']['description'] 		= 'Percentage of Development Process Completed';
$setatts['fields'][$i]['number']['id'] 					= 'trial-progress';
$setatts['fields'][$i]['number']['label'] 				= 'Progress';
$setatts['fields'][$i]['number']['name'] 				= 'trial-progress';
$setatts['fields'][$i]['number']['placeholder'] 		= '';
$setatts['fields'][$i]['number']['type'] 				= 'number';
$setatts['fields'][$i]['number']['value'] 				= '';
$setatts['fields'][$i]['number']['min'] 				= '0';
$setatts['fields'][$i]['number']['max'] 				= '100';
$setatts['fields'][$i]['number']['step'] 				= '0.01';	
$i++;	
	
// Trial Class	
$setatts['fields'][$i]['text']['class'] 				= 'widefat trial-class';
$setatts['fields'][$i]['text']['description'] 			= '';
$setatts['fields'][$i]['text']['id'] 					= 'trial-class';
$setatts['fields'][$i]['text']['label'] 				= 'Class';
$setatts['fields'][$i]['text']['name'] 					= 'trial-class';
$setatts['fields'][$i]['text']['placeholder'] 			= 'Trial Class';
$setatts['fields'][$i]['text']['type'] 					= 'text';
$setatts['fields'][$i]['text']['value'] 				= '';
$i++;
	
// Trial Progress Text	
$setatts['fields'][$i]['text']['class'] 				= 'widefat trial-class';
$setatts['fields'][$i]['text']['description'] 			= '';
$setatts['fields'][$i]['text']['id'] 					= 'trial-progress-text';
$setatts['fields'][$i]['text']['label'] 				= 'Progress Text';
$setatts['fields'][$i]['text']['name'] 					= 'trial-progress-text';
$setatts['fields'][$i]['text']['placeholder'] 			= 'Progress Text';
$setatts['fields'][$i]['text']['type'] 					= 'text';
$setatts['fields'][$i]['text']['value'] 				= '';
$i++;	
	
// Trial Progress Text Appreviation
$setatts['fields'][$i]['text']['class'] 				= 'widefat trial-class';
$setatts['fields'][$i]['text']['description'] 			= '';
$setatts['fields'][$i]['text']['id'] 					= 'trial-progress-text-abbreviation';
$setatts['fields'][$i]['text']['label'] 				= 'Progress Text Abbreviation';
$setatts['fields'][$i]['text']['name'] 					= 'trial-progress-text-abbreviation';
$setatts['fields'][$i]['text']['placeholder'] 			= 'Progress Text Abbreviation';
$setatts['fields'][$i]['text']['type'] 					= 'text';
$setatts['fields'][$i]['text']['value'] 				= '';
$i++;		
	
// Trial Link	
$setatts['fields'][$i]['text']['class'] 				= 'widefat trial-link';
$setatts['fields'][$i]['text']['description'] 			= '';
$setatts['fields'][$i]['text']['id'] 					= 'trial-link';
$setatts['fields'][$i]['text']['label'] 				= 'Link';
$setatts['fields'][$i]['text']['name'] 					= 'trial-link';
$setatts['fields'][$i]['text']['placeholder'] 			= 'Trial Link';
$setatts['fields'][$i]['text']['type'] 					= 'text';
$setatts['fields'][$i]['text']['value'] 				= '';
$i++;
	
// Trial Link Text	
$setatts['fields'][$i]['text']['class'] 				= 'widefat trial-link-text';
$setatts['fields'][$i]['text']['description'] 			= '';
$setatts['fields'][$i]['text']['id'] 					= 'trial-link-text';
$setatts['fields'][$i]['text']['label'] 				= 'Link Text';
$setatts['fields'][$i]['text']['name'] 					= 'trial-link-text';
$setatts['fields'][$i]['text']['placeholder'] 			= 'Trial Link Text';
$setatts['fields'][$i]['text']['type'] 					= 'text';
$setatts['fields'][$i]['text']['value'] 				= '';
$i++;	
	
// Trial Color	
$setatts['fields'][$i]['text']['class'] 				= 'widefat trial-color colorpicker';
$setatts['fields'][$i]['text']['description'] 			= '';
$setatts['fields'][$i]['text']['id'] 					= 'trial-color';
$setatts['fields'][$i]['text']['label'] 				= 'Color';
$setatts['fields'][$i]['text']['name'] 					= 'trial-color';
$setatts['fields'][$i]['text']['placeholder'] 			= '';
$setatts['fields'][$i]['text']['type'] 					= 'text';
$setatts['fields'][$i]['text']['value'] 				= '';
$i++;	
	
/*	
// Trial Indication Text	
$setatts['fields'][$i]['text']['class'] 				= 'widefat trial-indication';
$setatts['fields'][$i]['text']['description'] 			= '';
$setatts['fields'][$i]['text']['id'] 					= 'trial-indication';
$setatts['fields'][$i]['text']['label'] 				= 'Indication';
$setatts['fields'][$i]['text']['name'] 					= 'trial-indication';
$setatts['fields'][$i]['text']['placeholder'] 			= 'Trial Indication';
$setatts['fields'][$i]['text']['type'] 					= 'text';
$setatts['fields'][$i]['text']['value'] 				= '';
$i++;
*/
	
// Trial Category Select	
$trialCategories = get_terms(array('taxonomy'=>'candidate_category', 'hide_empty'=>false));
$trialCategories = ((is_array($trialCategories)) ? $trialCategories : array());
$trialCatArray = array();
foreach ($trialCategories as $cat) {
	$trialCatArray[] = array('label'=>$cat->name, 'value'=>$cat->term_id); 
}
$setatts['fields'][$i]['select']['aria'] 				= '';
$setatts['fields'][$i]['select']['blank'] 				= '-- select --';
$setatts['fields'][$i]['select']['context'] 			= '';
$setatts['fields'][$i]['select']['class'] 				= 'widefat trial-category';
$setatts['fields'][$i]['select']['description'] 		= '';
$setatts['fields'][$i]['select']['id'] 					= 'trial-category';
$setatts['fields'][$i]['select']['label'] 				= 'Category';
$setatts['fields'][$i]['select']['name'] 				= 'trial-category';
$setatts['fields'][$i]['select']['placeholder'] 		= 'Trial Category';
$setatts['fields'][$i]['select']['type'] 				= 'select';
$setatts['fields'][$i]['select']['selections'] 			= $trialCatArray;
$setatts['fields'][$i]['select']['value'] 				= '';
$i++;
	
// Trial Indication Select	
$trialIndications = get_terms(array('taxonomy'=>'indication', 'hide_empty'=>false));
$trialIndications = ((is_array($trialIndications)) ? $trialIndications : array());
$trialIndArray = array();
foreach ($trialIndications as $ind) {
	$trialIndArray[] = array('label'=>$ind->name, 'value'=>$ind->term_id); 
}
$setatts['fields'][$i]['select']['aria'] 				= '';
$setatts['fields'][$i]['select']['blank'] 				= '-- select --';
$setatts['fields'][$i]['select']['context'] 			= '';
$setatts['fields'][$i]['select']['class'] 				= 'widefat trial-indication';
$setatts['fields'][$i]['select']['description'] 		= '';
$setatts['fields'][$i]['select']['id'] 					= 'trial-indication';
$setatts['fields'][$i]['select']['label'] 				= 'Indication';
$setatts['fields'][$i]['select']['name'] 				= 'trial-indication';
$setatts['fields'][$i]['select']['placeholder'] 		= 'Trial Indication';
$setatts['fields'][$i]['select']['type'] 				= 'select';
$setatts['fields'][$i]['select']['selections'] 			= $trialIndArray;
$setatts['fields'][$i]['select']['value'] 				= '';
$i++;
	
// Trial Type Select	
$trialTypes = get_terms(array('taxonomy'=>'candidate_type', 'hide_empty'=>false));
$trialTypes = ((is_array($trialTypes)) ? $trialTypes : array());
$trialTypeArray = array();
foreach ($trialTypes as $type) {
	$trialTypeArray[] = array('label'=>$type->name, 'value'=>$type->term_id); 
}
$setatts['fields'][$i]['select']['aria'] 				= '';
$setatts['fields'][$i]['select']['blank'] 				= '-- select --';
$setatts['fields'][$i]['select']['context'] 			= '';
$setatts['fields'][$i]['select']['class'] 				= 'widefat trial-type';
$setatts['fields'][$i]['select']['description'] 		= '';
$setatts['fields'][$i]['select']['id'] 					= 'trial-type';
$setatts['fields'][$i]['select']['label'] 				= 'Type';
$setatts['fields'][$i]['select']['name'] 				= 'trial-type';
$setatts['fields'][$i]['select']['placeholder'] 		= 'Trial Type';
$setatts['fields'][$i]['select']['type'] 				= 'select';
$setatts['fields'][$i]['select']['selections'] 			= $trialTypeArray;
$setatts['fields'][$i]['select']['value'] 				= '';
$i++;	
// Trial method Select	
$trialMethods = get_terms(array('taxonomy'=>'candidate_method', 'hide_empty'=>false));
$trialMethods = ((is_array($trialMethods)) ? $trialMethods : array());
$trialMethodArray = array();
foreach ($trialMethods as $meth) {
	$trialMethodArray[] = array('label'=>$meth->name, 'value'=>$meth->term_id); 
}
$setatts['fields'][$i]['select']['aria'] 				= '';
$setatts['fields'][$i]['select']['blank'] 				= '-- select --';
$setatts['fields'][$i]['select']['context'] 			= '';
$setatts['fields'][$i]['select']['class'] 				= 'widefat trial-method';
$setatts['fields'][$i]['select']['description'] 		= '';
$setatts['fields'][$i]['select']['id'] 					= 'trial-method';
$setatts['fields'][$i]['select']['label'] 				= 'Method';
$setatts['fields'][$i]['select']['name'] 				= 'trial-method';
$setatts['fields'][$i]['select']['placeholder'] 		= 'Trial Method';
$setatts['fields'][$i]['select']['type'] 				= 'select';
$setatts['fields'][$i]['select']['selections'] 			= $trialMethodArray;
$setatts['fields'][$i]['select']['value'] 				= '';
$i++;
	
// Trial Logo	
$setatts['fields'][$i]['text']['class'] 				= 'widefat url-file trial-logo';
$setatts['fields'][$i]['text']['id'] 					= 'trial-logo';
$setatts['fields'][$i]['text']['label'] 				= 'Trial Logo';
$setatts['fields'][$i]['text']['label-add'] 			= 'Add Image';
$setatts['fields'][$i]['text']['label-edit'] 			= 'Edit Image';
$setatts['fields'][$i]['text']['label-header'] 			= 'Image Name';
$setatts['fields'][$i]['text']['label-remove'] 			= 'Remove Image';
$setatts['fields'][$i]['text']['label-upload'] 			= 'Choose/Upload Image';
$setatts['fields'][$i]['text']['name'] 					= 'trial-logo';
$setatts['fields'][$i]['text']['placeholder'] 			= 'Trial Logo';
$setatts['fields'][$i]['text']['type'] 					= 'hidden';
$setatts['fields'][$i]['text']['value'] 				= '';
	
// Trial Textarea	
$setatts['fields'][$i]['textarea']['class'] 				= 'widefat trial-textarea';
$setatts['fields'][$i]['textarea']['description'] 			= '';
$setatts['fields'][$i]['textarea']['id'] 					= 'trial-textarea';
$setatts['fields'][$i]['textarea']['label'] 				= 'Trial Textarea';
$setatts['fields'][$i]['textarea']['name'] 					= 'trial-textarea';
$setatts['fields'][$i]['textarea']['placeholder'] 			= 'may be used for additional information';
$setatts['fields'][$i]['textarea']['type'] 					= 'textarea';
$setatts['fields'][$i]['textarea']['rows'] 					= 4;
$setatts['fields'][$i]['textarea']['cols'] 					= 50;
$setatts['fields'][$i]['textarea']['value'] 				= '';
$i++;	
	

	
?>	
<div class="row">
<?php
	$options = get_option('como-pipeline-options');
	$columns = $options['pipeline-columns'];
	$ignoreArray = array('title-column','progress-column','type-column','indication-column','readonly-column');
	foreach ($columns as $column) {
		if (!in_array($column['column-type'], $ignoreArray)) {
		?><div class="col-12 col-md-6"><?php
			if ($column['column-type'] == 'image-column') {
				$setatts['fields'][$i]['text']['class'] 				= 'widefat url-file image-col';
				//$setatts['fields'][$i]['text']['description'] 			= '';
				//$setatts['fields'][$i]['text']['id'] 					= 'trial-'. $column['column-id'] .'-'. $i;
				$setatts['fields'][$i]['text']['id'] 					= 'trial-'. $column['column-id'];
				$setatts['fields'][$i]['text']['label'] 				= $column['column-name'];
				$setatts['fields'][$i]['text']['label-add'] 			= 'Add Image';
				$setatts['fields'][$i]['text']['label-edit'] 			= 'Edit Image';
				$setatts['fields'][$i]['text']['label-header'] 			= 'Image Name';
				$setatts['fields'][$i]['text']['label-remove'] 			= 'Remove Image';
				$setatts['fields'][$i]['text']['label-upload'] 			= 'Choose/Upload Image';
				$setatts['fields'][$i]['text']['name'] 					= 'trial-'. $column['column-id'];
				$setatts['fields'][$i]['text']['placeholder'] 			= $column['column-name'];
				$setatts['fields'][$i]['text']['type'] 					= 'hidden';
				$setatts['fields'][$i]['text']['value'] 				= '';
			} elseif ($column['column-type'] == 'textarea-column') {
				$setatts['fields'][$i]['text']['class'] 				= 'widefat';
				$setatts['fields'][$i]['text']['description'] 			= '';
				$setatts['fields'][$i]['text']['id'] 					= 'trial-'. $column['column-id'];
				$setatts['fields'][$i]['text']['label'] 				= $column['column-name'];
				$setatts['fields'][$i]['text']['name'] 					= 'trial-'. $column['column-id'];
				$setatts['fields'][$i]['text']['placeholder'] 			= $column['column-name'];
				$setatts['fields'][$i]['text']['type'] 					= 'textarea';
				$setatts['fields'][$i]['text']['cols'] 					= 50;
				$setatts['fields'][$i]['text']['rows'] 					= 5;
				$setatts['fields'][$i]['text']['value'] 				= '';
			} else {
				$setatts['fields'][$i]['text']['class'] 				= 'widefat';
				$setatts['fields'][$i]['text']['description'] 			= '';
				$setatts['fields'][$i]['text']['id'] 					= 'trial-'. $column['column-id'];
				$setatts['fields'][$i]['text']['label'] 				= $column['column-name'];
				$setatts['fields'][$i]['text']['name'] 					= 'trial-'. $column['column-id'];
				$setatts['fields'][$i]['text']['placeholder'] 			= $column['column-name'];
				$setatts['fields'][$i]['text']['type'] 					= 'text';
				$setatts['fields'][$i]['text']['value'] 				= '';
			}
			$i++;
			?></div><?php
		}
	}
	//$i++;
	//echo '<p><strong>FIELDS: </strong>'. print_r($setatts['fields']) .'<br>- ------- --</p>';
?>
</div>	
<?php	
	
	
apply_filters( $this->plugin_name . '-field-candidate-pipeline-trials', $setatts );
$count 		= 1;
$repeater 	= array();
if ( ! empty( $this->meta[$setatts['id']] ) ) {
	$repeater = maybe_unserialize( $this->meta[$setatts['id']][0] );
}
if ( ! empty( $repeater ) ) {
	$count = count( $repeater );
}
//echo 'COUNT: '. $count .'<br>';
//print_r($setatts);
include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-repeater.php' );
?>
</div>