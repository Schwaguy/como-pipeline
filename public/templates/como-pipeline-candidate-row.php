<?php
/**
 * The view for the candidate row used in the loop
 */
$columns = getCustomFields($fields = array());
$colCount = count($columns);
// Check for Children
$hasChildren = false;
$childCount = 0;
$thClass = 'single-th';
$tdClass = 'single-td';
$args = array(
	'post_parent' => $item->ID,
	'post_type' => 'candidate'
);
$children = get_children($args);
if (get_children($args)) {
	$hasChildren = true;
	$childCount = count($children);
	$thClass = 'multi-td-parent';
	$tdClass = 'multi-td-parent'; 
}
// Check for Parents<strong></strong>
$isChild = false;
if (wp_get_post_parent_id($item->ID)) {
    $isChild = true;
	$thClass = 'multi-td-child';
	$tdClass = 'multi-td-child'; 
}
$progCols = $GLOBALS['prog'];
for ($c=0;$c<$colCount;$c++) {
	
	if ($columns[$c][3] == 'title-column') {
		
		$linkStart = '';
		$linkEnd = '';
		if (isset($meta['candidate-link'][0])) {
			$linkStart = '<a href="'. $meta['candidate-link'][0] .'">';
			$linkText = ((isset($meta['candidate-link'][0])) ? $meta['candidate-link'][0] : '');
			$linkEnd = '</a>'; 
		}
		
		if ($isChild) {
			// Don't add header
		} else {
			?><th class="<?=$columns[$c][3]?> <?=$columns[$c][0]?> <?=$thClass?>" itemprop="name" scope="row" rowspan="<?=$childCount+1?>"><div class="wrap"><?=$linkStart?><?=$item->post_title?><?=$linkEnd?></div></th><?php
		}
	} elseif ($columns[$c][3] == 'progress-column') {
		
		if ($progCols == $GLOBALS['prog']) {
			?><td colspan="<?=$GLOBALS['prog']?>" class="exp-on-scroll <?=$columns[$c][3]?> <?=$tdClass?>"><div class="wrap">
	
				<?php
					$terms = (($columns[$c][3] == 'indication-column') ? get_the_terms($item->ID,'indication') : get_the_terms($item->ID,'candidate_type'));
					$term_string = join(', ', wp_list_pluck($terms, 'name'));
				?>
	
				<div class="mobile-indication"><?=$term_string?></div>
				<div class="progress-contain"><div class="progress" style="width: <?=$meta['candidate-progress'][0]?>%;"><div class="progress-bar" role="progressbar" style="background-color: <?=$meta['candidate-color'][0]?>" ><?=((isset($meta['candidate-progress-text'][0])) ? '<div class="progress-text">'. $meta['candidate-progress-text'][0] .'</div>' : '')?><?=((isset($meta['candidate-progress-text-abbrev'][0])) ? '<div class="progress-text-abbreviation">'. $meta['candidate-progress-text-abbrev'][0] .'</div>' : '')?><div class="progress-inner-bg"></div></div></div></div></div>
			<?php
		} elseif ($progCols == 0) {
			?></div></td><?php
		} else {
			// do nothing
		} 
		$progCols = $progCols-1;
		
	} elseif ($columns[$c][3] == 'image-column') {
		if (!empty($columns[$c][0])) {
			$imgID = $meta[$columns[$c][0]][0];
			$img = wp_get_attachment_image($imgID, 'pipeline-logo-image', '', array('class'=>'img-responsive img-fluid'));
		} else {
			$img = 'IMG'; 
		}
		?><td class="<?=$columns[$c][3]?> <?=$columns[$c][0]?> <?=$tdClass?>"><div class="wrap"><?=$img?></div></td><?php
	} elseif ($columns[$c][3] == 'category-column') {
		$terms = get_the_terms($item->ID,'candidate_category');
		$term_string = join(', ', wp_list_pluck($terms, 'name'));
		//print_r($terms);
		
		if (!empty($term_string)) {
			
			?><td class="<?=$columns[$c][3]?> <?=$columns[$c][0]?> <?=$tdClass?>"><div class="wrap"><?=$term_string?></div></td><?php
		} else {
			?><td></td><?php
		}
		
	} elseif ($columns[$c][3] == 'type-column') {
		$terms = get_the_terms($item->ID,'candidate_type');
		$term_string = join(', ', wp_list_pluck($terms, 'name'));
		//print_r($terms);
		
		if (!empty($term_string)) {
			
			?><td class="<?=$columns[$c][3]?> <?=$columns[$c][0]?> <?=$tdClass?>"><div class="wrap"><?=$term_string?></div></td><?php
		} else {
			?><td></td><?php
		}
		
	} elseif ($columns[$c][3] == 'indication-column') {
		$terms = get_the_terms($item->ID,'indication');
		$term_string = join(', ', wp_list_pluck($terms, 'name'));
		//print_r($terms);
		
		if (!empty($term_string)) {
			
			?><td class="<?=$columns[$c][3]?> <?=$columns[$c][0]?> <?=$tdClass?>"><div class="wrap"><?=$term_string?></div></td><?php
		} else {
			?><td></td><?php
		}
		
	} elseif ($columns[$c][3] == 'method-column') {
		$terms = get_the_terms($item->ID,'candidate_method');
		$term_string = join(', ', wp_list_pluck($terms, 'name'));
		if (!empty($term_string)) {
			
			?><td class="<?=$columns[$c][3]?> <?=$columns[$c][0]?> <?=$tdClass?>"><div class="wrap"><?=$term_string?></div></td><?php
		} else {
			?><td></td><?php
		}
	}  else {
		if (isset($meta[$columns[$c][0]][0])) {
			?><td class="<?=$columns[$c][3]?> <?=$columns[$c][0]?> <?=$tdClass?>"><div class="wrap"><?=$meta[$columns[$c][0]][0]?></div></td><?php
		} else {
			?><td></td><?php
		}
	}
}  
?>