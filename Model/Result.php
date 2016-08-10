<?php
App::uses('RecruitmentAppModel', 'Recruitment.Model');
/**
 * Result Model
 *
 * @category    Result.Model
 * @package     Recruitment.Result.Model
 * @property    Application $Application
 * @property    Quiz $Quiz
 * @property    Questions $Questions
 * @property    Answer $Answer
 * @version     1.0
 * @author      Zak Taj <info@etechnologia.co.uk>
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/snoop-taj/Recruitment
 */
class Result extends RecruitmentAppModel {

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Application' => array(
			'className' => 'Recruitment.Application',
			'foreignKey' => 'application_id'
		),
		'Quiz' => array(
			'className' => 'Recruitment.Quiz',
			'foreignKey' => 'quiz_id'
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Answer' => array(
			'className' => 'Recruitment.Answer',
			'foreignKey' => 'result_id',
			'dependent' => true
		)
	);
        
/**
 * Add results from quiz
 * 
 */
        public function addResult($quizId, $applicantId) {
                $Quiz = ClassRegistry::init('Quiz');
                $quiz = $Quiz->read(array('question_ids', 'no_of_questions'), $quizId);
                
                if ($quiz['Quiz']['no_of_questions'] == '') {
                        return false;
                }
                
                $zeros = '';
                $zeros = array_fill(0, $quiz['Quiz']['no_of_questions'], 0);
                if (is_array($zeros)) {
                        $zeros = implode(',', $zeros);
                }
                
                $data = array(
                        'application_id' => $applicantId,
                        'quiz_id' => $quizId,
                        'question_ids' => $quiz['Quiz']['question_ids'],
                        'start_time' => date("Y-m-d H:i:s"),
                        'individual_time' => $zeros,
                        'individual_score' => $zeros
                );

                if ($this->save($data, false)) {
                        return $this->id;
                }
        }
}
