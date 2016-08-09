<?php
App::uses('Result', 'Recruitment.Model');

/**
 * Result Test Case
 *
 */
class ResultTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.recruitment.result',
		'plugin.recruitment.application',
		'plugin.recruitment.quiz',
		'plugin.recruitment.questions',
		'plugin.recruitment.answer'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Result = ClassRegistry::init('Recruitment.Result');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Result);

		parent::tearDown();
	}

}
