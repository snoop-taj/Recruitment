<?php

        for ($i=1; $i<=$no_of_options; $i++){
                $value = $i-1;
                echo '<label><b>Option-'.$i.'</b></label>';
                echo $this->Form->input("Question.scores.{$value}.score", array(
                        'type' => 'checkbox',
                        'options' => array($value => 'Select Correct Option'),
                        'class' => '',
                        $i==1?'checked':''
                    )
                );
                echo $this->Form->input("Question.options.{$value}.option", array(
                        'type' => 'textarea',
                    )
                );
        }
?>