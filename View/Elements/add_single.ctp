<?php

        for ($i=1; $i<=$no_of_options; $i++){
                $value = $i-1;
                echo '<label><b>Option-'.$i.'</b></label>';
                echo $this->Form->input('Question.scores.score', array(
                        'type' => 'radio',
                        'options' => array($value => 'Select Correct Option-'.$i),
                        'class' => '',
                        $i==1?'checked':'',
                        'hiddenField' => false
                    )
                );
                
                echo $this->Form->input("Question.options.{$value}.option", array(
                        'type' => 'textarea',
                    )
                );
        }
?>