<?php
/**
 * Questions Controller
 *
 * @category    Questions.Controller
 * @package     Recruitment.Questions.Controller
 * @property    Question $Question
 * @version     1.0
 * @author      Zak Taj <info@etechnologia.co.uk>
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/snoop-taj/Recruitment
 */
App::uses('RecruitmentAppController', 'Recruitment.Controller');

class QuestionsController extends RecruitmentAppController {
    
/**
 * Helpers
 *
 * @var array
 * @access public
 */    
        public $helpers = array(
		'Croogo.Layout',
	);

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
                $showActions = false;
                $this->set('showActions', $showActions);
		$this->Question->recursive = 0;
		$this->set('questions', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Question->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid question'));
		}
		$options = array('conditions' => array('Question.' . $this->Question->primaryKey => $id));
		$this->set('question', $this->Question->find('first', $options));
	}
        
/**
 * admin_pre_add method
 * 
 * @return void
 */
        public function admin_pre_add() {
                if ($this->request->is('post')) {
                        $no_of_options = (int)$this->request->data('Question.no_of_options');
                        $question_type = $this->request->data('Question.question_type');
                        if (in_array($question_type, array('single', 'multiple'))) {
                                if (!empty($no_of_options) && $no_of_options >= 1 ) {
                                        if ($no_of_options >= 2) {
                                                $this->redirect(array(
                                                            'action'=> 'add',
                                                            $question_type,
                                                            $no_of_options
                                                        )
                                                    );
                                        } else {
                                            $this->Session->setFlash(__d('croogo', 'Add 2 or more option'));
                                        }
                                } else {
                                        $this->Session->setFlash(__d('croogo', 'Please add number of options'), 'default', array('class' => 'error'));
                                }
                        } else {
                            $this->redirect(array(
                                        'action'=> 'add',
                                        $question_type
                                    )
                                );
                        }
                }
        }

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add($quesiton_type = null, $no_of_options = 4) {

                switch ($quesiton_type) {
                        case 'multiple' :
                            $elem = 'add_multiple';
                            $type = 'Multiple Answer with Multiple Choice';
                            break;
                        case 'short' :
                            $elem = 'add_short';
                            $type = 'Short Answer';
                            break;
                        case 'long' :
                            $elem = 'add_long';
                            $type = 'Long Answer';
                            break;
                        default :
                            $elem = 'add_single';
                            $type = 'Single Answer with Multiple Choice';
                                
                }

		if ($this->request->is('post')) {
			$this->Question->create();
                        $this->request->data('Question.question_type', $quesiton_type);
                        $this->request->data('Question.type', $type);
			if ($this->Question->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The question has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The question could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
                $category_list = $this->Question->Category->find('list');
                $this->set(compact('no_of_options', 'category_list', 'elem'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Question->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid question'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Question->edit($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The question has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The question could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Question.' . $this->Question->primaryKey => $id));
			$this->request->data = $this->Question->find('first', $options);
                        
                        switch($this->request->data['Question']['type']) {
                                case 'Multiple Answer with Multiple Choice' :
                                    $elem = 'edit_multiple';
                                    break;
                                case 'Short Answer' :
                                    $elem = 'edit_short';
                                    break;
                                case 'Long Answer' :
                                    $elem = 'edit_long';
                                    break;
                                    default :
                                    $elem = 'edit_single';
                        }
                        $this->set(compact('elem'));
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
		$this->Question->id = $id;
		if (!$this->Question->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid question'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Question->delete()) {
			$this->Session->setFlash(__d('croogo', 'Question deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Question was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}
}
