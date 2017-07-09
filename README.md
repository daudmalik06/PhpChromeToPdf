PHP ChromeToPdf
===============

PHP ChromeToPdf provides a simple and clean interface to ease PDF and image creation with
[Google Chrome](https://www.google.com/chrome/). **The `Google Chrome`
must be installed and working on your system.** See the section below for details.



## History
Every time i had convert url to pdf or to take screenshot of some url
i had to install several libraries , i know there are very good libraries available 
like phantomJs,wkhtmltopdf and some others...
but there are always rendering issue 
<br>like some supports <b>bootstrap</b> ,some not some time <b>html5 problem</b> etc..
<br>and this was all annoying
so i decided to make this little wrapper around chrome 
<br>
by using chrome results i achieved following results.
<ul><b>No more css issues (bootstrap,css3 )</b></ul>
<ul><b>No more html5 issues</b></ul>
<ul><b>No more need to use xvfb</b></ul>

<b>in-fact painless conversion</b>


## Installation

Install the package through [composer](http://getcomposer.org):

```
composer require dawood/phpchromepdf
```

Make sure, that you include the composer [autoloader](https://getcomposer.org/doc/01-basic-usage.md#autoloading)
somewhere in your codebase.

## Examples
There are several examples provided in examples folder too


### Url To PDF (accessing site as  bigger browser)

```php

use dawood\phpChrome\Chrome;


$chrome=new Chrome('https://youtube.com','/usr/bin/google-chrome');
$chrome->setOutputDirectory(__DIR__);
//not necessary to set window size
$chrome->setWindowSize($width=1477,$height=768);
print "Pdf successfully generated :".$chrome->getPdf().PHP_EOL;



```


### Url To PDF (accessing site as  mobile browser)

```php

use dawood\phpChrome\Chrome;

$chrome=new Chrome('https://facebook.com','/usr/bin/google-chrome');
$chrome->setOutputDirectory(__DIR__);
$chrome->useMobileScreen();
//not necessary to set window size
$chrome->setWindowSize($width=768,$height=768);
print "Pdf successfully generated :".$chrome->getPdf().PHP_EOL;

```


### Take screenshot of url (accessing site as  bigger browser)

```php

use dawood\phpChrome\Chrome;


$chrome=new Chrome('https://facebook.com','/usr/bin/google-chrome');
$chrome->setOutputDirectory(__DIR__);
//not necessary to set window size
$chrome->setWindowSize($width=1366,$height=1024);
print "Image successfully generated :".$chrome->getScreenShot().PHP_EOL;



```

### Take screenshot of url (accessing site as  mobile browser)

```php

use dawood\phpChrome\Chrome;


$chrome=new Chrome('https://facebook.com','/usr/bin/google-chrome');
$chrome->setOutputDirectory(__DIR__);
$chrome->useMobileScreen();

//not necessary to set window size
$chrome->setWindowSize($width=768,$height=768);
print "Image successfully generated :".$chrome->getScreenShot().PHP_EOL;


```



## Setting options

The `google-chrome` shell command accepts different types of options:
for complete list of options you can visit 
https://peter.sh/experiments/chromium-command-line-switches/

 

### Wrapper Methods


 * `constructor`: Accepts $url to visit(for pdf/screenshot) as first parameter 
 you can pass this as null and later use `setUrl`, and second parameter is binary
 path of google-chrome installed in your system as second parameter if no binaryPath is provided
 is uses default location `/usr/bin/google-chrome`
 but you still can provide binary path later using `setBinaryPath`,
 constructor also put some default arguments like 
 `headless , disable-gpu` which are necessary for google-chrom to work on cli
 * `setBinaryPath` which accepts binary path and set it for you
 * `setArguments` to set options of google-chrome it accepts array of options in a format
 ```
 [
    $argument1=>$value1,
    $argument2=>$value2,  
 ]
 ```
if your argument doesn't has values like `--headless` you can pass empty value 
 e.g
 `[--headless=>'']`
* `setArgument` to set option of google-chrome it accepts two parameter $argument , $value
 if your argument doesn't has a value like `--headless` you can pass empty value e.g
 `setArgument('--headless','')`
 
* `setChromeDirectory` the directory where google-chrome will save your profile
    it is not mandatory as google-chrome by default uses some directory but in need 
    you can use this method to change that
* `setUrl` to set the url to convert to pdf or to take screenshot    

* `setOutputDirectory` directory to save the output (screenshots and pdf) the
default directory is library/tmp

* `getPdf` it will convert your provided url to pdf and return the 
location of newly saved pdf

* `getScreenShot` it will take screenshot of your provided url and return the 
location of newly saved image

* `setWindowSize` you can set the chrome window size using this method 
it accepts two parameters $width and $height

* `useMobileScreen` ask chrome to access site as mobile browser
 
* `getArguments` returns all the arguments set
 
there are some other getters available too in case you need
 `getUrl , getBinaryPath , getOutPutDirectory`





## Note for Windows users
until now i can't properly test this on windows so if you wanna try
please try it and if it goes successful please send me a pull request 
Thanks



## Installation of google-Chrome
```shell
wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | sudo apt-key add - 
sudo sh -c 'echo "deb http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google.list'

sudo apt-get install libxss1 libappindicator1 libindicator7 libosmesa6

sudo apt-get update
sudo apt-get install -y google-chrome-stable

sudo ln -s /usr/lib/x86_64-linux-gnu/libOSMesa.so.6 /opt/google/chrome/libosmesa.so

```
then try running `google-chrome` from shell to verify it's installation


## License 
The <b>PhpChromeToPdf</b> is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contribution
Thanks to all of the contributors ,
fork this repository and send me a pull request

## Author
Dawood Ikhlaq and Open source community