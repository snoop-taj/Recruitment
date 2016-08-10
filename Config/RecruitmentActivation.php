<?php
/**
 * Recritment Activation
 *
 * Activation class for Recritment plugin.
 *
 * @category    Recruitment.Activation
 * @package     Recruitment.Recrutiment.Activation
 * @author      Zak Taj <info@etechnologia.com>
 * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/snoop-taj/Recruitment
 */
class RecruitmentActivation {
        
        private $db;
        
        public function __construct() {
            
                $this->db = ConnectionManager::getDataSource('default');
        }
/**
 * onActivate will be called if this returns true
 *
 * @param  object $controller Controller
 * @return boolean
 */
	public function beforeActivation(&$controller) {
            
                    return true;
	}

/**
 * Called after activating the plugin in ExtensionsPluginsController::admin_toggle()
 *
 * @param object $controller Controller
 * @return void
 */
	public function onActivation(&$controller) { 
            
                $controller->Setting->write('Applications.hr','Enter HR Email Address',array('description' => 'Default hr email address of the applications','editable' => 1));
                $controller->Setting->write('Applications.notification','Enter Notification Email Address',array('description' => 'Default notification email address of the applications','editable' => 1));
                $controller->Setting->write('Applications.websupport','Enter WebSupport Email Address',array('description' => 'Default website support email address of the applications','editable' => 1));
                
                if (!$this->db->isConnected()) {
                        throw new PDOException('Could not connect to database');
                } else {
                        App::import('Model', 'CakeSchema');
                        $options = array('plugin' => 'Recruitment', 'name' => 'Recruitment');
                        $schema = new CakeSchema($options);
                        $schema = $schema->load();
                        try{
                                foreach ($schema->tables as $table => $fields) {
                                        $create = $this->db->createSchema($schema, $table);
                                        $this->db->execute($create);
                                }
                        } catch (PDOException $ex) {
                            CakeLog::error(sprintf('Recruitment Activation Database Error : %s', $ex->getMessage()));
                        }
                }
	}

/**
 * onDeactivate will be called if this returns true
 *
 * @param  object $controller Controller
 * @return boolean
 */
	public function beforeDeactivation(&$controller) {
		return true;
	}

/**
 * Called after deactivating the plugin in ExtensionsPluginsController::admin_toggle()
 *
 * @param object $controller Controller
 * @return void
 */
	public function onDeactivation(&$controller) {

	}
}
