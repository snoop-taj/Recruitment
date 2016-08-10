<?php
/**
 * Quizzes Controller
 *
 * @category    Quizzes.Controller
 * @package     Recruitment.Quizzez.Controller
 * @property    Quiz $Quiz
 * @version     1.0
 * @author      Zak Taj <info@etechnologia.co.uk>
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/snoop-taj/Recruitment
 * @property 
 */
App::uses('CakeEmail', 'Network/Email');
App::uses('RecruitmentAppController', 'Recruitment.Controller');

class QuizzesController extends RecruitmentAppController {

        public $uses = array(
                'Recruitment.Quiz', 
                'Recruitment.Application', 
                'Recruitment.Question',
                'Recruitment.Result',
                'Recruitment.Answer'
            );
        
        public $components = array('RequestHandler');
    
/**
 * Initiallized before Controller action
 * 
 */
        public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('detail', 'attempt', 'set_individual_time', 'save_answer', 'submit');
        }
        
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Quiz->recursive = 0;
		$this->set('quizzes', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Quiz->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid quiz'));
		}
		$options = array('conditions' => array('Quiz.' . $this->Quiz->primaryKey => $id));
		$this->set('quiz', $this->Quiz->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Quiz->create();
			if ($this->Quiz->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The quiz has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The quiz could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Quiz->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid quiz'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Quiz->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The quiz has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The quiz could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Quiz.' . $this->Quiz->primaryKey => $id));
                        $data = $this->Quiz->find('first', $options);
			$this->request->data = $data;
                        
                        $questions = array();
                        $join = array();
                        $questionId = 0;
                        if ($data['Quiz']['question_ids'] !== '') {
                                $questionId = $data['Quiz']['question_ids'];
                                $join['order'] = "FIELD(Question.id, {$data['Quiz']['question_ids']})";
                        }
                        $join['conditions'][] = array("Question.id IN ({$questionId})");
                        $questions = $this->Question->find('all', $join);
                        $this->set('questions', $questions);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Quiz->id = $id;
		if (!$this->Quiz->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid quiz'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Quiz->delete()) {
			$this->Session->setFlash(__d('croogo', 'Quiz deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Quiz was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}
        
/**
 * admin_move_question method to move 
 * question position for quiz
 * 
 * @return void
 */
        public function admin_move_question() {
                $this->autoRender = false;
                if ($this->request->is('ajax')) {
                        $questionId = $this->params['url']['questionId'];
                        $quizId = $this->params['url']['quizId'];
                        $len = $this->params['url']['newPos'];
                        $position = $this->params['url']['position'];
                        
                        $this->Quiz->id = $quizId;
                        $quiz = $this->Quiz->read(array('question_Ids', 'no_of_questions')); 
                        $questionIds = explode(',', $quiz['Quiz']['question_Ids']);

                        
                        if ($len < $quiz['Quiz']['no_of_questions']) {
                                for ($i = 1; $i <= $len; $i++) {
                                        $index = array_search($questionId, $questionIds); 
                                        if ($index !== false ) {
                                                switch ($position) {
                                                        case 'Up':
                                                            $tmp = $questionIds[$index - 1];
                                                            $questionIds[$index - 1] = $questionIds[$index];
                                                            $questionIds[$index] = $tmp;
                                                            break;
                                                        case 'Down':
                                                            $tmp = $questionIds[$index + 1];
                                                            $questionIds[$index + 1] = $questionIds[$index];
                                                            $questionIds[$index] = $tmp;
                                                            break;
                                                }
                                        }
                                } 
                        }
                        if ($this->Quiz->saveField('question_ids', implode(',', $questionIds))) {
                                $this->Session->setFlash(__d('croogo', 'Question successfully moved'), 'default', array('class' => 'success'));
                        } else {
                                $this->Session->setFlash(__d('croogo', 'Question not moved'), 'default', array('class' => 'error'));
                        }  
                }
        }
        
/**
 * admin_remove_question_id method to remove 
 * question from quiz by id
 * 
 * @throws NotFoundException
 * @param int $id Quiz id
 * @param int $questionId Question id
 * @return void
 */
        public function admin_remove_question_id($id = null, $questionId = null) {
                $this->Quiz->id = $id;
		if (!$this->Quiz->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid quiz'));
		}
                $this->Question->id = $questionId;
                if (!$this->Question->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid question'));
		}
                if ($this->Quiz->removeQuestionId($id, $questionId)) {
                        $this->Session->setFlash(__d('croogo', 'Question removed from Quiz #'. $id), 'default', array('class' => 'success'));
                        $this->redirect(array('action' => 'edit/'.$id));
                }
                $this->Session->setFlash(__d('croogo', 'Question not removed from Quiz #'. $id), 'default', array('class' => 'error'));
                $this->redirect(array('action' => 'edit/'.$id));
        }
        
/**
 * admin_add_question method add question for quiz
 * 
 * @param int $quizId Quiz id
 * @param int $questionId Question id
 * @return void
 */
        public function admin_add_question($quizId = null, $questionId = null) {
                
                $options = array('conditions' => array('Quiz.' . $this->Quiz->primaryKey => $quizId));
                $quiz = $this->Quiz->find('first', $options);
                if ($this->request->is('ajax')) {
                        if ($this->Quiz->addQuestion($quizId, $questionId)) {
                                $json_response = array();
                                $this->set('json_response', 'Added');
                        }
                }
                
		$this->set('quiz', $quiz);
                $this->set('questions', $this->Question->find('all'));
                $this->set('quizId', $quizId);
        }
        
/**
 * admin_evaluate_score method to evaluate quiz manually
 * 
 * @return boolean
 */
        public function admin_evaluate_score() {
                $this->autoRender = false;
                if ($this->request->is('ajax')) {
                        $resultId = $this->params['url']['resultId'];
                        $questionNo = $this->params['url']['questionNo'];
                        $scoreNo = $this->params['url']['score'];
                        
                        $result = $this->Result->find('first', array('conditions' => array('Result.id' => $resultId)));
                        
                        $questionIds = explode(',', $result['Result']['question_ids']);
                        $scores = explode(',', $result['Result']['individual_score']);
                        $scores[$questionNo] = $scoreNo;
                        $questionScores = array();
                        $correctScore = 1;
                        $incorrectScore = 0;
                        $marks = 0;
                        $valuation = 0;
                        $percentage = 0;

                        foreach ($scores as $score) {

                                switch($score) {
                                        case 1:
                                            $marks += $correctScore;
                                            break;
                                        case 2: 
                                            $marks += $incorrectScore;
                                            break;
                                        case 3:
                                            $valuation = 1;
                                }
                        }

                        $percentage = ($marks/$result['Quiz']['no_of_questions']) * 100;
                        if ($percentage <= $result['Quiz']['pass_percentage']) {
                                $status = 'Fail';
                        } else if ($valuation == 1) {
                                $status = 'Pending';
                        } else {
                                $status = 'Pass';
                        }

                        $data = array(
                                'individual_score' => implode(',', $scores),
                                'score' => $marks,
                                'percentage' => $percentage,
                                'manual_valuation' => $valuation,
                                'status' => $status
                        );
                        
                        $this->Result->id = $resultId;
                        
                        if ($this->Result->save($data)) {
                                
                                $this->Question->id = $questionIds[$questionNo];
                                
                                switch ($scoreNo) {
                                        case 1:
                                            $this->Question->saveField('times_corrected', (int)$this->Question->field('times_corrected') + 1);
                                            break;
                                        case 2:
                                            $this->Question->saveField('times_incorrected', (int)$this->Question->field('times_incorrected') + 1);
                                            break;
                                }

                                $this->Session->setFlash(__d('croogo', 'Succefully Submitted'), 'default', array('class' => 'success'));
                                switch ($status) {
                                        case 'Pass':
                                            $this->sendEmail($resultId);
                                            break;
                                }
                                return true;
                        } else {
                                $this->Session->setFlash(__d('croogo', 'Error Occoured!'), 'default', array('class' => 'error'));
                                return false;
                        }
                } 
        }
        

/**
 * detail method to show quiz detail for candidate
 * 
 * @param int $id Quiz id
 * @param int $uCandidate Application id
 * @throws NotFoundException
 * @return void
 */

        public function detail($id = null, $uCandidate = null) {
                
                $candidate = $this->Application->read(null, $uCandidate);

		if (!$this->Quiz->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid quiz'));
		}
                
                if (!$candidate) {
                        throw new NotFoundException(__d('croogo', 'Invalid candidate'));
                }
  
                if ($this->request->is('post')) {
                        if ($resultId = $this->_validate($id, $candidate)) {
                                $this->Session->write('Result.id', $resultId);
                                $this->redirect(array('action' => 'attempt/'.$resultId));
                        } 
                }
                $options = array('conditions' => array('Quiz.' . $this->Quiz->primaryKey => $id));
		$this->set('quiz', $this->Quiz->find('first', $options));
                $this->set('candidateId', $uCandidate);
        }
        
/**
 * _validate method to apply checks before attempting a quiz
 * 
 * @param id $id Quiz id
 * @param array $candidate Applicant data
 * @return boolean
 */
        private function _validate($id = null, $candidate) {
            
                $quizOptions = array('conditions' => array('Quiz.' . $this->Quiz->primaryKey => $id));
                $quiz = $this->Quiz->find('first', $quizOptions);
                $applicantId = $candidate['Application']['id'];
                
                if (!$candidate) {
                        $this->Session->setFlash(__d('croogo', 'Invalid Candidate'), 'default', array('class' => 'error'));
                        return false;
                }
                
                if (strtotime($quiz['Quiz']['start_date']) > time()) {
                       $this->Session->setFlash(__d('croogo', 'Quiz not available'), 'default', array('class' => 'error'));
                       return false;
                }

                if (strtotime($quiz['Quiz']['end_date']) < time()) {
                       $this->Session->setFlash(__d('croogo', 'Quiz has ended'), 'default', array('class' => 'error'));
                       return false;
                }

                if (isset($candidate['Result'])) {
                        foreach ($candidate['Result'] as $data) {
                                if ($data['application_id'] == $applicantId && $data['status'] == 'Open') {
                                        $this->Session->write('Application.id', $applicantId);
                                        return $data['id'];
                                }
                        }
                        
                        $maxAttempt = count($candidate['Result']);
                        if ($maxAttempt >= $quiz['Quiz']['maximum_attempts']) {
                                $this->Session->setFlash(__d('croogo', 'Exceeded Number of Attempts!'), 'default', array('class' => 'error'));
                                return false;
                        }
                }

                if ($resultId = $this->Result->addResult($id, $applicantId)) {
                        $this->Session->write('Application.id', $applicantId);
                        return $resultId;
                } else {
                        $this->Session->setFlash(__d('croogo', 'Validation error'), 'default', array('class' => 'error'));
                        return false;
                }
        }
        
/**
 * attempt method to start the quiz
 * 
 * @param int $resultId Result id
 * @throws NotFoundException
 * @return void
 */
        public function attempt($resultId = null) {
                $data = array();
                $applicantId = $this->Session->read('Application.id');
                
                if ($resultId != $this->Session->read('Result.id')) {
                        $this->Session->setFlash(__d('croogo', 'Quiz ended'), 'default', array('class' => 'error'));
                        throw new NotFoundException(__d('croogo', 'Permission Denied!'));
                }
                
                if (empty($applicantId)) {
                        $this->Session->setFlash(__d('croogo', 'Permission Denied!'), 'default', array('class' => 'error'));
                        throw new NotFoundException(__d('croogo', 'Permission Denied!'));
                }
                
                $result = $this->Result->find('first', array('conditions' => array('Result.id' => $resultId)));
                $join = array(
//                        'joins' => array(
//                            array(
//                                    'table' => 'quiz',
//                                    'alias' => 'Quiz',
//                                    'type' => 'INNER',
//                                    'conditions' => array("Question.id IN ({$result['Quiz']['question_ids']})")
//                                )
//                            ),
                        
                        'order' => array("FIELD(Question.id, {$result['Quiz']['question_ids']})")
                        ); 
                $join['conditions'] = array("Question.id IN ({$result['Quiz']['question_ids']})");
                $data['quiz'] = $result['Quiz'];
                $data['result'] = $result['Result'];

                if (strtotime($data['result']['start_time']) + ($data['quiz']['duration']*60) < time()) {
                        $this->submit($resultId);
                        $this->Session->delete('Result.id');
                        $this->Session->setFlash(__d('croogo', 'Time is Over!'), 'default', array('class' => 'error'));
                        $this->redirect(array('action' => 'detail/'.$data['quiz']['id'].'/'.$applicantId));
                }
                
                if (strtotime($data['quiz']['end_date']) < time()) {
                        $this->submit($resultId);
                        $this->Session->delete('Result.id');
                        $this->Session->setFlash(__d('croogo', 'Quiz Ended!'), 'default', array('class' => 'error'));
                        $this->redirect(array('action' => 'detail/'.$data['quiz']['id'].'/'.$applicantId));
                }
                
                $data['answer'] = $result['Answer'];
                $data['question'] = $this->Question->find('all', $join); 
                $data['seconds'] = ($data['quiz']['duration']*60) - (time() - strtotime($data['result']['start_time']));
                $data['resultId'] = $resultId;
                
                $this->set('data', $data);
        }
/**
 * set_individual_time method to set time spent on each question
 * 
 * @return void
 */
        public function set_individual_time() {
                $this->autoRender = false;
                if ($this->request->is('ajax')) {
                        if ($this->Session->read('Result.id') !== null) {
                                $this->Result->id = $this->Session->read('Result.id');
                                $this->Result->saveField('individual_time', $this->params['url']['individual_time']);
                        }
                }
        }
/**
 * save_answer method to save quiz answer
 * 
 * @return string
 */        
        public function save_answer() {
                $this->autoRender = false;
                if ($this->request->is('ajax')) {
                        $resultId = $this->params['url']['result_id'];
                        if ($resultId != $this->Session->read('Result.id')) {
                                return 'error';
                        }
                        
                        $this->Answer->deleteAll(array('Answer.result_id' => $resultId));
                        
                        $result = $this->Result->find('first', array('conditions' => array('Result.id' => $resultId)));

                        $questionIds = explode(',', $result['Result']['question_ids']);
                        $score = explode(',', $result['Result']['individual_score']);
                        if (isset($this->params['url']['answer'])) {
                                foreach ($this->params['url']['answer'] as $ansKey => $answer) {
                                        $data = array();
                                        $attempted = false;
                                        $marks = 0;
                                        $condition = array('conditions' => array('Question.id' => $questionIds[$ansKey]));
                                        $question = $this->Question->find('first', $condition);
                                        
                                        $data = array(
                                                'question_id' => (int)$questionIds[$ansKey],
                                                'application_id' => (string)$this->Session->read('Application.id'),
                                                'result_id' => (int)$resultId,
                                        );
                                        
                                        switch ($this->params['url']['question_type'][$ansKey]) {
                                                case 'single':
                                                case 'multiple':
                                                    $options = array();
                                                    foreach ($question['Option'] as $option) {
                                                            $options[$option['id']] = $option['score'];
                                                    }
                                                    foreach ($answer as $key => $val) {
                                                            if ($options[$val] < 0) {
                                                                    $marks += -1;
                                                            } else {
                                                                    $marks += $options[$val];
                                                            }
                                                            $data['option'] = $val;
                                                            $data['score'] = $options[$val];
                                                           
                                                            $attempted = $this->Answer->saveAll($data);
                                                    }
                                                    
                                                    if ($attempted) {
                                                            if ($marks >= '0.99') {
                                                                    $score[$ansKey] = 1;
                                                            } else {
                                                                    $score[$ansKey] = 2;
                                                            }
                                                    } else {
                                                            $score[$ansKey] = 0;
                                                    }
                                                    break;
                                                case 'short':
                                                    $options = array(); 
                                                    $optionData = reset($question['Option']);
                                                    $options = explode(',', strtoupper(trim($optionData['option'])));
                                                    
                                                    foreach ($answer as $key => $val) {
                                                            if ($val !== '') { 
                                                                    if (in_array(strtoupper(trim($val)), $options)) {
                                                                            $marks = 1;
                                                                    } else {
                                                                            $marks = 0;
                                                                    }
                                                                    
                                                                    $data['option'] = $val;
                                                                    $data['score'] = $marks;
                                                                    
                                                                    $attempted = $this->Answer->saveAll($data);
                                                            }
                                                    }
                                                    if ($attempted) {
                                                            if ($marks == 1) {
                                                                    $score[$ansKey] = 1;
                                                            } else {
                                                                    $score[$ansKey] = 2;
                                                            }
                                                    } else {
                                                            $score[$ansKey] = 0;
                                                    }
                                                    break;
                                                case 'long':
                                                    foreach ($answer as $key => $val) {
                                                            if ($val !== '') {
                                                                    $data['option'] = $val;
                                                                    $data['score'] = 0;
                                                                    
                                                                    $attempted = $this->Answer->saveAll($data);
                                                                    
                                                                    if ($attempted) {
                                                                            $score[$ansKey] = 3;
                                                                    } else {
                                                                            $score[$ansKey] = 0;
                                                                    }
                                                            }
                                                    }
                                                    break;
                                        }
                                }
                        }
                        
                        $this->Result->id = $resultId;
                        $data = array(
                                'individual_score' => implode(',', $score),
                                'individual_time' => $this->params['url']['individual_time']
                        );
                        
                        $this->Result->save($data);
                }
        }
/**
 * submit method to submit final answer of quiz
 * 
 * @param int $resultId
 * @throws NotFoundException
 * @return void
 */        
        public function submit($resultId = null) {
            
                if ($resultId === null || $resultId != $this->Session->read('Result.id')) {
                        throw new NotFoundException(__d('croogo', 'Permission Denied!'));
                }
                
                $result = $this->Result->find('first', array('conditions' => array('Result.id' => $resultId)));
                
                $totalTime = array_sum(explode(',', $result['Result']['individual_time']));
                $questionIds = explode(',', $result['Result']['question_ids']);
                $scores = explode(',', $result['Result']['individual_score']);
                $questionScores = array();
                $correctScore = 1;
                $incorrectScore = 0;
                $marks = 0;
                $valuation = 0;
                $percentage = 0;
                
                foreach ($scores as $key => $score) {
                        $questionScore[$questionIds[$key]] = $score;
                        
                        switch($score) {
                                case 1:
                                    $marks += $correctScore;
                                    break;
                                case 2: 
                                    $marks += $incorrectScore;
                                    break;
                                case 3:
                                    $valuation = 1;
                        }
                }
                
                $percentage = ($marks/$result['Quiz']['no_of_questions']) * 100;
                if ($percentage <= $result['Quiz']['pass_percentage']) {
                        $status = 'Fail';
                } else if ($valuation == 1) {
                        $status = 'Pending';
                } else {
                        $status = 'Pass';
                }
                
                $data = array(
                        'end_time' => date("Y-m-d H:i:s"),
                        'total_time' => $totalTime,
                        'score' => $marks,
                        'percentage' => $percentage,
                        'manual_valuation' => $valuation,
                        'status' => $status
                );

                $this->Result->id = $resultId;
                if ($this->Result->save($data)) {
                        foreach ($questionScore as $questionId => $score) {
                                $this->Question->id = $questionId;
                                
                                switch ($score) {
                                        case 0:
                                            $this->Question->saveField('times_unattempted', (int)$this->Question->field('times_unattempted') + 1);
                                            break;
                                        case 1:
                                            $this->Question->saveField('times_corrected', (int)$this->Question->field('times_corrected') + 1);
                                            break;
                                        case 2:
                                            $this->Question->saveField('times_incorrected', (int)$this->Question->field('times_incorrected') + 1);
                                            break;
                                } 
                                $this->Question->saveField('times_served', (int)$this->Question->field('times_served') + 1);
                                
                                $this->Session->delete('Result.id');
                                $this->Session->delete('Application.id');
                                $this->Session->setFlash(__d('croogo', 'Succefully Submitted'), 'default', array('class' => 'success'));
                                $this->set('application', $result['Application']);
                                $this->set('submitted', true);
                                
                        }
                        switch ($status) {
                                case 'Pass':
                                case 'Pending':
                                    $this->sendEmail($resultId);
                                    break;
                        }
                } else {
                        $this->Session->delete('Result.id');
                        $this->Session->delete('Application.id');
                        $this->Session->setFlash(__d('croogo', 'Error Occoured!'), 'default', array('class' => 'error'));
                        $this->set('submitted', false);
                }
        }

/**
 * Send email for passed/pending results 
 * 
 * @param int $resultId
 */
        private function sendEmail($resultId) {
                $result = $this->Result->find('first', array(
                        'conditions' => array('Result.id' => $resultId)
                        )
                    );
                
                $questions = array();
                $join = array();
                $questionId = 0;
                if ($result['Quiz']['question_ids'] !== '') {
                        $questionId = $result['Quiz']['question_ids'];
                        $join['order'] = "FIELD(Question.id, {$result['Quiz']['question_ids']})";
                }
                $join['conditions'] = array("Question.id IN ({$questionId})");
                $questions = $this->Question->find('all', $join);
                
                $hours = 0;
                $minutes = 0;
                $seconds = 0;
                $hours = floor($result['Result']['total_time'] / 3600);
                $minutes = floor(($result['Result']['total_time']/60) % 60);
                $seconds = $result['Result']['total_time'] % 60;
                $duration = $hours .'h'.' '. $minutes .'m'.' '. $seconds .'s'; 
               
                $viewVars = array(
                        'result' => $result,
                        '$questions' => $questions,
                        'duration' => $duration
                    );
                $subject = 'Quiz Result for '. $result['Application']['first_name'] . ' '. $result['Application']['last_name'] .'/'. $result['Result']['status'];
                try {
                        $email = New CakeEmail();
                        $email->from(array('websitesupport@travelfusion.com' => 'Website Support'));
                        $email->template('Recruitment.pass');
                        $email->to('abdulrezak@travelfusion.com');
                        $email->emailFormat('html');
                        $email->subject($subject);
                        $email->viewVars($viewVars);

                        $email->send();
                } catch (SocketException $ex) {
                        $this->log(sprintf('Error sending result notification: %s', $ex->getMessage()));
                }
        }
}

