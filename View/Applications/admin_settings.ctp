<div class="application_setting">
    
        <h2><?php echo $title_for_layout; ?></h2>
    
        <?php echo $this->Form->create('Application'); ?>
        <div class="row-fluid">
                <div class="span8">
                        <ul class="nav nav-tabs">
                                <?php echo $this->Croogo->adminTab(__d('croogo', 'Email'), '#application_setting'); ?>
                        </ul>
                    
                        <?php
                                $content = '';
                                
                                foreach ($settings as $field => $opts):
                                        $content .= $this->Form->input($field .'.id', array(
                                                'type' => 'hidden', 'value' => $opts['id']
                                            ));
                                        $content .= $this->Form->input($field .'.key', array(
                                                'type' => 'hidden', 'value' => $opts['key']
                                            ));
                                        $content .= $this->Form->input($field .'.value', array(
                                                'type' => 'text', 
                                                'default' => $opts['value'],
                                                'label' => ucfirst($field),
                                                'class' => 'span8'
                                            ));
                                endforeach;
                        ?>
                        <div class="tab-content">
                                <?php
                                        if (!empty($content)):
                                            echo $this->Html->div('tab-pane', $content, array(
                                                    'id' => 'application_setting'
                                            ));
                                        endif;
                                ?>
                                <?php echo $this->Croogo->adminTabs(); ?>
                        </div>
                </div>
                <div class="span4">
                        <?php
                        echo $this->Html->beginBox('Saving') .
                                $this->Form->button(__d('croogo', 'Save')) .
                                $this->Html->link(__d('croogo', 'Cancel'), 
                                        array('action' => 'index'), 
                                        array('class' => 'btn btn-danger')) .
                                $this->Html->endBox();
                        echo $this->Croogo->adminBoxes();
                        ?>
                </div>
        </div>
        <?php echo $this->Form->end(); ?>
</div>

