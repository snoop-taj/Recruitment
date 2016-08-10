<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Questions');
$this->extend('/Common/admin_index');
?>
<div class="row-fluid">
	<div class="span12 actions">
		<ul class="nav-buttons">
			<?php
				echo $this->Croogo->adminAction(
					__d('croogo', 'New %s', Inflector::singularize($this->name)),
					array('action' => 'pre_add'),
					array('button' => 'success')
				);
			?>

		</ul>
	</div>
</div>
<?php
$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Questions'), array('action' => 'index'));

?>

<div class="questions index">
	<table class="table table-striped">
	<tr>
		<th><?php echo $this->Paginator->sort('id', '#'); ?></th>
		<th><?php echo $this->Paginator->sort('question'); ?></th>
		<th><?php echo $this->Paginator->sort('type', 'Question type'); ?></th>
                <th><?php echo $this->Paginator->sort('category_name', 'Category'); ?></th>
		<th><?php echo $this->Paginator->sort('times_unattempted'); ?></th>
		<th><?php echo $this->Paginator->sort('times_served'); ?></th>
		<th><?php echo $this->Paginator->sort('times_corrected', '% Correct'); ?></th>
		<th><?php echo $this->Paginator->sort('times_incorrected', '% Incorrect'); ?></th>
		<th class="actions"><?php echo __d('croogo', 'Actions'); ?></th>
	</tr>
	<?php foreach ($questions as $question): ?>
	<tr>
		<td><?php echo h($question['Question']['id']); ?>&nbsp;</td>
		<td><?php echo h($question['Question']['question']); ?>&nbsp;</td>
		<td><?php echo h($question['Question']['type']); ?>&nbsp;</td>
                <td><?php echo h($question['Category']['name']); ?>&nbsp;</td>
		<td><?php echo h($question['Question']['times_unattempted']); ?>&nbsp;</td>
		<td><?php echo h($question['Question']['times_served']); ?>&nbsp;</td>
		<td><?php echo h($question['Question']['times_corrected']); ?>&nbsp;</td>
		<td><?php echo h($question['Question']['times_incorrected']); ?>&nbsp;</td>
		<td class="item-actions">
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'view', $question['Question']['id']), array('icon' => 'eye-open')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'edit', $question['Question']['id']), array('icon' => 'pencil')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'delete', $question['Question']['id']), array('icon' => 'trash'), __d('croogo', 'Are you sure you want to delete # %s?', $question['Question']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
