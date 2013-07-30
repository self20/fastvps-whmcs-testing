<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
$labels = Rate::model()->attributeLabels();

Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerCssFile(
	Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css'
);
Yii::app()->clientScript->registerScriptFile('js/rates.js');
?>

<script type="text/javascript">
	$(function () {
		$('#rates-list').dialog({
			autoOpen: false,
			modal: true,
		});
	});
</script>

<div class="rates-controls">
	<div class="add-rates">
		<button onclick="javascript: $('#rates-list').dialog('open');">Изменить список валют...</button>
	</div>
</div>


<div id="rates-content">
	<div class="rates-loading">Загрузка...</div>
	<div style="height: 40px; overflow: hidden; display: block;"></div>
	<div class="rates">
		<div class="rate rate-headers">
			<div class="nominal"><?php echo CHtml::label($labels['nominal'], ''); ?>&nbsp;</div>
			<div class="name"><?php echo CHtml::label($labels['name'], ''); ?></div>
			<div class="char-code"><?php echo CHtml::label($labels['char_code'], ''); ?></div>
			<div class="value"><?php echo CHtml::label($labels['value'], ''); ?></div>
			<div class="control"><button onclick="javascript: update_rates();">Обновить все</button></div>
		</div>
		<div style="height: 1px; overflow: hidden; display: block;"></div>
	</div>
</div>

<div id="rates-list" title="Отметьте валюты для отображения в списке">
</div>
