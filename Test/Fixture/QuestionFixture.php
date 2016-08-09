<?php
/**
 * QuestionFixture
 *
 */
class QuestionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'type' => array('type' => 'string', 'null' => false, 'default' => 'Single Answer with Multiple Choice', 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'question' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'times_served' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'times_corrected' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'times_incorrected' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'times_unattempted' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
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
			'type' => 'Lorem ipsum dolor sit amet',
			'question' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'times_served' => 1,
			'times_corrected' => 1,
			'times_incorrected' => 1,
			'times_unattempted' => 1,
			'created' => '2016-06-15 14:31:53',
			'updated' => '2016-06-15 14:31:53'
		),
	);

}
