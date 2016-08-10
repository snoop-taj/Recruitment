<?php
App::uses('Answer', 'Recruitment.Model');

/**
 * Answer Test Case
 *
 */
class AnswerTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.recruitment.answer',
		'plugin.recruitment.question',
		'plugin.recruitment.application',
		'plugin.recruitment.result'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Answer = ClassRegistry::init('Recruitment.Answer');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Answer);

		parent::tearDown();
	}

}
