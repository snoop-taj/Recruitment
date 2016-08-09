<?php
/**
 * Jobs Controller
 * 
 * @category    Jobs.Controller
 * @package     Recruitment.Jobs.Controller
 * @property    Job $Job
 * @version     1.0
 * @author      Zak Taj <info@etechnologia.co.uk>
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/snoop-taj/Recruitment
 */
App::uses('RecruitmentAppController', 'Recruitment.Controller');

class JobsController extends RecruitmentAppController {

/**
 * Controller name
 * 
 * @var string 
 */
    
        public $name = 'Jobs';

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Job->recursive = 0;
		$this->set('jobs', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Job->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid job'));
		}
		$options = array('conditions' => array('Job.' . $this->Job->primaryKey => $id));
		$this->set('job', $this->Job->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Job->create();
			if ($this->Job->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The job has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The job could not be saved. Please, try again.'), 'default', array('class' => 'error'));
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
		if (!$this->Job->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid job'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Job->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The job has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The job could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Job.' . $this->Job->primaryKey => $id));
			$this->request->data = $this->Job->find('first', $options);
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
		$this->Job->id = $id;
		if (!$this->Job->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid job'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Job->delete()) {
			$this->Session->setFlash(__d('croogo', 'Job deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Job was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}
}
