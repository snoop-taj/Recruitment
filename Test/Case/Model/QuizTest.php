<?php
App::uses('Quiz', 'Recruitment.Model');

/**
 * Quiz Test Case
 *
 */
class QuizTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.recruitment.quiz',
		'plugin.recruitment.result'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Quiz = ClassRegistry::init('Recruitment.Quiz');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Quiz);

		parent::tearDown();
	}

}
