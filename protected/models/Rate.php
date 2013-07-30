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
				'selected'       => 'В списке',
			);
		}

		/**
		 * scopes 
		 * 
		 * @return array
		 */
		public function scopes()
		{
			return array(
				'selected'   => array('condition' => 'selected = 1'),
				'unselected' => array('condition' => 'selected = 0'),
			);
		}

		/**
		 * rules 
		 * 
		 * @return rules
		 */
		public function rules()
		{
			return array(
				array('date, remote_id, num_code, char_code, nominal, name, value', 'required'),
				array('num_code, char_code', 'length', 'min'=>3, 'max'=>3),
				array('nominal', 'numerical', 'min'=>1),
				array('name', 'length', 'min'=>1, 'max'=>254),
				array('value', 'numerical', 'integerOnly'=>false),
				array('selected', 'numerical', 'integerOnly'=>true),
			);
		}

		/**
		 * relations 
		 * 
		 * @return array
		 */
		public function relations()
		{
			return array();
		}
	}
