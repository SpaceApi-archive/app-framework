<?php

// Use an URL of the form spaceapi.net and leave the protocol away.
define('SITE_URL', "spaceapi.net");

// the flag that puts OpenSpaceLint into the debug mode
define('DEBUG_MODE', true);

/*
  the debugging message level, one of these values:
  
    EMERG  = 0;  // Emergency: system is unusable
    ALERT  = 1;  // Alert: action must be taken immediately
    CRIT   = 2;  // Critical: critical conditions
    ERR    = 3;  // Error: error conditions
    WARN   = 4;  // Warning: warning conditions
    NOTICE = 5;  // Notice: normal but significant condition
    INFO   = 6;  // Informational: informational messages
    DEBUG  = 7;  // Debug: debug messages
*/
define('DEBUG_LEVEL', 7);

/**************************************************************/
// just don't change this
define('ROOTDIR', realpath(dirname(__FILE__)."/..")."/");
define('LOGDIR', ROOTDIR . 'log/');
define('CLASSDIR', ROOTDIR . "c/php/classes/"); // if you change this, change the path in the controller too
define('DIRECTORY', ROOTDIR . "c/directory/directory.json.public");
define('CACHEDIR', ROOTDIR . "cache/");
define('STATUSCACHEDIR', CACHEDIR . "status/");
define('SPECSDIR', ROOTDIR . "c/specs/versions/");

define('_APPSDIR', "apps/");
define('APPSDIR', ROOTDIR . _APPSDIR);