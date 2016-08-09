<?php
echo $this->Html->script(array(
        '/recruitment/js/basic',
    )
);

$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Results'), h($result['Result']['id']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Results'), array('action' => 'index'));
	
?>
<h2 class="hidden-desktop"><?php echo __d('croogo', 'Result'); ?></h2>

<div class="row-fluid">
	<div class="span12 actions">
		<ul class="nav-buttons">
		<li><?php echo $this->Form->postLink(__d('croogo', 'Delete Result'), array('action' => 'delete', $result['Result']['id']), array('button' => 'default'), __d('croogo', 'Are you sure you want to delete # %s?', $result['Result']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Results'), array('action' => 'index'), array('button' => 'default')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Applications'), array('controller' => 'applications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Quizzes'), array('controller' => 'quizzes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('croogo', 'List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		</ul>
	</div>
</div>

<div class="results view">
    
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
                        $row[] = array('First Name', $result['Application']['first_name']);
                        $row[] = array('Last Name', $result['Application']['last_name']);
                        $row[] = array('Email', $result['Application']['email']);
                        $row[] = array('Quiz Name', $result['Quiz']['name']);
                        $row[] = array('Time Started', $result['Result']['start_time']);
                        $row[] = array('Total Time Spent (duration)', $duration);
                        $row[] = array('Percentage Obtained', $result['Result']['percentage']);
                        $row[] = array('Score Obtained', $result['Result']['score']);
                        $row[] = array('Status', $result['Result']['status']);
                        
                        echo $this->Html->tableCells($row);
                ?>
        </table>
	
</div>

<?php 
    $alphaChoice = array('0' => 'A', '1' => 'B', '2' => 'C', '3' => 'D', '4' => 'E'); 
    $individualScore = explode(',', $result['Result']['individual_score']);
    
?>
<div class="accordion-group">
        <div class="accordion-inner">
                <h3> Answer Sheet </h3> 
                <?php foreach ($questions as $qKey => $question): ?> 
                <hr />
                <?php 
                        $correctOption = '';
                        $answers = array();
                        foreach ($result['Answer'] as $aKey => $answer) {
                                if ($question['Question']['id'] == $answer['question_id']) {
                                        $answers[] = $answer['option'];
                                }
                        }
                        $class = ''; 
                        if (isset($individualScore[$qKey])) {
                                switch ($individualScore[$qKey]) {
                                        case 1 :
                                            $class = 'success';
                                            break;
                                        case 2 :
                                            $class = 'error';
                                            break;
                                        case 3 :
                                            $class = 'warning';
                                            break;
                                        default :
                                            $class = '';
                                }
                        }
                ?>
                <div id="q-<?= $qKey; ?>" class="<?= $class ; ?>">
                        <div>
                                <h5>Question <?=$qKey+1; ?></h5>
                                <div> <?= $question['Question']['question']; ?> </div>
                        </div>
                    
                        <div>
                               <?php
                                        switch ($question['Question']['type']) {
                                            
                                                case 'Single Answer with Multiple Choice':
                                                    echo $this->Form->input('question_type', array(
                                                        'type' => 'hidden',
                                                        'value' => 'single',
                                                        'id' => 'q-type-'.$qKey,
                                                        'name' => 'question_type[]'
                                                    ));
                                                    
                                                    foreach ($question['Option'] as $oKey => $option) { 
                                                            if ($option['score'] >= 0.1) {
                                                                    $correctOption = $option['option'];
                                                            }
                                                            
                                                            echo '<h5 class="option">'.$alphaChoice[$oKey].'</h5>';
                                                            echo "<div class='input radio'>";
                                                            if(in_array($option['id'], $answers)) {
                                                                    echo "<input id='ans-val-{$qKey}-{$oKey}' name='answer[{$qKey}][]' value={$option['id']} type='radio' checked />";
                                                            } else {
                                                                    echo "<input id='ans-val-{$qKey}-{$oKey}' name='answer[{$qKey}][]' value={$option['id']} type='radio' />";
                                                            }
                                                            
                                                            echo "<label for='ans-val-{$qKey}-{$oKey}'>{$option['option']}</label>";
                                                            echo "</div>";
                                                    }
                                                    echo '<span class="label label-info"> Correct Option: '. $correctOption .'</span>';
                                                    break;
                                                    
                                                case 'Multiple Answer with Multiple Choice':
                                                    echo $this->Form->input('question_type', array(
                                                        'type' => 'hidden',
                                                        'value' => 'multiple',
                                                        'id' => 'q-type-'.$qKey,
                                                        'name' => 'question_type[]'
                                                    ));
                                                    
                                                    $correctOption = array();
                                                    foreach ($question['Option'] as $oKey => $option) {
                                                            if ($option['score'] >= 0.1) {
                                                                    $correctOption[] = $option['option'];
                                                            }
                                                            
                                                            echo '<h5 class="option">'.$alphaChoice[$oKey].'</h5>';
                                                            echo $this->Form->input('answer', array(
                                                                    'type' => 'checkbox',
                                                                    'value' => $option['id'],
                                                                    'label' => $option['option'],
                                                                    'id' => 'answer-value-'.$qKey.'-'.$oKey,
                                                                    'name' => "answer[{$qKey}][]",
                                                                    in_array($option['id'], $answers)? 'checked' : ''
                                                            ));
                                                    }
                                                    echo '<span class="label label-info"> Correct Options: '. implode(',', $correctOption) .'</span>';
                                                    break;
                                                    
                                                case 'Short Answer':
                                                    foreach ($question['Option'] as $oKey => $option) {
                                                            $correctOption = $option['option'];
                                                    }
                                                    echo $this->Form->input('question_type', array(
                                                        'type' => 'hidden',
                                                        'value' => 'short',
                                                        'id' => 'q-type-'.$qKey,
                                                        'name' => 'question_type[]'
                                                    ));
                                                    
                                                    echo $this->Form->input('answer', array(
                                                        'type' => 'text',
                                                        'label' => 'Answer',
                                                        'value' => reset($answers),
                                                        'id' => 'answer-value-'.$qKey,
                                                        'name' => "answer[{$qKey}][]"
                                                    ));
                                                    echo '<span class="label label-info"> Correct Options: '. $correctOption .'</span>';
                                                    break;
                                                
                                                case 'Long Answer':
                                                    echo $this->Form->input('question_type', array(
                                                        'type' => 'hidden',
                                                        'value' => 'long',
                                                        'id' => 'q-type-'.$qKey,
                                                        'name' => 'question_type[]'
                                                    ));
                                                    
                                                    $wordCount = str_word_count(reset($answers));
                                                    echo '<p>Word Count: </p>'. $wordCount;
                                                    
                                                    echo $this->Form->input('answer', array(
                                                        'type' => 'textarea',
                                                        'label' => 'Answer',
                                                        'value' => reset($answers),
                                                        'id' => 'answer-value-'.$qKey,
                                                        'name' => "answer[{$qKey}][]",
                                                        'class' => 'input-xxlarge'
                                                    ));
                                                        
                                                    echo "<div class='row-fluid id='assign-score-{$qKey}'>";
                                                    echo "<h5> Evaluate </h5>";
                                                    echo $this->Html->link(
                                                        'Correct',
                                                        "#",
                                                        array(
                                                                'class' => 'span2 btn btn-success',
                                                                'onclick' => "add_score('{$result['Result']['id']}', '{$qKey}', '1')"
                                                            )
                                                    );
                                                    echo $this->Html->link(
                                                        'Incorrect',
                                                        "#",
                                                        array(
                                                                'class' => 'span2 btn btn-danger',
                                                                'onclick' => "add_score('{$result['Result']['id']}', '{$qKey}', '2')"
                                                            )
                                                    );
                                                    echo "</div>";
                                                    break;
                                        }
                                    ?> 
                        </div>
                
                </div>
                
                <?php endforeach; ?>
        </div>
</div>

