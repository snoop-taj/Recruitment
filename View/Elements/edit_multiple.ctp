<?php

        foreach ($options as $i => $option){
                $value = $i+1;
                echo '<label><b>Option-'.$value.'</b></label>';
                echo $this->Form->input("Question.scores.{$i}.score", array(
                        'type' => 'checkbox',
                        'options' => array($i => 'Select Correct Option'),
                        'class' => '',
                        $option['score']==0?'':'checked'
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