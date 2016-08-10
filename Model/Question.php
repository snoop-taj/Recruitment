<?php
/**
 * Question Model
 *
 * @category    Question.Model
 * @package     Recruitment.Question.Model
 * @property    Answer $Answer
 * @version     1.0
 * @author      Zak Taj <info@etechnologia.co.uk>
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/snoop-taj/Recruitment
 */
App::uses('RecruitmentAppModel', 'Recruitment.Model');

class Question extends RecruitmentAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'type' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Question type cannpt be empty',
				'required' => false,
                            
			),
		),
		'question' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Question cannot be empty',
				'required' => true,
			),
		),
                'option' => array(
                        'notEmpty' => array(
				'rule' => array('notEmpty'),
                                'message' => 'Option cannot be empty',
                                'required' => true
                        ),
                ),
                'score' => array(
                        'notEmpty' => array(
				'rule' => array('notEmpty'),
                                'message' => 'Score cannot be empty',
                                'requried' => true
                        ),
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
			'foreignKey' => 'question_id',
			'dependent' => false
		),
                'Option' => array(
                        'className' => 'Recruitment.Option',
                        'dependent' => true,
                        'foreignKey' => 'question_id'
                )
	);

/**
 * belongsTo associations
 *
 * @var array
 */
        public $belongsTo = array(
                'Category' => array(
                        'className' => 'Recruitment.Category',
                        'foreignKey' => 'category_id'
                )
        );
        
/**
 * Filter search fields
 *
 * @var array
 * @access public
 */
//	public $filterArgs = array(
//		'chooser' => array('type' => null),
//		'name' => array('type' => 'like', 'field' => array('User.name', 'User.username')),
//		'role_id' => array('type' => 'value'),
//	);

/**
 * Edit Question with its options and score
 * 
 * @param int $data
 * @return boolean
 */        
        public function edit($data = null) {
            $dataOption = array();
            $dataScore = array();
            $option = '';
            $optionId = null;
            
            if (isset($data[$this->name]['options'])) {
                    $questionType = $data[$this->name]['type'];
                    unset($data[$this->name]['type']);

                    $option = $data[$this->name]['options'];
                    unset($data[$this->name]['options']);

                    if (isset($data[$this->name]['scores'])) {
                            $dataScore = $data[$this->name]['scores'];
                            unset($data[$this->name]['scores']);
                    }
                    $fieldList = array('type', 'question');
                    $success = parent::save($data, true, $fieldList);
                    if ($success) {
                            return $this->_editOptions($dataScore, $questionType, $option);
                    } else {
                            return false;
                    }
            } else {
                    return parent::save($data, true, array()); 
            }
        }

/**
 * Edit options and score
 * 
 * @param array $dataScore
 * @param array $questionType
 * @param string $option
 * @return boolean
 */
        private function _editOptions($dataScore, $questionType, $option) {
                $Option = ClassRegistry::init('Option'); 
                // will be removed on production 
//                $Option->useDbConfig = 'test';
                if (is_array($option)) {
                        foreach ($option as $key => $val) {
                                $score = 0;
                                switch($questionType) {
                                        case 'Single Answer with Multiple Choice' :
                                            if ($key == current($dataScore)) {
                                                    $score = 1;
                                            }
                                            break;
                                        case 'Multiple Answer with Multiple Choice' :
                                            foreach ($dataScore as $scoreKey => $scoreVal) {
                                                    if ($scoreVal['score'] == 0) {
                                                            unset($dataScore[$scoreKey]);
                                                    }
                                            }
                                            if (key_exists($key, $dataScore)) {
                                                    $score = 1/count($dataScore);
                                            }
                                            break;
                                        case 'Short Answer' :
                                            $score = 1;
                              }
                              $dataOption[] = array(
                                    'id' => $val['id'],
                                    'option' => $val['option'],
                                    'score' => $score
                              );
                              $Option->saveAll($dataOption);
                        }
                }
                return true;
        }
/**
 * Saves model data
 * 
 * @see Model::save()
 * 
 */
        public function save($data = null, $validate = true, $fieldList = array()) {

                $dataOption = array();
                $dataScore = array();
                $option = '';
                
                if (isset($data[$this->name]['options'])) {
                        $questionType = $data[$this->name]['question_type'];
                        unset($data[$this->name]['question_type']);
                        
                        $option = $data[$this->name]['options'];
                        unset($data[$this->name]['options']);
                        
                        if (isset($data[$this->name]['scores'])) {
                                $dataScore = $data[$this->name]['scores'];
                                unset($data[$this->name]['scores']);
                        }
                        $fieldList = array('type', 'question');
                        $success = parent::save($data, $validate, $fieldList); 
                        if ($success) {
                                $lastId = $this->id;
                                return $this->_saveOptions($lastId, $dataScore, $questionType, $option);
                        } else {
                                return false;
                        }

                } else {
                    return parent::save($data, $validate, $fieldList);
                }   
        }

/**
 * Save Options model
 * 
 * @param int $qId
 * @param array $dataScore
 * @param array $questionType
 * @param string $option
 * @return boolean
 */
        private function _saveOptions($qId, $dataScore, $questionType, $option) {
                $Option = ClassRegistry::init('Option'); 
                // will be removed on production 
//                $Option->useDbConfig = 'test';
                if (is_array($option)) {
                        foreach ($option as $key => $val) {
                                $score = 0;
                                switch($questionType) {
                                        case 'single' :
                                            if ($key == current($dataScore)) {
                                                    $score = 1;
                                            }
                                            break;
                                        case 'multiple' :
                                            foreach ($dataScore as $scoreKey => $scoreVal) {
                                                    if ($scoreVal['score'] == 0) {
                                                            unset($dataScore[$scoreKey]);
                                                    }
                                            }
                                            if (key_exists($key, $dataScore)) {
                                                    $score = 1/count($dataScore);
                                            }
                                            break;
                                        case 'short' :
                                            $score = 1;
                              }
                              $dataOption[] = array(
                                    'question_id' => $qId,
                                    'option' => $val['option'],
                                    'score' => $score
                              );
                        }
                }
                return $Option->saveAll($dataOption);
        }
}
