<?php

	$labels = Rate::model()->attributeLabels();
	if (isset($rates)) {
		$isRemovable = (count($rates) > 1);
?>
	
	<div class="rates">
		<div class="rate rate-headers">
			<div class="name"><?php echo CHtml::label($labels['name'], ''); ?></div>
			<div class="char-code"><?php echo CHtml::label($labels['char_code'], ''); ?></div>
			<div class="nominal"><?php echo CHtml::label($labels['nominal'], ''); ?></div>
			<div class="value"><?php echo CHtml::label($labels['value'], ''); ?></div>
		</div>
		<?php foreach($rates as $rate) { 
			if (!$rate instanceof Rate)
			{
				continue;
			}

			?>

			<div class="rate">
				<div class="name"><?php      echo $rate->name; ?></div>
				<div class="char-code"><?php echo $rate->char_code; ?></div>
				<div class="nominal"><?php   echo $rate->nominal; ?></div>
				<div class="value"><?php     echo $rate->value; ?></div>
				<div class="control">
					<?php if ($isRemovable) { ?>
						<a href="javascript: remove_from_selected('<?php echo $rate->char_code; ?>');">убрать из списка</a>
					<?php } ?>
				</div>
			</div>

		<?php } ?>
	</div>

<?php } else { ?>

	<div class="no-rates">No rates selected</div>

<?php }	?>
