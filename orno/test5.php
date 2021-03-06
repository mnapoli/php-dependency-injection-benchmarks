<?php
require_once '../testclasses.php';

function __autoload($className)
{
	$className = ltrim($className, '\\');
	$fileName  = '';
	$namespace = '';
	if ($lastNsPos = strrpos($className, '\\')) {
		$namespace = substr($className, 0, $lastNsPos);
		$className = substr($className, $lastNsPos + 1);
		$fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
	}
	$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

	require $fileName;
}



$container = new \Orno\Di\Container;

$a1 = new A;
$container->add('A', $a1);

//trigger all autoloaders
$b = $container->get('B');
unset($b);

$t1 = microtime(true);


for ($i = 0; $i < 10000; $i++) {
	$a = $container->get('B');
}

$t2 = microtime(true);

echo $t2 - $t1;

echo '<br /># Files: ' . count(get_included_files());
echo '<br />Memory usage:' . (memory_get_peak_usage()/1024/1024) . 'mb';