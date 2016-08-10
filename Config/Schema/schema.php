<?php 
class RecruitmentSchema extends CakeSchema {
        
        public $name = 'Recruitment';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}
        
        public $applications = array(
                'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'key' => 'primary'),
                'first_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 60, 'collate'=> 'utf8_unicode_ci', 'charset' => 'utf8'),
                'last_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 60, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                'email' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                'job_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
                'quiz_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
                'decline' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
                'accept' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
                'street_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 60, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                'city' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                'post_code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                'country' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                'phone' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' =>13),
                'additional_info' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                'curriculum_vitae' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                'curriculum_vitae_path' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                'curriculum_vitae_type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
                'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
                'indexes' => array(
                        'PRIMARY' => array('column' => 'id', 'unique' => 1)
                ),
                'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
        );
        
        public $jobs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'alias' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
                        'job_alias' => array('column' => 'alias', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);
        
        public $quiz = array(
                'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
                'question_ids' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
        
        public $categories = array(
                'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
                'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 1000, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
                'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
                'indexes' => array(
                        'PRIMARY' =>  array('column' => 'id', 'unique' => 1)
                ),
                'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
        );
        
        public $questions = array(
                'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
                'type' => array('type' => 'string', 'null' => false, 'default' => 'Single Answer with Multiple Choice', 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8' ),
                'question' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                'category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
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
        
        public $results = array(
                'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
                'application_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100),
                'quiz_id'  => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
                'question_ids' => array('type' => 'text', 'null' => false, 'default' => null),
                'status' => array('type' => 'string', 'null' => false, 'default' => 'Open', 'length' => 100),
                'start_time' => array('type' => 'datetime', 'null' => false, 'default' => null),
                'end_time' => array('type' => 'datetime', 'null' => false, 'default' => null),
                'individual_time' => array('type' => 'text', 'null' => false, 'default' => null),
                'individual_score' => array('type' => 'text', 'null' => false, 'default' => null),
                'total_time' => array('type' => 'integer', 'null' => false, 'default' => '0'),
                'score' => array('type' => 'float', 'null' => false, 'default' => '0'),
                'percentage' => array('type' => 'float', 'null' => false, 'default' => '0'),
                'manual_valuation' => array('type' => 'integer', 'null' => false, 'default' => '0'),
                'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
                'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
                'indexes' => array(
                        'PRIMARY' => array('column' => 'id', 'unique' => 1)
                ),
                'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
        );
        
        public $answers = array(
                'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
                'question_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
                'application_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100),
                'result_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
                'option' => array('type' => 'text', 'null' => false, 'default' => null),
                'score' => array('type' => 'float', 'null' => false, 'default' => '0'),
                'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
                'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
                'indexes' => array(
                        'PRIMARY' => array('column' => 'id', 'unique' => 1)
                ),
                'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
        );
        
        public $options = array(
                'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
                'question_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
                'option' => array('type' => 'text', 'null' => false, 'default' => null),
                'score' => array('type' => 'float', 'null' => false, 'default' => 0),
                'indexes' => array(
                        'PRIMARY' => array('column' => 'id', 'unique' => 1)
                ),
                'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
        );
       
}
