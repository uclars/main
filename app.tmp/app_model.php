<?php
//### CREATE 2010/06/20 Pyon ###
class AppModel extends Model {

	//### 文字数チェック(マルチバイト対応)[上書き] ###
	function between($data, $minlength, $maxlength) {
		return (AppModel::minLength($data, $minlength) && AppModel::maxLength($data, $maxlength)); 
	}
	function minLength($data, $minlength) {
		return mb_strlen(array_shift($data), Configure::read('App.encoding')) >= $minlength;
	}
	function maxLength($data, $maxlength) {
		return mb_strlen(array_shift($data), Configure::read('App.encoding')) <= $maxlength;
	}

	//### 同一チェック ###
	function sameCheck($data, $target) {
		return strcmp(array_shift($data), $this->data[$this->name][$target]) == 0;
	}

}
?>