<?php

// Apply
CroogoRouter::connect('/apply', array(
	'plugin' => 'recruitment', 
        'controller' => 'applications', 
        'action' => 'apply'
));

// QUiz Route 
CroogoRouter::connect('/quiz/:action/*', array(
        'plugin' => 'recruitment', 
        'controller' => 'quizzes', 
        'action' => ':action'
));


