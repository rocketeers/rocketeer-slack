<?php

return array(

	// Slack room credentials
	'url'      => '',
	'username' => '',
	'room'     => '',

	// Message
	// You can use the following variables :
	// 1: User deploying
	// 2: Branch
	// 3: Connection and stage
	// 4: Host
	'before_deploy'  => '{1} is deploying "{2}" on "{3}" ({4})',
	'after_deploy'   => '{1} finished deploying branch "{2}" on "{3}" ({4})',
	'after_rollback' => '{1} rolled back branch "{2}" on "{3}" to previous version ({4})',

	// Default emoji to use as the bot's avatar
	'emoji'   => 'rocket',

);