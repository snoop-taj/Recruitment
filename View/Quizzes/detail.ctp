<?php 
echo $this->Html->css(array(
        '/croogo/css/croogo-bootstrap',
        '/croogo/css/croogo-bootstrap-responsive',
        '/croogo/css/thickbox',
        '/recruitment/css/fix'
));
?>
<div class="container">
    
        <h3>Quiz Detail</h3>
        <?php $candidate = ($candidateId) ? '/'.$candidateId  : ''; ?>
        <?php echo $this->Form->create('Quiz'); 
        ?>
        
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
                        $rows = array(); 
                        foreach ($quiz['Quiz'] as $title => $detail) {
                                if (in_array($title, array('question_ids', 'id', 'created', 'updated'))) {
                                        continue;
                                }
                                
                                switch ($title) {
                                        case 'name' :
                                            $title = 'Name';
                                            break;
                                        case 'description' :
                                            $title = 'Description';
                                            break;
                                        case 'start_date' :
                                            $title = 'Start Date';
                                            break;
                                        case 'end_date' :
                                            $title = 'End Date';
                                            break;
                                        case 'no_of_questions':
                                            $title = 'No of Questions';
                                            break;
                                        case 'duration' :
                                            $title = 'Duration (in min.)';
                                            break;
                                        case 'maximum_attempts' :
                                            $title = 'Maximum Attemptes Allowed';
                                            break;
                                        case 'pass_percentage' :
                                            $title = 'Minimum Required Pass Percentage';
                                            break;
                                }
                                
                                $row[] = array($title, $detail);
                        }
                ?>
                <?php echo $this->Html->tableCells($row); ?>
        </table>
          
        <div class="row-fluid">
                <div class="control-group">
                        <div class="controls">
                        <?php echo $this->Form->end(__d('croogo', 'Start Quiz')); ?>
                        </div>
                </div>
        </div>
</div>