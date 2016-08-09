<?php
echo $this->Html->script(array(
        '/recruitment/js/basic',
    )
);

$this->viewVars['title_for_layout'] = __d('croogo', 'Quizzes');
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
        ->addCrumb(__d('croogo', 'Edit Quiz'), array('action' => 'edit/'.$quizId))
	->addCrumb(__d('croogo', 'Add Question'), array('action' => 'index'));

?>

<div class="quizzes index">
	<table class="table table-striped">
	<tr>
		<th><?php echo __d('croogo', '#'); ?></th>
                <th><?php echo __d('croogo', 'Question'); ?></th>
                <th><?php echo __d('croogo', 'Question Type'); ?></th>
                <th><?php echo __d('croogo', 'Category Name'); ?></th>
                <th><?php echo __d('croogo', '% Corrected'); ?></th>
		<th class="actions"><?php echo __d('croogo', 'Actions'); ?></th>
	</tr>
	<?php foreach ($questions as $question): ?>
	<tr>
                <td><a href="#" onclick="show_question_stat('<?php echo $question['Question']['id']; ?>')">+</a><?php echo h($question['Question']['id']); ?>&nbsp;</td>
                <td>
                        <?php echo substr(h($question['Question']['question']),0,50); ?>&nbsp;
                        <span style="display:none;" id="stat-<?php echo $question['Question']['id']; ?>">
                                <table class="table table-striped">
                                        <tr><td>Times Corrected</td><td><?php echo $question['Question']['times_corrected'] ?></td></tr>
                                        <tr><td>Times Incorrected</td><td><?php echo $question['Question']['times_incorrected'] ?></td></tr>
                                        <tr><td>Times Unattempted</td><td><?php echo $question['Question']['times_unattempted'] ?></td></tr>
                                </table>
                        </span>
                </td>
		<td><?php echo h($question['Question']['type']); ?>&nbsp;</td>
		<td><?php echo h($question['Category']['name']); ?>&nbsp;</td>
                <td>
                    <?php if ($question['Question']['times_served'] != '0') : ?>
                        <?php $percentage = ($question['Question']['times_corrected']/$question['Question']['times_served'])*100; ?>
                        <div style="background:#eee; width: 100%; height: 10px;">
                                <div style="background: #449d44; width: <?php echo intval($percentage); ?>%; height: 10px;"></div>
                                <span style="font-size: 10px;"><?php echo intval($percentage); ?></span>
                        </div>
                        <?php else : ?>
                            <?php echo h('Not used'); ?>&nbsp;
                    <?php endif; ?>
                    
                </td>
		<td class="item-actions">
                        <?php 
                                $add = 'Add';
                                if (in_array($question['Question']['id'], explode(',', $quiz['Quiz']['question_ids']))) {
                                    $add = 'Added';
                                }
                                echo $this->Html->link(
                                    $add,
                                    "#",
                                    array(
                                            'class' => 'btn btn-success',
                                            'id' => 'q'.$question['Question']['id'],
                                            'onclick' => "add_question('{$question['Question']['id']}', '$quizId')"
                                        )
                                );
                        ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
