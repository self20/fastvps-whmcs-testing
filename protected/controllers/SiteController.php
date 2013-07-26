<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$rates = SelectedRate::model()->findAll();
		$this->render('index', array(
			'rates' => CHtml::listData($rates, 'id', 'rate'),
		));
	}

	/**
	 * actionUpdateRatesAjax 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionUpdateRatesAjax($renew=NULL)
	{
		$json = array(
			'success' => false,
		);

		$criteria = new CDbCriteria();
		$criteria->addCondition('`date` > :date');
		$criteria->params = array(
				':date' => date('Y-m-d 00:00:00', strtotime('-1 day')),
		);

		// Renew on request or if current day rates not exists
		$rates = Rate::model()->findAll($criteria);

		if (($renew == '1') || (count($rates) == 0))
		{
			$cbr = new ProviderCBR();
			$json['success'] = $cbr->renewRates();

			$rates = Rate::model()->findAll($criteria);
		}
		else
		{
			$json['success'] = true;
		}

		$currentRates = CHtml::listData(SelectedRate::model()->findAll(), 'char_code', 'rate');

		// Make controls for unselected rates
		$unselectedRates = array(
			'<select name="char_code" onchange="javascript: add_to_selected()">',
			'<option value="" selected>Выберите валюту для отображения в списке...</option>',
		);
		foreach($rates as $rate)
		{
			if (!in_array($rate->id, CHtml::listData($currentRates, 'id', 'id')))
			{
				$unselectedRates[] = '<option value="' . $rate->char_code . '">' . $rate->char_code . ' - ' . $rate->name . '</option>';
			}
		}
		$unselectedRates[] = '</select>';
		$json['addlist'] = implode("\n", $unselectedRates);

		// Render table of currency rates
		$json['html'] = $this->renderPartial('_rates', array(
			'rates' => $currentRates, 
		), true);

		echo json_encode($json);
	}

	/**
	 * actionAddRateAjax 
	 * 
	 * @param mixed $id 
	 * @access public
	 * @return void
	 */
	public function actionAddRateAjax($char_code=NULL)
	{
		$rate = Rate::model()->findByAttributes(array('char_code' => $char_code));

		if (($rate instanceof Rate) && $rate->addToSelected())
		{
			echo json_encode(array('success' => true));
			return;
		}

		echo json_encode(array('success' => false));
	}

	/**
	 * actionRemoveRateAjax 
	 * 
	 * @param mixed $id 
	 * @access public
	 * @return void
	 */
	public function actionRemoveRateAjax($char_code=NULL)
	{
		$rate = Rate::model()->findByAttributes(array('char_code' => $char_code));

		if (($rate instanceof Rate) && $rate->removeFromSelected())
		{
			echo json_encode(array('success' => true));
			return;
		}

		$json = array('success' => false);
		if (count(SelectedRate::model()->findAll()) <= 1)
		{
			$json['message'] = 'Невозможно удалить единственную валюту в списке. Замените ее другой.';
		}

		echo json_encode($json);
	}
}
