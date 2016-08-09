<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Quizzes');
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Quizzes'), array('action' => 'index'));

if ($this->action == 'admin_edit') {
	$this->Html->addCrumb($this->data['Quiz']['name'], $this->here);
	$this->viewVars['title_for_layout'] = 'Quizzes: ' . $this->data['Quiz']['name'];
} else {
	$this->Html->addCrumb(__d('croogo', 'Add'), $this->here);
}

echo $this->Form->create('Quiz');

?>
<div class="quizzes row-fluid">
	<div class="span8">
		<ul class="nav nav-tabs">
		<?php
			echo $this->Croogo->adminTab(__d('croogo', 'Quiz'), '#quiz');
			echo $this->Croogo->adminTabs();
		?>
		</ul>

		<div class="tab-content">
			<div id='quiz' class="tab-pane">
			<?php
				echo $this->Form->input('id');
				$this->Form->inputDefaults(array('label' => false, 'class' => 'span10'));
				echo $this->Form->input('name', array(
					'label' => 'Quiz Name',
				));
				echo $this->Form->input('description', array(
					'label' => 'Description',
				));
				echo $this->Form->input('start_date', array(
					'label' => 'Start Date',
				));
				echo $this->Form->input('end_date', array(
					'label' => 'End Date',
				));
				echo $this->Form->input('duration', array(
					'label' => 'Duration (in min.)',
				));
				echo $this->Form->input('maximum_attempts', array(
					'label' => 'Maximum Attempts Allowed',
				));
				echo $this->Form->input('pass_percentage', array(
					'label' => 'Minimum Required Pass Percentage',
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
