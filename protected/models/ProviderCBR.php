<?php 

class ProviderCBR
{
	private $errors = array();

	/**
	 * getErrors 
	 * 
	 * @return array
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 * retrieveXMLData 
	 * 
	 * @param string $url 
	 * @return mixed
	 */
	private function retrieveXMLData($url)
	{
		$curl = curl_init();
		if ($curl === FALSE)
		{
			$this->errors[] = 'Ошибка инициализации запроса.';
			return FALSE;
		}

		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

		$res = curl_exec($curl);

		$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$http_info   = curl_getinfo($curl);
		curl_close($curl);

		$message = '';
		switch($http_status)
		{
			case 200:
				return $res;
			case 301:
				$this->errors[] = "Ошибка при получении данных курса валют ({$http_status} - Страница была перемещена).";
				break;
			case 400:
				$this->errors[] = "Ошибка при получении данных курса валют ({$http_status} - Некорректный запрос).";
				break;
			case 401:
				$this->errors[] = "Ошибка при получении данных курса валют ({$http_status} - Требуется авторизация).";
				break;
			case 403:
				$this->errors[] = "Ошибка при получении данных курса валют ({$http_status} - Ресурс находится в закрытом доступе).";
				break;
			case 404:
				$this->errors[] = "Ошибка при получении данных курса валют ({$http_status} - Ресурс не найден).";
				break;
			case 500:
				$this->errors[] = "Ошибка при получении данных курса валют ({$http_status} - Внутренняя ошибка сервера).";
				break;
			default:
				$this->errors[] = "Ошибка при получении данных курса валют ({$http_status}).";
		}

		return FALSE;
	}

	/**
	 * renewRates 
	 * Method retrieve XML with currency rates and parse it into the database or update if exists
	 * 
	 * @return boolean
	 */
	public function renewAllRates()
	{
		$onDate = date('d/m/Y');
		$url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . htmlentities($onDate);

		$res = $this->retrieveXMLData($url);
		if ($res === FALSE)
		{
			return FALSE;
		}

		try
		{
			$xml = new SimpleXMLElement($res);
			if (!isset($xml->Valute))
			{
				$this->errors[] = 'Ответ не соответствует обрабатываемой структуре данных.';
				return FALSE;
			}

			foreach($xml->Valute as $valute)
			{	
				// Have a strange behaviour on directly putting data into attributes of model,
				// ... it's wouldn't insert data in values of lambda-array
				$attributes = array(
						'date'	    => date('Y-m-d 00:00:00'),
						'remote_id' => (string)$valute['ID'],
						'num_code'  => (string)$valute->NumCode,
						'char_code' => (string)$valute->CharCode,
						'nominal'   => (string)$valute->Nominal,
						'name'      => (string)$valute->Name,
						'value'     => str_replace(',', '.', (string)$valute->Value),
				);

				$rate = Rate::model()->findByAttributes(array(
					'remote_id' => $attributes['remote_id'],
				));

				if (!$rate instanceof Rate)
				{
					$rate = new Rate();
				}

				$rate->attributes = $attributes;
				if (!$rate->save())
				{
					$this->errors[] = 'Ошибка при сохранении влюты (' . $rate->remote_id . ')';
					$model_errors = array();
					foreach($rate->getErrors() as $errors)
					{
						$model_errors[] = implode("\n", $errors);
					}
					Yii::log('errors', 'Ошибка при сохранении валюты: ' . implode("\n", $model_errors));
					return FALSE;
				}
			}
			return TRUE;
		}
		catch (Exception $e)
		{
			$this->errors[] = 'Произошла ошибка при обработке полученных данных от сервера.';
			Yii::log('error', 'Error on parsing XML data: ' . $e->getMessage());
		}

		return FALSE;
	}

	/**
	 * renewRates 
	 * 
	 * @param Rate $rateCode 
	 * @access public
	 * @return boolean
	 */
	public function renewRate($rate)
	{
		$onDate = date('d/m/Y');
		$url = "http://www.cbr.ru/scripts/XML_dynamic.asp?date_req1={$onDate}&date_req2={$onDate}&VAL_NM_RQ={$rate->remote_id}";

		$res = $this->retrieveXMLData($url);
		if ($res === FALSE)
		{
			return FALSE;
		}

		try
		{
			$xml = new SimpleXMLElement($res);

			if (isset($xml->Record))
			{
				$rate->attributes = array(
					'date'    => date('Y-m-d 00:00:00'),
					'nominal' => (string)$xml->Record->Nominal,
					'value'   => str_replace(',', '.', (string)$xml->Record->Value),
				);

				if ($rate->save())
				{
					return TRUE;
				}
				else
				{
					$this->errors[] = 'Произошла ошибка при сохранении данных о валюте. Ошибка записана в лог.';
					$model_errors = array();
					foreach($rate->getErrors() as $errors)
					{
						$model_errors[] = implode("\n", $errors);
					}
					Yii::log('errors', 'Ошибка при сохранении валюты: ' . implode("\n", $model_errors));
				}
			}
			else
			{
				$this->errors[] = 'Банк не распологает информацией о валюте "' . $rate->nominal . ' ' . $rate->name . '" на текущую дату.';
			}
		}
		catch (Exception $e)
		{
			$this->errors[] = 'Произошла ошибка при обработке полученных данных от сервера.';
			$this->errors[] = $e->getMessage();
			Yii::log('error', 'Error on parsing XML data: ' . $e->getMessage());
		}


		return FALSE;
	}
}

