<?php // Here placed some dynamic variables used in javascripts ?>
<script type="text/javascript">
	window.URL_GET_RATES_AJAX       = '<?php echo $this->createUrl('/site/getRatesAjax'); ?>';
	window.URL_UPDATE_RATES_AJAX    = '<?php echo $this->createUrl('/site/updateRatesAjax'); ?>';
	window.URL_SET_SELECTED_AJAX    = '<?php echo $this->createUrl('/site/setRateSelected'); ?>';
</script>
