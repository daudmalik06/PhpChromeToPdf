<?php
include '../vendor/autoload.php';

use dawood\phpChrome\Chrome;

//in this example we will put output in default output directory of library

$chrome=new Chrome('https://youtube.com','/usr/bin/google-chrome');
print "Pdf successfully generated :".$chrome->getPdf().PHP_EOL;

