<?php
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Applications'), h($application['Application']['id']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Applications'), array('action' => 'index'));
	
?>
<h2 class="hidden-desktop"><?php echo __d('croogo', 'Application'); ?></h2>

<div class="row-fluid">
	<div class="span12 actions">
		<ul class="nav-buttons">
		<!--<li><?php // echo $this->Html->link(__d('croogo', 'Edit Application'), array('action' => 'edit', $application['Application']['id']), array('button' => 'default')); ?> </li>-->
		<!--<li><?php // echo $this->Form->postLink(__d('croogo', 'Delete Application'), array('action' => 'delete', $application['Application']['id']), array('button' => 'default'), __d('croogo', 'Are you sure you want to delete # %s?', $application['Application']['id'])); ?> </li>-->
		<li><?php echo $this->Html->link(__d('croogo', 'List Applications'), array('action' => 'index'), array('button' => 'default')); ?> </li>
		<!--<li><?php // echo $this->Html->link(__d('croogo', 'New Application'), array('action' => 'add'), array('button' => 'default')); ?> </li>-->
		<li><?php echo $this->Html->link(__d('croogo', 'List Jobs'), array('controller' => 'jobs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Job'), array('controller' => 'jobs', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

<div class="applications view">
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
                        $job = $this->Html->link($application['Job']['title'], array('controller' => 'jobs', 'action' => 'view', $application['Job']['id']));
                        $cv = $this->Html->link(
                                $this->Html->url($application['Application']['curriculum_vitae_path'], true),
                                $application['Application']['curriculum_vitae_path'], 
                                array(
                                        'target' => '_blank',
                                ) 
                        ); 
                        $row[] = array('Id', $application['Application']['id']);
                        $row[] = array('First Name', $application['Application']['first_name']);
                        $row[] = array('Last Name', $application['Application']['last_name']);
                        $row[] = array('Email', $application['Application']['email']);
                        $row[] = array('Job', $job);
                        $row[] = array('Street Name', $application['Application']['street_name']);
                        $row[] = array('City', $application['Application']['city']);
                        $row[] = array('Post Code', $application['Application']['post_code']);
                        $row[] = array('Country', $application['Application']['country']);
                        $row[] = array('Phone', $application['Application']['phone']);
                        $row[] = array('Curriculum Vitae', $cv);
                        $row[] = array('Additional Info', $application['Application']['additional_info']);
                        $row[] = array('Updated', $application['Application']['updated']);
                        $row[] = array('Created', $application['Application']['created']);
                        
                        echo $this->Html->tableCells($row);
                ?>
        </table>
</div>
