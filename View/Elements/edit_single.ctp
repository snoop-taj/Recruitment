<?php

        foreach ($options as $i => $option){
                $value = $i+1;
                echo '<label><b>Option-'.$value.'</b></label>';
                echo $this->Form->input('Question.scores.score', array(
                        'type' => 'radio',
                        'options' => array($i => 'Select Correct Option-'.$value),
                        'class' => '',
                        $option['score']==1?'checked':'',
                        'hiddenField' => false
                    )
                );
                echo $this->Form->input("Question.options.{$i}.id", array(
                        'type' => 'hidden',
                        'value' => $option['id']
                    )
                );
                echo $this->Form->input("Question.options.{$i}.option", array(
                        'type' => 'textarea',
                        'value' => $option['option']
                    )
                );
        }
?>