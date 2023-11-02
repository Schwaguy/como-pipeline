<?php
/**
 * The view for the Pipeline Tables wrap start used in the loop
 */
?><div id="<?=$args['id']?>" class="table-responsive pipeline-chart <?=$args['class']?>"><table class="table"><thead>
	
<?php
	$GLOBALS['prog'] = 0;
	$columns = getCustomFields($fields = array());
	$colCount = count($columns);
	for ($c=0;$c<$colCount;$c++) {
		$colWidth = (isset($columns[$c][4]) ? 'width="'. $columns[$c][4] .'%"' : '');
		?><th class="<?=$columns[$c][3]?> <?=$columns[$c][0]?>" scope="col" <?=$colWidth?>><div class="wrap"><div class="full"><?=$columns[$c][2]?></div><div class="abbreviation"><?=$columns[$c][5]?></div></div></th><?php
		if ($columns[$c][3] == 'progress-column') {
			$GLOBALS['prog']++;
		}
	}
?>
</thead><tbody>