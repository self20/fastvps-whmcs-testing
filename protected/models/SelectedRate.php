<?php

	class SelectedRate extends CActiveRecord
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
			return 'tbl_selected_rates';
		}

		/**
		 * relations 
		 * 
		 * @return array
		 */
		public function relations()
		{
			return array(
				'rate' => array(self::HAS_ONE, 'Rate', 'char_code', 'condition' => '`date`="' . date('Y-m-d 00:00:00'). '"'),
			);
		}

		/**
		 * rules 
		 * 
		 * @return array
		 */
		public function rules()
		{
			return array(
				array('char_code', 'unique'),
				array('char_code', 'length', 'min'=>3, 'max'=>3),
			);
		}
	};
