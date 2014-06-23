<?php

global $project;
$project = 'mysite';

// use _ss_environment.php for DB config
require_once('conf/ConfigureFromEnv.php');

// Set the site locale
i18n::set_locale('en_US');

if (Director::isLive()) {
	// we are in live mode, send errors per email
	SS_Log::add_writer(new SS_LogEmailWriter('myEmail@mysite.com'), SS_Log::ERR);
	// IMPORTANT: as of 3.1 you can *NOT* set display_errors inside _config.php
	// use the php ini, htaccess or _ss_environment.php to set display_errors
}