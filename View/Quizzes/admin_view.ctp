<?php
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Quizzes'), h($quiz['Quiz']['name']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Quizzes'), array('action' => 'index'));
	
?>
<h2 class="hidden-desktop"><?php echo __d('croogo', 'Quiz'); ?></h2>

<div class="row-fluid">
	<div class="span12 actions">
		<ul class="nav-buttons">
		<li><?php echo $this->Html->link(__d('croogo', 'Edit Quiz'), array('action' => 'edit', $quiz['Quiz']['id']), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Form->postLink(__d('croogo', 'Delete Quiz'), array('action' => 'delete', $quiz['Quiz']['id']), array('button' => 'default'), __d('croogo', 'Are you sure you want to delete # %s?', $quiz['Quiz']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Quizzes'), array('action' => 'index'), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Quiz'), array('action' => 'add'), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Results'), array('controller' => 'results', 'action' => 'index')); ?> </li>
		</ul>
	</div>
</div>

<div class="quizzes view">
        <table class="table table-striped">
        <?php
                $tableHeaders = $this->Html->tableHeaders(array(
                        'Title',
                        'Detail'
                ));
        ?>
                <thead>
                <?php echo $tableHeaders; ?>
                </thead>
                <?php 
                        $row = array();
                        $row[] = array('Quiz Name', $quiz['Quiz']['name']);
                        $row[] = array('Description', $quiz['Quiz']['description']);
                        $row[] = array('Start Date', $quiz['Quiz']['start_date']);
                        $row[] = array('End Date', $quiz['Quiz']['end_date']);
                        $row[] = array('No Of Questions', $quiz['Quiz']['no_of_questions']);
                        $row[] = array('Duration (in min.)', $quiz['Quiz']['duration']);
                        $row[] = array('Maximum Attempts Allowed', $quiz['Quiz']['maximum_attempts']);
                        $row[] = array('Minimum Required Pass Percentage', $quiz['Quiz']['created']);
                        $row[] = array('Created', $quiz['Quiz']['created']);
                        $row[] = array('Updated', $quiz['Quiz']['updated']);
                        
                        echo $this->Html->tableCells($row);
                ?>
                
        </table>
</div>
