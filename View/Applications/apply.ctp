<?php
echo $this->Html->css(array(
        '/croogo/css/croogo-bootstrap',
        '/croogo/css/croogo-bootstrap-responsive',
        '/croogo/css/thickbox',
        '/recruitment/css/fix'
));
//echo $this->Layout->js();
		echo $this->Html->script(array(
//			'/croogo/js/croogo-bootstrap.js',
		));
//                
//$this->viewVars['title_for_layout'] = __d('croogo', 'Job Application');
//$this->extend('/Common/admin_edit');

//$this->Html
//	->addCrumb('', '/', array('icon' => 'home'))
//	->addCrumb(__d('croogo', 'Apply'), array('action' => 'apply'));

echo $this->Form->create('Application', array('type' => 'file'));

?>
<div class="applications row-fluid">
	<div class="span8">
		<!--<ul class="nav nav-tabs">-->
		<?php
//			echo $this->Croogo->adminTab(__d('croogo', 'Application'), '#application');
//			echo $this->Croogo->adminTabs();
		?>
		<!--</ul>-->

		<div class="tab-content">
			<div id='application' class="tab-pane active">
			<?php
				echo $this->Form->input('id');
				$this->Form->inputDefaults(array('label' => false, 'class' => 'span10'));
				echo $this->Form->input('first_name', array(
					'label' => 'First Name',
                                        'div' => 'input inline span5',
				));
				echo $this->Form->input('last_name', array(
					'label' => 'Last Name',
                                        'div' => 'input inline span5',
				));
                                echo $this->Form->input('job_id', array(
					'label' => 'Job Title',
                                        'div' => 'input inline span5',
				));
                                echo $this->Form->input('email', array(
					'label' => 'Email',
                                        'div' => 'input inline span5',
				));
                                echo $this->Form->input('street_name', array(
					'label' => 'Street Name',
                                        'div' => 'input inline span5',
				));
                                echo $this->Form->input('city', array(
					'label' => 'City',
                                        'div' => 'input inline span5',
				));
                                echo $this->Form->input('post_code', array(
					'label' => 'Post Code',
                                        'div' => 'input inline span5',
				));
                                echo $this->Form->input('country', array(
					'label' => 'Country',
                                        'div' => 'input inline span5',
				));
                                echo $this->Form->input('phone', array(
					'label' => 'Phone',
                                        'div' => 'input inline span5',
				));
				echo $this->Form->input('additional_info', array(
					'label' => 'Additional Info',
                                        'div' => 'input inline span5',
				));
                                echo $this->Form->input('curriculum_vitae', array(
					'label' => 'Curriculum Vitae', 
                                        'type' => 'file',
                                        'div' => 'input inline span5',
				));
				echo $this->Croogo->adminTabs();
			?>
			</div>
		</div>

	</div>

	<div class="span4">
	<?php
		echo $this->Html->beginBox(__d('croogo', 'Apply')) .
			$this->Form->button(__d('croogo', 'Send'), array('class' => 'btn btn-primary')) .
			$this->Html->link(__d('croogo', 'Cancel'), '/page/careers', array('class' => 'btn btn-danger')) .
			$this->Html->endBox();
		?>
	</div>

</div>
<?php echo $this->Form->end(); ?>
