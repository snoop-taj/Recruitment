<?php
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Categories'), h($category['Category']['name']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Categories'), array('action' => 'index'));
	
?>
<h2 class="hidden-desktop"><?php echo __d('croogo', 'Category'); ?></h2>

<div class="row-fluid">
	<div class="span12 actions">
		<ul class="nav-buttons">
		<li><?php echo $this->Html->link(__d('croogo', 'Edit Category'), array('action' => 'edit', $category['Category']['id']), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Form->postLink(__d('croogo', 'Delete Category'), array('action' => 'delete', $category['Category']['id']), array('button' => 'default'), __d('croogo', 'Are you sure you want to delete # %s?', $category['Category']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Categories'), array('action' => 'index'), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Category'), array('action' => 'add'), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

<div class="categories view">
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
                        $row[] = array('Id', $category['Category']['id']);
                        $row[] = array('Name', $category['Category']['name']);
                        $row[] = array('Created', $category['Category']['created']);
                        $row[] = array('Updated', $category['Category']['updated']);
                        
                        echo $this->Html->tableCells($row);
                ?>
                
        </table>
</div>
