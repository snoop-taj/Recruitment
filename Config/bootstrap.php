<?php

CroogoNav::add('recruitment', array(
	'icon' => array('magic', 'large'),
	'title' => __d('croogo', 'Recruitment'),
	'url' => array(
                'admin' => true,
                'plugin' => 'recruitment',
                'controller' => 'applications',
                'action' => 'index',
        ),
	'weight' => 50,
	'children' => array(
                'applications' => array(
			'title' => __d('croogo', 'Applications'),
			'url' => array(
                                'admin' => true,
				'plugin' => 'recruitment',
				'controller' => 'applications',
				'action' => 'index',
			),
			'weight' => 10,
		),
		'jobs' => array(
			'title' => __d('croogo', 'Jobs'),
			'url' => array(
				'admin' => true,
				'plugin' => 'recruitment',
				'controller' => 'jobs',
				'action' => 'index',
			),
			'weight' => 20,
		),
//                'test' => array(
//                        'title' =>__d('croogo', 'Test'),
//                        'url' => array(
//                                'admin' => true,
//                                'plugin' => 'recruitment',
//                                'controller' => 'quizzes',
//                                'action' => 'index'
//                        ),
//                        'weight' => 30,
//                        'children' => array(
                                'quizzes' => array(
                                        'title' => __d('croogo', 'Quiz List'),
                                        'url' => array(
                                                'admin' => true,
                                                'plugin' => 'recruitment',
                                                'controller' => 'quizzes',
                                                'action' => 'index'
                                        ),
                                        'weight' => 40,
                                ),
                                'questions' => array(
                                        'title' => __d('croogo', 'Question List'),
                                        'url' => array(
                                                'admin' => true,
                                                'plugin' => 'recruitment',
                                                'controller' => 'questions',
                                                'action' => 'index'
                                        ),
                                        'weight' => 30,
                                ),
                                'categories' => array(
                                        'title' => __d('croogo', 'Category List'),
                                        'url' => array(
                                                'admin' => true,
                                                'plugin' => 'recruitment',
                                                'controller' => 'categories',
                                                'action' => 'index'
                                        ),
                                        'weight' => 50
                                ),
                                'results' => array(
                                        'title' => __d('croogo', 'Results'),
                                        'url' => array(
                                                'admin' => true,
                                                'plugin' => 'recruitment',
                                                'controller' => 'results',
                                                'action' => 'index'
                                        ),
                                        'weight' => 60
                                ),
//                        )
//                ),
                'settings' => array(
                        'title' => __d('croogo', 'Settings'),
                        'url' => array(
                                'admin' => true,
                                'plugin' => 'recruitment',
                                'controller' => 'applications',
                                'action' => 'settings'
                        ),
                ),
	),
));
