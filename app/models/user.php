<?php
class User extends AppModel
{
	var $name = 'User';
	//var $validate = array(
	//	'email' => VALID_EMAIL,
	//);
	var $hasMany = array('Post');
}
?>
