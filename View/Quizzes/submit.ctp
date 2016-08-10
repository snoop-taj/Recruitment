<?php 
echo $this->Html->css(array(
        '/croogo/css/croogo-bootstrap',
        '/croogo/css/croogo-bootstrap-responsive',
        '/croogo/css/thickbox',
        '/recruitment/css/fix'
));
?>
<div class="container">
    
        <?php if ($submitted): ?>
            <p class="center"> Thank you for completing the quiz. A member of the HR department will be in touch with you!</p>
        <?php else: ?>
            <p class="center"> An Error has occurred. Please get in touch! </p>
        <?php endif; ?>
</div>