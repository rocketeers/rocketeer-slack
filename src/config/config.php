<?php

return array(

	// Slack room credentials
	'username' => '',
	'room'     => '',
	'token'    => '',

	// Message
	// You can use the following variables :
	// 1: User deploying
	// 2: Branch
	// 3: Connection and stage
	// 4: Host
	'message_finish' => '{1} finished deploying branch "{2}" on "{3}" ({4})',
	'message_prepare' => '{1} is deploying "{2}" on "{3}" ({4})',

	// Default emoji to use as the bot's avatar
	'emoji'   => 'rocket',

);