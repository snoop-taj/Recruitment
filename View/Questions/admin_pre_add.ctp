<?php
echo $this->Html->script(array(
        '/recruitment/js/basic',
    )
);
$this->viewVars['title_for_layout'] = __d('croogo', 'Step 1');
//$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Questions'), array('action' => 'index'));

//if ($this->action == 'admin_edit') {
//	$this->Html->addCrumb($this->data['Question']['id'], $this->here);
//	$this->viewVars['title_for_layout'] = 'Questions: ' . $this->data['Question']['id'];
//} else {
	$this->Html->addCrumb(__d('croogo', 'Pre Add'), $this->here);
//}

echo $this->Form->create('Question');

?>
<div class="questions row-fluid">
	<div class="span8">
		<ul class="nav nav-tabs">
		<?php
			echo $this->Croogo->adminTab(__d('croogo', 'Pre Add'), '#question');
			echo $this->Croogo->adminTabs();
		?>
		</ul>

		<div class="tab-content">
			<div id='question' class="tab-pane">
			<?php
//				echo $this->Form->input('id');
				$this->Form->inputDefaults(array('label' => false, 'class' => 'span10'));
				echo $this->Form->input('question_type', array(
					'label' => 'Select question type',
                                        'options' => array(
                                                'single' => 'Single Answer with Multiple Choice',
                                                'multiple' => 'Multiple Answer with Multiple Choice',
                                                'short' => 'Short Answer',
                                                'long' => 'Long Answer'
                                        ),
                                        'onchange' => 'hide_option(this.value);'
				));
                                
                                echo $this->Form->input('no_of_options', array(
                                        'label' => 'Number of Options',
                                        'type' => 'number'
                                ));
				
				echo $this->Croogo->adminTabs();
			?>
			</div>
		</div>

	</div>

	<div class="span4">
	<?php
		echo $this->Html->beginBox(__d('croogo', 'Publishing')) .
			$this->Form->button(__d('croogo', 'Next'), array('class' => 'btn btn-primary')) .
			$this->Html->link(__d('croogo', 'Cancel'), array('action' => 'index'), array('class' => 'btn btn-danger')) .
			$this->Html->endBox();
		?>
	</div>

</div>
<?php echo $this->Form->end(); ?>
