<?php
/**
 * Created by PhpStorm.
 * User: dawood ikhlaq
 * Date: 7/8/2017
 * Time: 3:08 PM
 */
include '../vendor/autoload.php';

use dawood\phpChrome\Chrome;


$chrome=new Chrome('https://facebook.com','/usr/bin/google-chrome');
$chrome->setOutputDirectory(__DIR__);
$chrome->useMobileScreen();

//not necessary to set window size
$chrome->setWindowSize($width=768,$height=768);
print "Image successfully generated :".$chrome->getScreenShot().PHP_EOL;

