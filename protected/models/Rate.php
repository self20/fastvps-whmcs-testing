<?php

	class Rate extends CActiveRecord
	{
		static public function model($className=__CLASS__)
		{
			return parent::model($className);
		}
		/**
		 * tableName 
		 * 
		 * @return string
		 */
		public function tableName()
		{
			return 'tbl_rates';
		}

		/**
		 * attributeLabels 
		 * 
		 * @return array
		 */
		public function attributeLabels()
		{
			return array(
				'id'             => 'ID',
				'currently_date' => 'Дата',
				'remote_id'      => 'Внешний ID',
				'num_code'       => 'Числовой код',
				'char_code'      => 'Буквенный код',
				'nominal'        => 'Номинал',
				'name'           => 'Наименование валюты',
				'value'          => 'Стоимость',
			);
		}

		public function rules()
		{
			return array(
				array('date, remote_id, num_code, char_code, nominal, name, value', 'required'),
				array('num_code, char_code', 'length', 'min'=>3, 'max'=>3),
				array('nominal', 'numerical', 'min'=>1),
				array('name', 'length', 'min'=>1, 'max'=>254),
				array('value', 'numerical', 'integerOnly'=>false),
			);
		}

		public function relations()
		{
			return array(
				'selected' => array(self::BELONGS_TO, 'SelectedRate', 'char_code'),
			);
		}

		/**
		 * isSelected 
		 * 
		 * @return boolean
		 */
		public function isSelected()
		{
			return ($this->selected instanceof SelectedRate);
		}

		/**
		 * addToSelected 
		 * 
		 * @return boolean
		 */
		public function addToSelected()
		{
			if ($this->isNewRecord)
			{
				return FALSE;
			}

			if ($this->isSelected())
			{
				return TRUE;
			}

			$selectedRate = new SelectedRate();
			$selectedRate->attributes = array(
				'char_code' => $this->char_code,
			);

			return $selectedRate->save();
		}

		/**
		 * removeFromSelected 
		 * 
		 * @return boolean
		 */
		public function removeFromSelected()
		{
			$currentRates = CHtml::listData(SelectedRate::model()->findAll(), 'char_code', 'rate');
			if ($this->isNewRecord || (count($currentRates) <= 1))
			{
				return FALSE;
			}

			if (!$this->isSelected())
			{
				return TRUE;
			}

			return $this->selected->delete();
		}
	}
