<?php
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Jobs'), h($job['Job']['title']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Jobs'), array('action' => 'index'));
	
?>
<h2 class="hidden-desktop"><?php echo __d('croogo', 'Job'); ?></h2>

<div class="row-fluid">
	<div class="span12 actions">
		<ul class="nav-buttons">
		<li><?php echo $this->Html->link(__d('croogo', 'Edit Job'), array('action' => 'edit', $job['Job']['id']), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Form->postLink(__d('croogo', 'Delete Job'), array('action' => 'delete', $job['Job']['id']), array('button' => 'default'), __d('croogo', 'Are you sure you want to delete # %s?', $job['Job']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Jobs'), array('action' => 'index'), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Job'), array('action' => 'add'), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Applications'), array('controller' => 'applications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Application'), array('controller' => 'applications', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

<div class="jobs view">
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
                        $row[] = array('Id', $job['Job']['id']);
                        $row[] = array('Title', $job['Job']['title']);
                        $row[] = array('Alias', $job['Job']['alias']);
                        $row[] = array('Description', $job['Job']['description']);
                        $row[] = array('Updated', $job['Job']['updated']);
                        $row[] = array('Created', $job['Job']['created']);
                        
                        echo $this->Html->tableCells($row);
                ?>
                
        </table>
</div>
