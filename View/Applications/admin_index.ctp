<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Applications');
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Applications'), array('action' => 'index'));

?>

<div class="applications index">
	<table class="table table-striped">
	<tr>
		<th><?php echo $this->Paginator->sort('first_name'); ?></th>
		<th><?php echo $this->Paginator->sort('last_name'); ?></th>
		<th><?php echo $this->Paginator->sort('email'); ?></th>
		<th><?php echo $this->Paginator->sort('job_id'); ?></th>
		<th><?php echo $this->Paginator->sort('curriculum_vitae'); ?></th>
		<th class="actions"><?php echo __d('croogo', 'Actions'); ?></th>
	</tr>

	<?php foreach ($applications as $application): ?>
	<tr>
		<td><?php echo h($application['Application']['first_name']); ?>&nbsp;</td>
		<td><?php echo h($application['Application']['last_name']); ?>&nbsp;</td>
		<td><?php echo h($application['Application']['email']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($application['Job']['title'], array('controller' => 'jobs', 'action' => 'view', $application['Job']['id'])); ?>
		</td>
		<td><?php 
                        $image = $this->Html->image('/croogo/img/icons/page_white.png') . ' ' . $application['Application']['curriculum_vitae_type'];
                        echo $this->Html->link(
                                $image, 
                                $this->Html->url($application['Application']['curriculum_vitae_path'], true),
                                array(
                                        'target' => '_blank',
                                ) 
                        ); ?>&nbsp;
                </td>
		<td class="item-actions">
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'view', $application['Application']['id']), array('icon' => 'eye-open')); ?>
			<?php // echo $this->Croogo->adminRowAction('', array('action' => 'edit', $application['Application']['id']), array('icon' => 'pencil')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'delete', $application['Application']['id']), array('icon' => 'trash'), __d('croogo', 'Are you sure you want to delete # %s?', $application['Application']['id'])); ?>
                    
                        <?php 
                                if ($application['Quiz']['name'] == null 
                                        && $application['Application']['decline'] == 0) {
                                        echo $this->Html->link(
                                            'Assign Quiz',
                                            'assign_quiz/'.$application['Application']['id'],
                                            array('class' => 'btn btn-success')
                                        );
                                }
                                
                                if ($application['Quiz']['name'] 
                                        && $application['Application']['accept'] == 0
                                        && $application['Application']['decline'] == 0) {
                                        echo $this->Html->link(
                                            'Accept',
                                            'accept/'.$application['Application']['id'],
                                            array('class' => 'btn btn-primary')
                                        );
                                }

                                if ($application['Application']['decline'] == 0 
                                        && $application['Application']['accept'] == 0) {
                                        echo $this->Html->link(
                                            'Decline',
                                            'decline/'.$application['Application']['id'],
                                            array('class' => 'btn btn-danger')
                                        );
                                }
                        ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
