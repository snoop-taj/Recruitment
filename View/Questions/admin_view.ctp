<?php
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Questions'), h($question['Question']['id']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Questions'), array('action' => 'index'));
	
?>
<h2 class="hidden-desktop"><?php echo __d('croogo', 'Question'); ?></h2>

<div class="row-fluid">
	<div class="span12 actions">
		<ul class="nav-buttons">
		<li><?php echo $this->Html->link(__d('croogo', 'Edit Question'), array('action' => 'edit', $question['Question']['id']), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Form->postLink(__d('croogo', 'Delete Question'), array('action' => 'delete', $question['Question']['id']), array('button' => 'default'), __d('croogo', 'Are you sure you want to delete # %s?', $question['Question']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Questions'), array('action' => 'index'), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Question'), array('action' => 'add'), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Results'), array('controller' => 'results', 'action' => 'index')); ?> </li>
		</ul>
	</div>
</div>

<div class="questions view">
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
                        $row[] = array('Id', $question['Question']['id']);
                        $row[] = array('Type', $question['Question']['type']);
                        $row[] = array('Question', $question['Question']['question']);
                        $row[] = array('Times Served', $question['Question']['times_served']);
                        $row[] = array('Times Corrected', $question['Question']['times_corrected']);
                        $row[] = array('Times Incorrected', $question['Question']['times_incorrected']);
                        $row[] = array('Times Unattempted', $question['Question']['times_unattempted']);
                        $row[] = array('Created', $question['Question']['created']);
                        $row[] = array('Updated', $question['Question']['updated']);
                        
                        echo $this->Html->tableCells($row);
                ?>
                
        </table>
</div>
