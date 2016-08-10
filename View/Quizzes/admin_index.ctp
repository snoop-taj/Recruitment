<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Quizzes');
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Quizzes'), array('action' => 'index'));

?>

<div class="quizzes index">
	<table class="table table-striped">
	<tr>
		<th><?php echo $this->Paginator->sort('id', '#'); ?></th>
                <th><?php echo $this->Paginator->sort('name', 'Quiz Name'); ?></th>
                <th><?php echo $this->Paginator->sort('no_of_questions'); ?></th>
		<th class="actions"><?php echo __d('croogo', 'Actions'); ?></th>
	</tr>
	<?php foreach ($quizzes as $quiz): ?>
	<tr>
		<td><?php echo h($quiz['Quiz']['id']); ?>&nbsp;</td>
		<td><?php echo h($quiz['Quiz']['name']); ?>&nbsp;</td>
		<td><?php echo h($quiz['Quiz']['no_of_questions']); ?>&nbsp;</td>
		<td class="item-actions">
                        <?php echo $this->Html->link(
                                    'Add Questions',
                                    'add_question/'.$quiz['Quiz']['id'],
                                    array('class' => 'btn btn-success')
                                );
                        ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'view', $quiz['Quiz']['id']), array('icon' => 'eye-open')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'edit', $quiz['Quiz']['id']), array('icon' => 'pencil')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'delete', $quiz['Quiz']['id']), array('icon' => 'trash'), __d('croogo', 'Are you sure you want to delete # %s?', $quiz['Quiz']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
