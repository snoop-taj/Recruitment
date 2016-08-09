<?php
/**
 * AnswerFixture
 *
 */
class AnswerFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'question_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'application_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'result_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'score' => array('type' => 'float', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'question_id' => 1,
			'application_id' => 1,
			'result_id' => 1,
			'score' => 1,
			'created' => '2016-06-15 14:34:40',
			'updated' => '2016-06-15 14:34:40'
		),
	);

}
