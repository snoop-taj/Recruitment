<?php
/**
 * Category Model
 *
 * @category    Category.Model
 * @package     Recruitment.Category.Model
 * @property    Question $Question
 * @version     1.0
 * @author      Zak Taj <info@etechnologia.co.uk>
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/snoop-taj/Recruitment
 */
App::uses('RecruitmentAppModel', 'Recruitment.Model');

class Category extends RecruitmentAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Category name is required',
				'allowEmpty' => false,
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
		'Question' => array(
			'className' => 'Recruitment.Question',
			'foreignKey' => 'category_id',
			'dependent' => false
		)
	);

}
