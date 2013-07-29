<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile('js/rates.js');
?>

<div class="rates-controls">
	<div class="renew-rates"><input type="button" onclick="javascript: update_rates(1);" value="Обновить список валют"/></div>
	<div class="add-rates"><span>Загружаются валюты...</span></div>
	<div style="height: 40px; overflow: hidden; display: block;"></div>
</div>

<br/>

<div id="rates-content">
	<div class="rates-loading">Загрузка...</div>
</div>
