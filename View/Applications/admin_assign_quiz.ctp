<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Assign Quiz');
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Application'), array('action' => 'index'))
        ->addCrumb(__d('croogo', 'Assign Quiz'), $this->here);

echo $this->Form->create('Application');

?>
<div class="quiz row-fluid">
    <?php if(!empty($quiz)): ?>
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
				echo $this->Form->input('id', array(
                                        'type' => 'hidden',
                                        'value' => $id
                                ));
				echo $this->Form->input('quiz_id', array(
					'options' => $quiz,
				));
				echo $this->Croogo->adminTabs();
			?>
			</div>
		</div>

	</div>

	<div class="span4">
	<?php
		echo $this->Html->beginBox(__d('croogo', 'Publishing')) .
			$this->Form->button(__d('croogo', 'Send Quiz'), array('class' => 'btn btn-primary')) .
			$this->Html->link(__d('croogo', 'Cancel'), array('action' => 'index'), array('class' => 'btn btn-danger')) .
			$this->Html->endBox();
		?>
	</div>
    <?php else: ?>
        <div class="span8">
                <p> 
                    No quiz available.
                    <?php echo $this->Html->link(
                               'Add Quiz',
                                array('controller' => 'quizzes', 'action' => 'index'),
                                array('class' => 'btn btn-primary')
                            ); 
                    ?>
                </p>;
        </div>
    <?php endif; ?>
</div>
<?php echo $this->Form->end(); ?>
