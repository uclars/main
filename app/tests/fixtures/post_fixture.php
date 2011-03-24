<?php
/* Post Fixture generated on: 2011-03-04 23:40:42 : 1299249642 */
class PostFixture extends CakeTestFixture {
	var $name = 'Post';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'text' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'keyword' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'delflg' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'created' => array('column' => 'created', 'unique' => 0), 'modified' => array('column' => 'modified', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'text' => 'Lorem ipsum dolor sit amet',
			'keyword' => 'Lorem ipsum dolor sit amet',
			'created' => '2011-03-04 23:40:42',
			'modified' => '2011-03-04 23:40:42',
			'delflg' => 1
		),
	);
}
?>