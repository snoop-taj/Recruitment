<?php
App::uses('RecruitmentAppController', 'Recruitment.Controller');
/**
 * Results Controller
 *
 * @category    Result.Controller
 * @package     Recruitment.Result.Controller
 * @property    Result $Result
 * @version     1.0
 * @author      Zak Taj <info@etechnologia.co.uk>
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/snoop-taj/Recruitment
 */
class ResultsController extends RecruitmentAppController {

/**
 * Models used by Result controller
 * 
 * @var array 
 */    
        public $uses = array(
                'Recruitment.Result',
                'Recruitment.Question'
            );
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
                $showActions = false;
                $this->set('showActions', $showActions);
		$this->Result->recursive = 0;
		$this->set('results', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Result->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid result'));
		}
                
		$options = array('conditions' => array('Result.' . $this->Result->primaryKey => $id));
                $result = $this->Result->find('first', $options);
                
                $questions = array();
                $join = array();
                $questionId = 0;
                if ($result['Quiz']['question_ids'] !== '') {
                        $questionId = $result['Quiz']['question_ids'];
                        $join['order'] = "FIELD(Question.id, {$result['Quiz']['question_ids']})";
                }
                $join['conditions'][] = array("Question.id IN ({$questionId})");
                $questions = $this->Question->find('all', $join);
                
                $hours = 0;
                $minutes = 0;
                $seconds = 0;
                $hours = floor($result['Result']['total_time'] / 3600);
                $minutes = floor(($result['Result']['total_time']/60) % 60);
                $seconds = $result['Result']['total_time'] % 60;
                $duration = $hours .'h'.' '. $minutes .'m'.' '. $seconds .'s'; 
                
		$this->set(compact('result', 'duration', 'questions'));
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
		$this->Result->id = $id;
		if (!$this->Result->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid result'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Result->delete()) {
			$this->Session->setFlash(__d('croogo', 'Result deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Result was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}
        
}
