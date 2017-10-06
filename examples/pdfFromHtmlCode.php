<?php

include '../vendor/autoload.php';

use dawood\phpChrome\Chrome;

$chrome=new Chrome(null, '/usr/bin/google-chrome');
$chrome->useHtml("<h2>I am test Pdf</h2>");

print "Pdf successfully generated :".$chrome->getPdf().PHP_EOL;
//print "screenShot successfully generated :".$chrome->getScreenShot().PHP_EOL;
