<?php 

class ProviderCBR
{
	/**
	 * renewRates 
	 * Method retrieve XML with currency rates and parse it into the database or update if exists
	 * 
	 * @return boolean
	 */
	public function renewRates()
	{
		$curl = curl_init();

		if ($curl === FALSE)
		{
			return FALSE;
		}

		$onDate = date('d/m/Y');
		$url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . htmlentities($onDate);

		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

		$res = curl_exec($curl);

		curl_close($curl);

		$xml = new SimpleXMLElement($res);

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
				'date'      => $attributes['date'],
			));


			if (!$rate instanceof Rate)
			{
				$rate = new Rate();
			}

			$rate->attributes = $attributes;

			if (!$rate->save())
			{
				return FALSE;
			}
		}

		return TRUE;
	}
}

