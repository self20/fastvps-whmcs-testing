<?php // Here placed some dynamic variables used in javascripts ?>
<script type="text/javascript">
	window.URL_RATES_AJAX = '<?php echo $this->createUrl('/site/updateRatesAjax'); ?>';
	window.URL_ADD_TO_SELECTED = '<?php echo $this->createUrl('/site/addRateAjax'); ?>';
	window.URL_REMOVE_FROM_SELECTED = '<?php echo $this->createUrl('/site/removeRateAjax'); ?>';
</script>
