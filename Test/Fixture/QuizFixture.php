<?php
/**
 * QuizFixture
 *
 */
class QuizFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'quiz';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 1000, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'start_date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'end_date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'no_of_questions' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'duration' => array('type' => 'integer', 'null' => false, 'default' => '60', 'length' => 10),
		'maximum_attempts' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 10),
		'pass_percentage' => array('type' => 'float', 'null' => false, 'default' => '50'),
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
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'start_date' => '2016-06-15 11:57:16',
			'end_date' => '2016-06-15 11:57:16',
			'no_of_questions' => 1,
			'duration' => 1,
			'maximum_attempts' => 1,
			'pass_percentage' => 1,
			'created' => '2016-06-15 11:57:16',
			'updated' => '2016-06-15 11:57:16'
		),
	);

}
