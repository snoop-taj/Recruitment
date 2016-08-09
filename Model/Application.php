<?php
/**
 * Application Model
 *
 * @category    Application.Model
 * @package     Recruitment.Application.Model
 * @property    Job $Job
 * @version     1.0
 * @author      Zak Taj <info@etechnologia.co.uk>
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/snoop-taj/Recruitment
 */
App::uses('RecruitmentAppModel', 'Recruitment.Model');

class Application extends RecruitmentAppModel {

/**
 * Model name
 *
 * @var string
 * @access public
 */
	public $name = 'Application';
        

/**
 * Uploads cv directory
 *
 * relative to the webroot.
 *
 * @var string
 * @access public
 */
	public $uploadsDir = 'uploads/cv';
        
/**
 * Accepted file extension to upload cv
 * 
 * @var array 
 * @access private
 */
        private $ext = array('pdf', 'doc', 'docx');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'first_name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'required' => true,
			),
                        'validName' => array(
                                'rule' => 'validName',
                                'message' => 'This field must be alphanumeric.',
                                'required' => true,
                        ),
		),
		'last_name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank',
				'required' => true,
			),
                        'validName' => array(
                                'rule' => 'validName',
                                'message' => 'This field must be alphanumeric.',
                                'required' => true,
                        ),
		),
		'email' => array(
			'email' => array(
				'rule' => 'email',
				'message' => 'Please provide a valid email address.',
				'required' => true,
			),
                        'uniqueEmail' => array(
                                'rule' => 'uniqueEmail',
                                'message' => 'Email address have been used within last twelve month'
                        ),
		),
		'job_id' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'required' => true,
			),
		),
                'street_name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'required' => true,
			),
                        'validName' => array(
                                'rule' => 'validName',
                                'message' => 'This field must be alphanumeric.',
                                'required' => true,
                        ),
		),
                'city' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'required' => true,
			),
		),
                'post_code' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'required' => true,
			),
                        'validName' => array(
                                'rule' => 'validName',
                                'message' => 'This field must be alphanumeric.',
                                'required' => true,
                        ),
		),
                'country' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'required' => true,
			),
		),
                'phone' => array(
                        'numeric' => array(
                                'rule' => 'numeric',
                                'required' => true,
                                'message' => 'Please provide a valid phone number'
                                
                        )
                )
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Job' => array(
			'className' => 'Recruitment.Job',
			'foreignKey' => 'job_id'
		),
                'Quiz' => array(
                        'className' => 'Recruitment.Quiz',
                        'foreignKey' => 'quiz_id'
                )
	);
        
        public $hasMany = array(
                'Result' => array(
                        'className' => 'Recruitment.Result',
                        'foreignKey' => 'application_id',
                        'dependent' => true
                ),
                'Answer' => array(
                        'className' => 'Recruitment.Answer',
                        'foreignKey' => 'application_id',
                        'dependent' => true
                )
        );
    
/**
 * beofre save create a unique applicant id
 * 
 * @return array 
 */
        
        public function beforeSave($options = array()) {
            parent::beforeSave($options);
            if (empty($this->data[$this->name]['id'])) {
                    $this->data[$this->name]['id'] = String::uuid();
            }
            return $this->data;
        }
/**
 * Save uploaded file
 *
 * @param array $data data as POSTed from form
 * @return array|boolean false for errors or array containing fields to save
 */
        protected function _saveUploadCvFile($data) {
                $file = $data[$this->name]['curriculum_vitae'];
                unset($data[$this->name]['curriculum_vitae']);

                // check if folder for uploading cv exists
                $pathCv = WWW_ROOT . $this->uploadsDir;
                if (!file_exists($pathCv)) {
                        mkdir($pathCv, 0777, true);
                }
                
                // check if file with same path exists
                $Job = ClassRegistry::init('Recruitment.Job');
                
                $jobTitle = $Job->getJobTitle($data[$this->name]['job_id']);
                $firstName = ucfirst($data[$this->name]['first_name']);
                $lastName = ucfirst($data[$this->name]['last_name']);
                $fileName = $file['name'];
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $newName = $firstName.'_'.$lastName.'_'.$jobTitle.'.'.$ext;
                $destination = $pathCv . DS . $newName;
                
                if (file_exists($destination)) {
                        $newName = String::uuid() . '_' . $newName;
                        $destination = $pathCv . DS . $newName;
                }
                
                $data[$this->name]['curriculum_vitae'] = $newName;
                $data[$this->name]['curriculum_vitae_path'] = '/' . $this->uploadsDir . '/' . $newName;
                $data[$this->name]['curriculum_vitae_type'] = $file['type'];
                
                // move the file to cv directory
                $moved = move_uploaded_file($file['tmp_name'], $destination);
                if ($moved) {
                        return $data;
                }
                
                return false;
        }
        
/**
 * Saves model data
 *
 * @see Model::save()
 * @return boolean
 */
	public function save($data = null, $validate = true, $fieldList = array()) {
                if (isset($data[$this->name]['curriculum_vitae']['tmp_name'])
                        && !empty($data[$this->name]['curriculum_vitae']['tmp_name'])
                        && $this->_checkFileExtension($data[$this->name]['curriculum_vitae']['name'])) {
                        $data = $this->_saveUploadCvFile($data);
                } elseif (isset($data[$this->name]['curriculum_vitae']['tmp_name'])
                        && empty($data[$this->name]['curriculum_vitae']['tmp_name'])) {
                        return $this->invalidate('curriculum_vitae', __d('croogo', 'Please use the correct file ext ' . implode(",", $this->ext)));
                }
                
                if (!$data) {
                        return $this->invalidate('curriculum_vitae', __d('croogo', 'Error during file upload'));
                }

                if (parent::save($data, $validate, $fieldList)) {
                        return $this->id;
                }
                return false;
        }

/**
 * Check that value has a valid file extension.
 *
 * @param string|array $check Value to check
 * @return boolean Success
 */
        private function _checkFileExtension($check) {
                $extension = strtolower(pathinfo($check, PATHINFO_EXTENSION));  
		foreach ($this->ext as $value) {
			if ($extension === strtolower($value)) {
				return true;
			}
		}
                return false;
        }

/**
 * Delete applicant and cv file
 * 
 * @param string $id
 * @param boolean $cascade
 * @return boolean
 */
        public function delete($id = null, $cascade = true) {
                
                $file = $this->read('curriculum_vitae', $id);
                $fullPath = WWW_ROOT . $this->uploadsDir . DS . $file['Application']['curriculum_vitae'];

                if (file_exists($fullPath)) {
                        $result = unlink($fullPath);
                        if ($result) {
                                return parent::delete($id, $cascade);
                        } else {
                                return false;
                        }
                } else {
                        return parent::delete($id, $cascade);
                }
        }

/**
 * Custome validation email used to apply within last twelve month
 * 
 * @return boolean
 */
        public function uniqueEmail() {
            
                $data = $this->find('first', array(
                    'conditions' => array('Application.email' => $this->data['Application']['email']),
                    'fields' => array('Application.email', 'Application.created')
                    )
                ); 
                
                if ($data) {
                    $startDate = strtotime($data['Application']['created']);
                    $now = strtotime(date('Y-m-d H:i:s'));
                    $countMonths = abs((date('Y', $now) - date('Y', $startDate)) * 12 + (date('m', $now) - date('m', $startDate)));
                    if ($countMonths <= 12) {
                            return false;
                    }
                }
                
                return true;
        }
}
