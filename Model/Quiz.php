<?php
App::uses('RecruitmentAppModel', 'Recruitment.Model');
/**
 * Quiz Model
 *
 * @category    Quiz.Model
 * @package     Recruitment.Quiz.Model
 * @property    Result $Result
 * @version     1.0
 * @author      Zak Taj <info@etechnologia.co.uk>
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/snoop-taj/Recruitment
 */
class Quiz extends RecruitmentAppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'quiz';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Quiz name cannot be empty',
				'required' => true,
			),
		),
		'description' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Description cannot be empty',
				'required' => true,
			),
		),
		'start_date' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				'message' => 'Start date cannot be empty',
				'required' => true,
			),
		),
		'end_date' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				'message' => 'End date cannot be empty',
				'required' => true,
			),
                        'date_diff' => array(
                                'rule' => 'date_diff',
                                'message' => 'The end date must be later then start date',
                        ),
		),
		'duration' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Duration cannot be empty',
				'required' => true,
			),
		),
		'maximum_attempts' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Maximum attempt field cannot be empty',
				'required' => true,
			),
		),
                'pass_percentage' => array(
                        'numeric' => array(
                                'rule' => array('numeric'),
                                'message' => 'Pass percentage cannot be empty',
                                'required' => true
                        )
                )
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Result' => array(
			'className' => 'Recruitment.Result',
			'foreignKey' => 'quiz_id',
			'dependent' => false
		)
	);
        
        public function removeQuestionId($quizId, $questionId) { 
                $this->id = $quizId;
                $quiz = $this->read('question_Ids'); 
                $questionIDs = explode(',', $quiz['Quiz']['question_Ids']);
                $newQId = array_diff($questionIDs, array($questionId));
                $data = array(
                            'question_ids' => implode(',',$newQId), 
                            'no_of_questions' => count($newQId)
                        );
                return $this->save($data, false, array());
        }
        
        public function addQuestion($quizId, $questionId) {
                $this->id = $quizId;
                $quiz = $this->read('question_Ids'); 
                $newQId = array(); 
                $newQId[] = $questionId;
                if ($quizId && $questionId) {
                        foreach (explode(',', $quiz['Quiz']['question_Ids']) as $val) {
                                if (!empty($val) && $val != $questionId) {
                                        $newQId[] = $val;
                                }
                        }
                }
                $newQId = array_filter(array_unique($newQId)); 
                $noOfQuestions = count($newQId);
                
                $data = array(
                        'question_ids' => implode(',',$newQId), 
                        'no_of_questions' => count($newQId)
                        );
                return $this->save($data, false, array());
        }

/**
 * Custome validation for date diff
 * 
 * @return boolean
 */
        public function date_diff() {
                if ($this->data['Quiz']['end_date'] > $this->data['Quiz']['start_date']) {
                        return true;
                }
                
                return false;
        }

}
