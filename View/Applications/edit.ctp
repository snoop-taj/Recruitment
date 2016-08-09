<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Applications');
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Applications'), array('action' => 'index'));

if ($this->action == 'admin_edit') {
	$this->Html->addCrumb($this->data['Application']['id'], $this->here);
	$this->viewVars['title_for_layout'] = 'Applications: ' . $this->data['Application']['id'];
} else {
	$this->Html->addCrumb(__d('croogo', 'Add'), $this->here);
}

echo $this->Form->create('Application');

?>
<div class="applications row-fluid">
	<div class="span8">
		<ul class="nav nav-tabs">
		<?php
			echo $this->Croogo->adminTab(__d('croogo', 'Application'), '#application');
			echo $this->Croogo->adminTabs();
		?>
		</ul>

		<div class="tab-content">
			<div id='application' class="tab-pane">
			<?php
				echo $this->Form->input('id');
				$this->Form->inputDefaults(array('label' => false, 'class' => 'span10'));
				echo $this->Form->input('first_name', array(
					'label' => 'First Name',
				));
				echo $this->Form->input('last_name', array(
					'label' => 'Last Name',
				));
				echo $this->Form->input('email', array(
					'label' => 'Email',
				));
				echo $this->Form->input('job_id', array(
					'label' => 'Job Id',
				));
				echo $this->Form->input('curriculum_vitae', array(
					'label' => 'Curriculum Vitae',
				));
				echo $this->Form->input('cover_letter', array(
					'label' => 'Cover Letter',
				));
				echo $this->Croogo->adminTabs();
			?>
			</div>
		</div>

	</div>

	<div class="span4">
	<?php
		echo $this->Html->beginBox(__d('croogo', 'Publishing')) .
			$this->Form->button(__d('croogo', 'Apply'), array('name' => 'apply')) .
			$this->Form->button(__d('croogo', 'Save'), array('class' => 'btn btn-primary')) .
			$this->Html->link(__d('croogo', 'Cancel'), array('action' => 'index'), array('class' => 'btn btn-danger')) .
			$this->Html->endBox();
		?>
	</div>

</div>
<?php echo $this->Form->end(); ?>
