<?php
/**
 * Created by PhpStorm.
 * User: daudm
 * Date: 7/8/2017
 * Time: 3:08 PM
 */
include '../vendor/autoload.php';

use dawood\phpChrome\Chrome;


$chrome=new Chrome('https://facebook.com','/usr/bin/google-chrome');
$chrome->setOutputDirectory(__DIR__);
//not necessary to set window size
$chrome->setWindowSize($width=1366,$height=1024);
print "Image successfully generated :".$chrome->getScreenShot().PHP_EOL;

