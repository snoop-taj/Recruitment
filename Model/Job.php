<?php
/**
 * Job Model
 *
 * @category    Job.Model
 * @package     Recruitment.Job.Model
 * @property    Application $Application
 * @version     1.0
 * @author      Zak Taj <info@etechnologia.co.uk>
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/snoop-taj/Recruitment
 */
App::uses('RecruitmentAppModel', 'Recruitment.Model');

class Job extends RecruitmentAppModel {

/**
 * Model name
 *
 * @var string
 * @access public
 */
	public $name = 'Job';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'title' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Title cannot be empty',
				'required' => true,
			),
                        'validName' => array(
                                'rule' => 'validName',
                                'message' => 'This field must be alphanumeric',
                                'required' => true,
                        ),
		),
		'alias' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
                                'message' => 'Alias cannot be empty',
				'required' => true,
			),
                        'isUnique' => array(
                                'rule' => 'isUnique',
                                'message' => 'This alias has already been taken.',
                                'required' => true,
                        ),
                        'validAlias' => array(
                                'rule' => 'validAlias',
                                'message' => 'This field must be alphanumeric',
                                'required' => true,
                        ),
		),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Application' => array(
			'className' => 'Recruitment.Application',
			'foreignKey' => 'job_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
        
/**
 * Display fields for this model
 *
 * @var array
 */
	protected $_displayFields = array(
		'id',
		'title',
		'alias',
		'description',
	);
        
/**
 * Get job alias by id
 *
 * @var int
 * @return string
 */        
        public function getJobAlias($id) {
                $job = $this->findById($id);
                return $job['Job']['alias'];
        }
        
/**
 * Get job title by id
 *
 * @var int
 * @return string
 */        
        public function getJobTitle($id) {
                $job = $this->findById($id);
                return ucfirst($job['Job']['title']);
        }

}
