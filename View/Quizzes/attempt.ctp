<?php 
echo $this->Html->css(array(
        '/croogo/css/croogo-bootstrap',
        '/croogo/css/croogo-bootstrap-responsive',
        '/croogo/css/thickbox',
        '/recruitment/css/fix',
        '/recruitment/css/attempt'
    )
);

echo $this->Html->script(array(
        '/recruitment/js/attempt'
    )
);
?>

<?php $alphaChoice = array('0' => 'A', '1' => 'B', '2' => 'C', '3' => 'D', '4' => 'E'); ?>
<div class="container">
        <div class="row-fluid">
                <div id="signal-1" class="signal pull-right"></div>
                <div id="signal-2" class="signal pull-right"></div>

                <div class="timer pull-right"> 
                    Time left: 
                    <span id="timer">
                        00:00:00
                        <script type="text/javascript">window.onload = timer.create_time('timer', <?=$data['seconds']; ?>);</script>
                    </span>

                </div>

                <div class="pull-left">
                        <h3><?php echo $data['quiz']['name']; ?></h3>
                </div>
        </div>
    
        <div class="clearfix"></div>
        
        <div class="row-fluid">
                <div class="span8">
                    <?php echo $this->Form->create(null, array('action' => 'submit/'.$data['resultId'], 'id' => 'quiz_form'));  
                        echo $this->Form->input('result_id', array(
                                'type' => 'hidden',
                                'value' => $data['resultId'],
                                'name' => 'result_id',
                                'id' => 'result_id'
                            ));
                        echo $this->Form->input('no_of_questions', array(
                                'type' => 'hidden',
                                'value' => $data['quiz']['no_of_questions'],
                                'name' => 'no_of_questions',
                                'id' => 'no_of_questions'
                            ));
                        echo $this->Form->input('individual_time', array(
                                'type' => 'hidden',
                                'value' => $data['result']['individual_time'],
                                'name' => 'individual_time',
                                'id' => 'individual_time'
                            ));
                    
                    ?>
                    <?php foreach ($data['question'] as $qKey => $question) :?>
                        <div class="question hide" id="q-<?= $qKey; ?>">
                                <div class="quiz-container">
                                        <h5>Question <?= $qKey+1; ?> </h5>
                                        <?php
                                            echo '<div>'. $question['Question']['question'] . '</div>'; 
                                        ?>
                                </div>
                                <div class="option-container">
                                    <?php 
                                        $answers = array();
                                        foreach ($data['answer'] as $aKey => $answer) {
                                                if($question['Question']['id'] == $answer['question_id']) {
                                                        $answers[] = $answer['option'];
                                                }
                                        }
                                        switch ($question['Question']['type']) {
                                            
                                                case 'Single Answer with Multiple Choice':
                                                    echo $this->Form->input('question_type', array(
                                                        'type' => 'hidden',
                                                        'value' => 'single',
                                                        'id' => 'q-type-'.$qKey,
                                                        'name' => 'question_type[]'
                                                    ));
                                                
                                                    foreach ($question['Option'] as $oKey => $option) {
                                                            echo '<h5 class="option">'.$alphaChoice[$oKey].'</h5>';
//                                                            echo $this->Form->input('answer_value', array(
//                                                                    'type' => 'radio',
//                                                                    'options' => array($option['id'] => $option['option']),
//                                                                    'id' => 'ans-val-'.$qKey.'-'.$oKey,
//                                                                    'name' => "answer[{$qKey}][]",
//                                                                    'hiddenField' => false,
//                                                                    in_array($option['id'], $answers)? 'checked' : ''
//                                                                ));

                                                            echo "<div class='input radio'>";
                                                            if(in_array($option['id'], $answers)) {
                                                                    echo "<input id='ans-val-{$qKey}-{$oKey}' name='answer[{$qKey}][]' value={$option['id']} type='radio' checked />";
                                                            } else {
                                                                    echo "<input id='ans-val-{$qKey}-{$oKey}' name='answer[{$qKey}][]' value={$option['id']} type='radio' />";
                                                            }
                                                            
                                                            echo "<label for='ans-val-{$qKey}-{$oKey}'>{$option['option']}</label>";
                                                            echo "</div>";
                                                    }
                                                    
                                                    break;
                                                    
                                                case 'Multiple Answer with Multiple Choice':
                                                    echo $this->Form->input('question_type', array(
                                                        'type' => 'hidden',
                                                        'value' => 'multiple',
                                                        'id' => 'q-type-'.$qKey,
                                                        'name' => 'question_type[]'
                                                    ));
                                                    
                                                    foreach ($question['Option'] as $oKey => $option) {
                                                            echo '<h5 class="option">'.$alphaChoice[$oKey].'</h5>';
                                                            echo $this->Form->input('answer', array(
                                                                    'type' => 'checkbox',
                                                                    'value' => $option['id'],
                                                                    'label' => $option['option'],
                                                                    'id' => 'ans-val-'.$qKey.'-'.$oKey,
                                                                    'name' => "answer[{$qKey}][]",
                                                                    'hiddenField' => false,
                                                                    in_array($option['id'], $answers)? 'checked' : ''
                                                            ));
                                                    }
                                                    break;
                                                    
                                                case 'Short Answer':
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
                                                        'id' => 'ans-val-'.$qKey,
                                                        'name' => "answer[{$qKey}][]",
                                                        'class' => 'span10'
                                                    ));
                                                    break;
                                                
                                                case 'Long Answer':
                                                    echo $this->Form->input('question_type', array(
                                                        'type' => 'hidden',
                                                        'value' => 'long',
                                                        'id' => 'q-type-'.$qKey,
                                                        'name' => 'question_type[]',
                                                    ));
                                                    
                                                    $wordCount = "<div>Word count <span id='char-count-{$qKey}'>0</span></div>";
                                                    echo $this->Form->input('answer', array(
                                                        'type' => 'textarea',
                                                        'label' => 'Answer '. $wordCount,
                                                        'value' => reset($answers),
                                                        'id' => 'ans-val-'.$qKey,
                                                        'name' => "answer[{$qKey}][]",
                                                        'class' => 'input-xxlarge',
                                                        'onkeyup' => "quiz.word_count(this.value, 'char-count-{$qKey}')"
                                                    ));
                                                    break;
                                        }
                                        
                                    ?>
                                </div>
                        </div>
                    
                    <?php endforeach; ?>
                    
                    <?php echo $this->Form->end(); ?>
                </div>

                <div class="span4">
                        <h4> Questions </h4>
                        <div>
                            <?php 
                                for ($i = 0; $i < $data['quiz']['no_of_questions']; $i++) :
                            ?>
                                <div id="question-btn-<?= $i; ?>" class="btn btn-inverse" onclick="quiz.show_question(<?= $i; ?>);"><?= $i+1; ?></div>
                            <?php endfor; ?>
                                <div class="clearfix"></div>
                        </div>
                        
                        <hr class="hr" />
                        
                        <div>
                                <table>
                                        <tr>
                                                <td><div class="btn btn-success">&nbsp;</div>Answered</td>
                                        </tr>
                                        <tr>
                                                <td><div class="btn btn-danger">&nbsp;</div>UnAnswered</td>
                                        </tr>
                                        <tr>
                                                <td><div class="btn btn-warning">&nbsp;</div>Review Later</td>
                                        </tr>
                                        <tr>
                                                <td><div class="btn btn-inverse">&nbsp;</div>Not-Visited</td>
                                        </tr>
                                </table>
                        </div>
                </div>
        </div>
        
        <div class="row-fluid">
                <div class="span12">
                        <div class="footer-btn">
                                <button class="btn btn-warning" onclick="quiz.review_later();">Review Later</button>
                                <button class="btn btn-info" onclick="quiz.clear();">Clear</button>
                                <button class="btn btn-success" onclick="quiz.prev_question();" id="back-btn">Back</button>
                                <button class="btn btn-success" onclick="quiz.next_question();" id="nxt-btn">Save & Next</button>
                                <button class="btn btn-danger" onclick="quiz.cancel_move();">Submit Quiz</button>
                        </div>
                </div>
        </div>
        
        <div id="warning" class="hide quiz-warning">
                <h3>Do you want to submit this quiz?</h3>
                <span id="processing"></span>
                
                <button class="btn btn-danger" onclick="quiz.cancel_move();">Cancel</button>
                <button class="btn btn-info" onclick="quiz.submit_quiz();">Submit</button>
        </div>
</div>

<script type="text/javascript">     
    quiz.noOfQuestion = <?= $data['quiz']['no_of_questions']; ?>;
    var seconds = <?= $data['seconds']; ?>;
    quiz.submitUrl = '<?= $this->Html->url('/quiz/submit/'.$data['resultId'], true); ?>';
//    var individualTime = new Array();
    
    <?php if (isset($data['result']['individual_time'])) : ?>
        <?php $individualTime = explode(',', $data['result']['individual_time']); ?>
        <?php foreach ($individualTime as $key => $time) : ?>
            timer.individualTime[<?= $key; ?>] = <?= $time; ?>;
        <?php endforeach; ?>
    <?php endif; ?>

    
    quiz.show_question('0');
    setInterval(timer.increase_time, 1000);
    setInterval(quiz.set_individual_time, 30000);
</script>

