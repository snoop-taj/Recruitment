<?php
/**
 * Applications Controller
 *
 * @category    Applications.Controller
 * @package     Recruitment.Applications.Controller
 * @property    Application $Application
 * @version     1.0
 * @author      Zak Taj <info@etechnologia.co.uk>
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/snoop-taj/Recruitment
 */
App::uses('CakeEmail', 'Network/Email');
App::uses('RecruitmentAppController', 'Recruitment.Controller');

class ApplicationsController extends RecruitmentAppController {

/**
 * Controller name
 *
 * @var string
 * @access public
 */
        public $name = 'Applications';

/**
 * Models used by the Controller
 *
 * @var array
 * @access public
 */
//        public $uses = array('Recruitment.Job');
/**
 * Default settings
 * 
 * @var array
 * @access protected
 */        
        protected $default = array();
        
/**
 * Settings plugin model
 * 
 * @var Setting
 * @access private
 */
        private $settings = null;
/**
 * Helpers
 * 
 * @var array
 * @access public
 */
        public $helpers = array(
		'Html' => array(
			'className' => 'Croogo.CroogoHtml',
		),
	);
        
        public $uses = array(
                'Recruitment.Application',
                'Recruitment.Quiz'
        );

/**
 * Constructor to register settings
 */
        public function __construct($request = null, $response = null) {
                $this->settings = ClassRegistry::init('Setting');
//                $this->settings->useDbConfig = 'test';
                parent::__construct($request, $response);
        }

/**
 * Initiallized before Controller action
 * 
 * @return void 
 */
        public function beforeFilter() {
                parent::beforeFilter();
                $this->Security->unlockedActions[] = 'apply';
                $default = $this->settings->find(
                        'all', array(
                            'conditions' => array(
                                'Setting.key LIKE' => 'Applications%'
                                ), 
                            'fields' => array('Setting.id', 'Setting.value', 'Setting.key')
                            )
                        ); 

                foreach ($default as $settings) {
                        $key = explode('.', $settings['Setting']['key']);
                        $this->default[$key[1]] = $settings['Setting'];
                }           
                $this->Auth->allow( 'apply');
        }

/**
 * apply method
 *
 * @return void
 */
	public function apply() {
		if ($this->request->is('post')) {
			$this->Application->create(); 
                        $this->Application->data = $this->request->data;
                        if ($this->Application->validates()) {
                                if ($id = $this->Application->save($this->request->data)) {
                                        $this->_sendEmail($this->request->data);
                                        $options = array('conditions' => array('Application.' . $this->Application->primaryKey => $id));
                                        $data = $this->Application->find('first', $options);
                                        $this->_sendNotification($data);
                                        $this->Session->setFlash(__d('croogo', 'Thank you! Your application has been sent'), 'default', array('class' => 'success'));
                                        $this->redirect(array('action' => 'apply'));
                                } else {
                                    $this->Session->setFlash(__d('croogo', 'The application could not be sent. Please, try again.'), 'default', array('class' => 'error'));
                                }
			} else {
				$this->Session->setFlash(__d('croogo', 'The application could not be sent. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		$jobs = $this->Application->Job->find('list');
		$this->set(compact('jobs'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Application->recursive = 0;
		$this->set('applications', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Application->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid application'));
		}
		$options = array('conditions' => array('Application.' . $this->Application->primaryKey => $id));
		$this->set('application', $this->Application->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {

			$this->Application->create();
			if ($this->Application->save($this->request->data)) {
                                $this->_sendEmail($this->request->data);
				$this->Session->setFlash(__d('croogo', 'The application has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The application could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		$jobs = $this->Application->Job->find('list');
		$this->set(compact('jobs'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Application->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid application'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Application->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The application has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The application could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Application.' . $this->Application->primaryKey => $id));
			$this->request->data = $this->Application->find('first', $options);
		}
		$jobs = $this->Application->Job->find('list');
		$this->set(compact('jobs'));
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
		$this->Application->id = $id;
		if (!$this->Application->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid application'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Application->delete()) {
			$this->Session->setFlash(__d('croogo', 'Application deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Application was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * Decline application and send email
 * 
 * @param string $id
 * @throws NotFoundException
 */
        public function admin_decline($id = null) {
                $this->Application->id = $id;
                if (!$this->Application->exists()) {
                        throw new NotFoundException(__d('croogo', 'Invalid application'));
                }
                
                $data['Application'] = array(
                    'id' => $id,
                    'decline' => 1
                );
                if ($this->Application->save($data, false)) {
                        $options = array('conditions' => array('Application.' . $this->Application->primaryKey => $id));
                        $data = $this->Application->find('first', $options);
                        $this->_sendDecline($data);
                        $this->Session->setFlash(__d('croogo', 'Applicant '. $data['Application']['first_name'] .' '. $data['Application']['last_name'] .' Declined Successfully'), 'default', array('class' => 'success'));
                        $this->redirect(array('action' => 'index'));
                } else {
                        $this->Session->setFlash(__d('croogo', 'Error occured! Applicant not delined '), 'default', array('class' => 'error'));
                }
        }

/**
 * Accept application
 * 
 * @param string $id
 * @throws NotFoundException
 */
        public function admin_accept($id = null) {
                $this->Application->id = $id;
                if (!$this->Application->exists()) {
                        throw new NotFoundException(__d('croogo', 'Invalid application'));
                }
                
                $data['Application'] = array(
                    'id' => $id,
                    'accept' => 1
                );
                if ($this->Application->save($data, false)) {
                        $options = array('conditions' => array('Application.' . $this->Application->primaryKey => $id));
                        $data = $this->Application->find('first', $options);
                        $this->Session->setFlash(__d('croogo', 'Applicant '. $data['Application']['first_name'] .' '. $data['Application']['last_name'] .' Accepted Successfully'), 'default', array('class' => 'success'));
                        $this->redirect(array('action' => 'index'));
                } else {
                        $this->Session->setFlash(__d('croogo', 'Error occured! Applicant not accepted '), 'default', array('class' => 'error'));
                }
        }
        
/**
 * Add application settings
 * 
 * @return void
 * @access public
 */
        
        public function admin_settings() {
                $this->set('title_for_layout', __d('croogo', 'Recruitment Settings'));
                
                if (!empty($this->data)) { 

                        foreach ($this->data as $key => $setting) {
                                $this->settings->id = $setting['id'];
                                $this->settings->saveField('value', $setting['value'], true);
                                $this->settings->saveField('key', $setting['key']);
                        }
                        $this->Session->setFlash(__d('croogo', 'Recruitment settings has been saved'), 'default', array('class' => 'success'));
                        $this->redirect(array('action' => 'settings'));
                }
                $this->set('settings', $this->default);
        }

/**
 * Assign quiz to applicant and send email
 * 
 * @param int $id
 * @throws NotFoundException
 */
        public function admin_assign_quiz($id = null) {
                $this->Application->id = $id;
		if (!$this->Application->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid application'));
		}
                if ($this->request->is('post')) {
                        if ($this->Application->save($this->request->data, false)) {
                                $data = array();
                                $options = array('conditions' => array('Application.' . $this->Application->primaryKey => $id));
                                $data = $this->Application->find('first', $options);
                                $this->_sendQuiz($data);
                                $this->Session->setFlash(__d('croogo', 'Quiz assigned and sent to Applicant '. $data['Application']['first_name'] .' '. $data['Application']['last_name']), 'default', array('class' => 'success'));
                                $this->redirect(array('action' => 'index'));
                        } else {
                                $this->Session->setFlash(__d('croogo', 'Quiz is not assigned '), 'default', array('class' => 'error'));
                        }
                }
                $this->set('quiz', $this->Quiz->find('list'));
                $this->set('id', $id);
        }
/**
 * send Quiz to applicant
 * 
 * @param array $data
 * @param string $subPrefix
 * @param string $template
 */        
        private function _sendQuiz($data, $subPrefix = 'Quiz', $template= 'quiz') {
                $this->_sendEmail($data, $subPrefix, $template);
        }
        
/**
 * send Notification to internal user about new applicant
 * 
 * @param array|string $data
 * @param string $subPrefix
 * @param string $template
 */
        private function _sendNotification($data, $subPrefix = 'Notification', $template= 'notification') {
                
                $from = array($this->default['websupport']['value'] => 'Website Support');
                $to = array($this->default['notification']['value'] => 'TravelFusion Notification');
                
                $this->_sendEmail($data, $subPrefix, $template, $from, $to);
        }
        
        private function _sendDecline($data, $subPrefix = 'Application', $template = 'decline') {
                $this->_sendEmail($data, $subPrefix, $template);
        }
/**
 * sendEmail
 *
 * @param array $application Application data
 * @return void
 * @access private
 */
        private function _sendEmail($data, $subPrefix = 'Application', $template = 'application', $from = null, $to = null) {
                try {
                        $jobId = $data['Application']['job_id'];
                        $jobTitle = $this->Application->Job->getJobTitle($jobId);
                        $now = New DateTime();
                        
                        if (is_null($from)) {
                                $from = array($this->default['hr']['value'] => 'TravelFusion HR');
                        }
                        if (is_null($to)) {
                                $to = array($data['Application']['email'] => $data['Application']['first_name'] . ' '. $data['Application']['last_name']);
                        }
                        
                        switch ($template) {
                                case 'decline' :
                                    $subject = $subPrefix .' for '. $jobTitle . ' Position Status';
                                    break;
                                default :
                                    $subject = $subPrefix .' for '. $jobTitle . ' Position - '. $now->format('Y-m-d');
                        }
                        
                        $viewVars = array(
                                'data' => $data, 
                                'date' => $now->format('Y-m-d'),
                                'jobTitle' => $jobTitle,
                            );

                        $email = new CakeEmail();
                        $email->from($from);
                        $email->template('Recruitment.'.$template);
                        $email->to($to);
                        $email->emailFormat('html');
                        $email->subject($subject);
                        $email->viewVars($viewVars);
                        
                        $email->send();

                } catch (SocketException $ex) {
                        $this->log(sprintf('Error sending application notification: %s', $ex->getMessage()));
                }
        }
}
