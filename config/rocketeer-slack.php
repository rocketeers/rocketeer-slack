<?php

return [

    // Slack room credentials
    'url' => '',
    'username' => '',
    'room' => '',

    // Slack client attributes see https://api.slack.com/docs/messages for usage
    // Available attributes:
    // 'channel'
    // 'username'
    // 'icon'
    // 'link_names'
    // 'unfurl_links'
    // 'unfurl_media'
    // 'allow_markdown'
    // 'markdown_in_attachments'
    'attributes' => [],

    // Message
    // You can use the following variables :
    // 1: User deploying
    // 2: Branch
    // 3: Connection and stage
    // 4: Host
    // 5: repository
    'before_deploy' => '*{1}* is deploying *{5}@{2}* on *{3}* ({4})',
    'after_deploy' => '*{1}* finished deploying *{5}@{2}* on *{3}* ({4})',
    'halt_deploy' => 'Failed to deploy {5}@{2} on "{3}" ({4})',
    'after_rollback' => '*{1}* rolled back *{5}@{2}* on *{3}* to previous version ({4})',

    // Default emoji to use as the bot's avatar
    'emoji' => ':rocket:',

];
