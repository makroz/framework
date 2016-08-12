<?php 
include("logger.php");
$logger = new Logger(array(
	"file" =>APP_PATH . "/logs/" . date("Y-m-d") . ".html"
	));
// log cache events
Mk\Events::add("mk.cache.initialize.before", function($type, $options) 
	use	($logger)
	{
		$logger->log("mk.cache.initialize.before: " . $type);
	});
Mk\Events::add("mk.cache.initialize.after", function($type, $options) 
	use	($logger)
	{
		$logger->log("mk.cache.initialize.after: " . $type);
	});
// log configuration events
Mk\Events::add("mk.configuration.initialize.before", function($type, $options)
	use ($logger)
	{
		$logger-> log("mk.configuration.initialize.before: " . $type);
	});
Mk\Events::add("mk.configuration.initialize.after", function($type, $options)
	use ($logger)
	{
		$logger->log("mk.configuration.initialize.after: " . $type);
	});

	?>