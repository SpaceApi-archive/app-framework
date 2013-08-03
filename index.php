<?php

    require_once("config/config.php");
	error_reporting( (DEBUG_MODE) ? E_ALL : 0 );

    function dumpx($mixed)
    {
        echo "<pre>" . htmlspecialchars(print_r($mixed, true)) . "</pre>";
    }

    /************************************************************************************************/
    // define the auto class loader
    function class_loader($classname)
    {
        $classfile = CLASSDIR . "$classname.class.php";

        if (file_exists($classfile))
        {
            require_once($classfile);
            return true;
        }

        // this is not so ideal, when the config cannot be loaded this fails
        // so just be sure the Config class is always included!
        $logger = KLogger::instance(LOGDIR, DEBUG_LEVEL);
        $logger->logEmerg("The class '$classname' cannot be loaded!");

        return false;
    }

    spl_autoload_register("class_loader");

    // whenever the backend classes are used, we most probably need the logger and the SAPI constant
    $logger = KLogger::instance(LOGDIR, DEBUG_LEVEL);
    define('SAPI', 'apache');
    /************************************************************************************************/

    $requested_app = str_replace("/", "", $_SERVER['REDIRECT_URL']);

    if( empty($requested_app) )
        $requested_app = "intro";

	// we must whitelist the input
	$load_app = APPSDIR . "error-page";
    foreach(glob( APPSDIR . "*") as $app_dir)
    {
		if ( $requested_app === basename($app_dir) )
			$load_app = $app_dir;
    }

    include("Page.php");
    $page = new Page(basename($load_app));

    chdir($load_app);
	include("app.php");
    chdir(ROOTDIR);

	$output = file_get_contents("template.html");
	$output = str_replace("%CONTENT%", $page->content(), $output);
	
	/*************************************************************/
	
	$prefetch_tags = "";
	foreach($page->prefetchAssets() as $asset)
	{
		if(! empty($asset))
			$prefetch_tags .= '<link rel="prefetch" href="'. $asset .'" >';
	}
	
	$output = str_replace("%PREFETCHASSETS%", $prefetch_tags, $output);
	
	/*************************************************************/
	
	$script_tags = "";
	foreach($page->scripts() as $script)
	{
		if(! empty($script))
			$script_tags .= '<script src="'. $script .'"></script>';	
	}
	
	$output = str_replace("%SCRIPTS%", $script_tags, $output);
	
	/*************************************************************/

    $global_script_tags = "";
    foreach($page->requireScripts() as $script)
    {
        if(! empty($script))
            $global_script_tags .= '<script src="c/js/'. $script .'"></script>';
    }

    $output = str_replace("%REQUIRE_GLOBAL_SCRIPTS%", $global_script_tags, $output);

    /*************************************************************/

	$stylesheet_tags = "";	
	foreach($page->stylesheets() as $stylesheet)
	{
		if(! empty($stylesheet))
			$stylesheet_tags .= '<link type="text/css" rel="stylesheet" href="'. $stylesheet .'">';
	}
	
	$output = str_replace("%STYLESHEETS%", $stylesheet_tags, $output);
	
	/*************************************************************/

	$inline_style_tag = "<style>". join("", $page->inlineStyles()) ."</style>";
	$output = str_replace("%INLINESTYLES%", $inline_style_tag, $output);
	
	/*************************************************************/
	
	// populate the menu
	include( APPSDIR . "menu.php");
	
	$menu_tags = "";
	foreach($menu as $key => $label)
	{
		$class = "";
		if( $key == $page->activePage() )
			$class = "active";
		
		$menu_tags .= '<li class="'. $class .'"><a href="'. $key .'">'. $label .'</a></li>';
	}
	
	$output = str_replace("%MENU%", $menu_tags, $output);
    $output = str_replace("%SITEURL%", "http://".SITE_URL, $output);
	
    echo $output;