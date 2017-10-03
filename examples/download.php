<?php
/**
 * @author Anne Douwe Bouma
 */
include '../vendor/autoload.php';

use dawood\phpChrome\Chrome;


$chrome=new Chrome('https://youtube.com','/usr/bin/google-chrome');
$chrome->setOutputDirectory(__DIR__);

// Invoke download
try {
	$chrome->download($chrome->getPdf());
} catch (Exception $e) {
	print($e->getMessage());
}
