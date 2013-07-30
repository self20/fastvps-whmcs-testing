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
		$this->render('index');
	}

	/**
	 * actionGetRatesAjax 
	 * 
	 * @param mixed $id 
	 * @return void
	 */
	public function actionGetRatesAjax($id=NULL)
	{
		header('Cache-Control: no-cache, must-revalidate');

		// Get any selected or all rates
		if ($id !== NULL)
		{
			$criteria = new CDbCriteria();
			if (!is_array($id))
			{
				$criteria->addCondition('remote_id = :remote_id');
				$criteria->params = array(':remote_id'=> (string)$id);
			}
			else
			{
				$criteria->addInCondition('remote_id', $id);
			}

			$rates = Rate::model()->findAll($criteria);
		}
		else
		{
			$rates = Rate::model()->findAll();
		}

		$json = array(
			'success' => true,
			'rates' => array(),
			'count' => count($rates),
		);

		if (count($rates) > 0)
		{
			foreach($rates as $rate)
			{
				$json['rates'][$rate->remote_id] = array(
					'remote_id' => $rate->remote_id,
					'char_code' => $rate->char_code,
					'name'      => $rate->name,
					'nominal'   => (int)$rate->nominal,
					'value'     => $rate->value,
					'selected'  => (bool)$rate->selected,
				);
			}

			uasort($json['rates'], function ($a, $b) {
				return strcmp($a['name'], $b['name']);
			});
		}

		echo json_encode($json);
	}

	/**
	 * actionUpdateRatesAjax 
	 * 
	 * @param mixed $id
	 * @return void
	 */
	public function actionUpdateRatesAjax($id=NULL)
	{
		header('Cache-Control: no-cache, must-revalidate');
		
		$json = array(
			'success' => false,
		);

		$cbr = new ProviderCBR();
		if (is_string($id))
		{
			$id = preg_replace('/[^A-Z0-9]+/', '', $id);
			$rate = Rate::model()->findByAttributes(array('remote_id' => $id));
			if ($rate instanceof Rate)
			{
				$json['success'] = $cbr->renewRate($rate);
				$json['errors'] = $cbr->getErrors();
			}
			else
			{
				$json['errors'] = array('Валюта с идентификатором "' . $id . '" не найдена.');
			}
		}
		else
		{
			$json['success'] = $cbr->renewAllRates();
			$json['errors'] = $cbr->getErrors();
		}

		echo json_encode($json);
	}

	/**
	 * actionSetRateSelected 
	 * 
	 * @param mixed $id
	 * @param string $select
	 * @return void
	 */
	public function actionSetRateSelected($id = NULL, $select = '1')
	{
		header('Cache-Control: no-cache, must-revalidate');

		$id = preg_replace('/[^A-Z0-9]+/', '', $id);
		$rate = Rate::model()->findByAttributes(array('remote_id' => $id));
		if ($rate instanceof Rate)
		{
			$rate->attributes = array(
				'selected' => (($select == '1') ? 1 : 0),
			);

			echo json_encode(array('success' => $rate->save()));
		}
		else
		{
			echo json_encode(array('success' => false, 'errors' => array('Валюта не найдена в базе данных')));
		}
	}
}
