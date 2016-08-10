<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Results');
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Results'), array('action' => 'index'));

?>

<div class="results index">
	<table class="table table-striped">
	<tr>
		<th><?php echo $this->Paginator->sort('id', '#'); ?></th>
		<th><?php echo $this->Paginator->sort('application_first_name', 'Applicant Name'); ?></th>
		<th><?php echo $this->Paginator->sort('quiz_id', 'Quiz Name'); ?></th>
                
                
		<th><?php echo $this->Paginator->sort('status'); ?></th>
		<th><?php echo $this->Paginator->sort('total_time'); ?></th>
		<th><?php echo $this->Paginator->sort('percentage'); ?></th>
		<th class="actions"><?php echo __d('croogo', 'Actions'); ?></th>
	</tr>
	<?php foreach ($results as $result): ?>
	<tr>
		<td><?php echo h($result['Result']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($result['Application']['first_name'] .' '. $result['Application']['last_name'], array('controller' => 'applications', 'action' => 'view', $result['Application']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($result['Quiz']['name'], array('controller' => 'quizzes', 'action' => 'view', $result['Quiz']['id'])); ?>
		</td>
                
		<td><?php echo h($result['Result']['status']); ?>&nbsp;</td>
		<td>
                        <?php 
                            $h = 0;
                            $m = 0;
                            $s = 0;
                            $h = floor($result['Result']['total_time'] / 3600);
                            $m = floor(($result['Result']['total_time']/60) % 60);
                            $s = $result['Result']['total_time'] % 60;
                            echo h($h .'h'.' '. $m .'m'.' '. $s .'s'); 
                        ?>&nbsp;
                </td>
		<td><?php echo h($result['Result']['percentage']) .'%'; ?>&nbsp;</td>
		<td class="item-actions">
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'view', $result['Result']['id']), array('icon' => 'eye-open')); ?>
			<?php // echo $this->Croogo->adminRowAction('', array('action' => 'edit', $result['Result']['id']), array('icon' => 'pencil')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'delete', $result['Result']['id']), array('icon' => 'trash'), __d('croogo', 'Are you sure you want to delete # %s?', $result['Result']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
