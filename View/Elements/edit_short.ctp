<?php
        echo $this->Form->input('Question.options.0.id', array(
                        'type' => 'hidden',
                        'value' => $options[0]['id']
                    )
                        
                );
	echo $this->Form->input('Question.options.0.option', array(
                        'label' => 'Answer in one or two words(comma separated for multiple possibilities.)',
                        'value' => $options[0]['option']
                    )
                );
?>