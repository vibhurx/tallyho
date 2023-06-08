<?php

class Common extends CApplicationComponent 
{
	public function renderJson(array $models, $attributeNames) {
		header('Content-Type: application/json');
		$attributeNames = explode(',', $attributeNames);
	
		$rows = array(); //the rows to output
		foreach ($models as $model) {
			$row = array(); //you will be copying in model attribute values to this array
			foreach ($attributeNames as $name) {
				$name = trim($name); //in case of spaces around commas
				$row[$name] = CHtml::value($model, $name); //this function walks the relations
			}
			$rows[] = $row;
		}
		header('Content-type:application/json');
		return CJSON::encode($rows);
		//return CJavaScript::jsonEncode($rows); >> @todo: standardize JSON related calls
	}
}