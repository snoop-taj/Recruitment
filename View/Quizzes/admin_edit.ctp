<?php
echo $this->Html->css(array(
        '/recruitment/css/attempt'
    )
);

echo $this->Html->script(array(
        '/recruitment/js/attempt'
    )
);

$this->viewVars['title_for_layout'] = __d('croogo', 'Quizzes');
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Quizzes'), array('action' => 'index'));

if ($this->action == 'admin_edit') {
	$this->Html->addCrumb($this->data['Quiz']['name'], $this->here);
	$this->viewVars['title_for_layout'] = 'Quizzes: ' . $this->data['Quiz']['name'];
} else {
	$this->Html->addCrumb(__d('croogo', 'Add'), $this->here);
}

echo $this->Form->create('Quiz');

?>
<div class="quizzes row-fluid">
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
				echo $this->Form->input('id');
				$this->Form->inputDefaults(array('label' => false, 'class' => 'span10'));
				echo $this->Form->input('name', array(
					'label' => 'Name',
				));
				echo $this->Form->input('description', array(
					'label' => 'Description',
				));
				echo $this->Form->input('start_date', array(
					'label' => 'Start Date',
				));
				echo $this->Form->input('end_date', array(
					'label' => 'End Date',
				));
				echo $this->Form->input('duration', array(
					'label' => 'Duration',
				));
				echo $this->Form->input('maximum_attempts', array(
					'label' => 'Maximum Attempts',
				));
				echo $this->Form->input('pass_percentage', array(
					'label' => 'Pass Percentage',
				));
				echo $this->Croogo->adminTabs();
			?>
			</div>
		</div>

	</div>

	<div class="span4">
	<?php
		echo $this->Html->beginBox(__d('croogo', 'Publishing')) .
			$this->Form->button(__d('croogo', 'Save'), array('class' => 'btn btn-primary')) .
			$this->Html->link(__d('croogo', 'Cancel'), array('action' => 'index'), array('class' => 'btn btn-danger')) .
			$this->Html->endBox();
		?>
	</div>

</div>
<?php echo $this->Form->end(); ?>
<hr>

<h3>Questions added into this Quiz</h3>
<div class="row-fluid">
	<div class="span12 actions">
		<ul class="nav-buttons">
			<?php
				echo $this->Croogo->adminAction(
					__d('croogo', 'Add Questions into Quiz'),
					array('action' => 'add_question', $this->data['Quiz']['id']),
					array('button' => 'danger')
				);
			?>

		</ul>
	</div>
</div>

<div class="quizzes index">
	<table class="table table-striped">
	<tr>
		<th><?php echo __d('croogo', '#'); ?></th>
                <th><?php echo __d('croogo', 'Question'); ?></th>
                <th><?php echo __d('croogo', 'Question Type'); ?></th>
                <th><?php echo __d('croogo', 'Category Name'); ?></th>
		<th class="actions"><?php echo __d('croogo', 'Actions'); ?></th>
	</tr>
        <?php if(count($questions) == 0) : ?>
        <tr>
                <td colspan="5">No Question Added</td>
        </tr>
        <?php else: ?>
            <?php foreach ($questions as $key => $question): ?>
            <tr>
                    <td><?php echo h($question['Question']['id']); ?>&nbsp;</td>
                    <td><?php echo h(substr($question['Question']['question'],0,50)); ?>&nbsp;</td>
                    <td><?php echo h($question['Question']['type']); ?>&nbsp;</td>
                    <td><?php echo h($question['Category']['name']); ?>&nbsp;</td>
                    <td class="item-actions">
                            <?php 
                                $quizId = $this->data['Quiz']['id'];
                                $questionIds = $this->data['Quiz']['question_ids'];
                                $questionId = $question['Question']['id'];
                                echo $this->Croogo->adminRowAction('', array('action' => 'remove_question_id', $quizId.'/'.$questionId), array('icon' => 'trash'), __d('croogo', 'Are you sure you want to remove # %s?', $question['Question']['id']));
                                if ($key == 0) {
                                        echo $this->HTML->image('/croogo/img/empty.png');
                                } else {
                                        $questionKey = $key + 1;
                                        echo $this->Croogo->adminRowAction('', "javascript:question.cancel_move('Up', {$quizId}, {$questionId}, {$questionKey});", array('icon' => 'arrow-up'));
                                }
                                
                                if ($questionIds !== null) {
                                        if ((count(explode(',', $questionIds)) - 1) !== $key) {
                                                $questionKey = $key + 1;
                                                echo $this->Croogo->adminRowAction('', "javascript:question.cancel_move('Down', {$quizId}, {$questionId}, {$questionKey});", array('icon' => 'arrow-down'));
                                        }
                                }
                            ?>
                    </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
	</table>
</div>

<div id="warning" class="hide quiz-warning">
        <h5 id="move-text"></h5>
        <div>
                <input id="position" type="text" class="input-mini" value=""></input>
        </div>

        <button class="btn btn-danger" onclick="question.cancel_move();">Cancel</button>
        <button class="btn btn-info" onclick="question.move();">Submit</button>
</div>