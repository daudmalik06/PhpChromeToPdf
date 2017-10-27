PHP ChromeToPdf
===============

[![Latest Stable Version](https://poser.pugx.org/dawood/phpchromepdf/v/stable.svg)](https://packagist.org/packages/dawood/phpchromepdf)
[![Total Downloads](https://poser.pugx.org/dawood/phpchromepdf/downloads)](https://packagist.org/packages/dawood/phpchromepdf)
[![License](https://poser.pugx.org/dawood/phpchromepdf/license.svg)](https://packagist.org/packages/dawood/phpchromepdf)


PHP ChromeToPdf provides a simple and clean interface to easily create PDFs and images with
[Google Chrome](https://www.google.com/chrome/). **`Google Chrome`
must be installed and working on your system.** See the section below for details.



## History
Every time that I've converted a url to pdf or taken screenshot of some url
I had to install several libraries. 

I understand that there are very good libraries available such as: **phantomJs, wkhtmltopdf** and others,
but there have always been rendering issues.  

Some libraries support **bootstrap** while others do not. There are also intermittent **html5 problems** etc.  All of these problems were considerably annoying, 
therefore I decided to make this little wrapper around **Chrome**. I have achieved following results:  
* **No more css issues (bootstrap, css3 )**
* **No more html5 issues**
* **No need to use xvfb**

**in-fact it's a painless conversion**


## Installation

Install the package through [composer](http://getcomposer.org):

```
composer require dawood/phpchromepdf
```

Make sure, that you include the composer [autoloader](https://getcomposer.org/doc/01-basic-usage.md#autoloading)
somewhere in your codebase.

## Examples
There are several examples provided in examples folder as well 

### Url To PDF (accessing site as a desktop browser)

```php

use dawood\phpChrome\Chrome;


$chrome=new Chrome('https://youtube.com','/usr/bin/google-chrome');
$chrome->setOutputDirectory(__DIR__);
//not necessary to set window size
$chrome->setWindowSize($width=1477,$height=768);
print "Pdf successfully generated :".$chrome->getPdf().PHP_EOL;



```


### Url To PDF (accessing site as mobile browser)

```php

use dawood\phpChrome\Chrome;

$chrome=new Chrome('https://facebook.com','/usr/bin/google-chrome');
$chrome->setOutputDirectory(__DIR__);
$chrome->useMobileScreen();
//not necessary to set window size
$chrome->setWindowSize($width=768,$height=768);
print "Pdf successfully generated :".$chrome->getPdf().PHP_EOL;

```


### Take screenshot of the url (accessing site as desktop browser)

```php

use dawood\phpChrome\Chrome;


$chrome=new Chrome('https://facebook.com','/usr/bin/google-chrome');
$chrome->setOutputDirectory(__DIR__);
//not necessary to set window size
$chrome->setWindowSize($width=1366,$height=1024);
print "Image successfully generated :".$chrome->getScreenShot().PHP_EOL;



```

### Take screenshot of the url (accessing site as mobile browser)

```php

use dawood\phpChrome\Chrome;


$chrome=new Chrome('https://facebook.com','/usr/bin/google-chrome');
$chrome->setOutputDirectory(__DIR__);
$chrome->useMobileScreen();

//not necessary to set window size
$chrome->setWindowSize($width=768,$height=768);
print "Image successfully generated :".$chrome->getScreenShot().PHP_EOL;


```

### Take screenshot of the Html File

```php

include '../vendor/autoload.php';

use dawood\phpChrome\Chrome;

$chrome=new Chrome(null,'/usr/bin/google-chrome');
$chrome->useHtmlFile(__DIR__.'/index.html');
print "Image successfully generated :".$chrome->getScreenShot().PHP_EOL;



```

### convert Html file to pdf
```php

include '../vendor/autoload.php';

use dawood\phpChrome\Chrome;

$chrome=new Chrome(null,'/usr/bin/google-chrome');
$chrome->useHtmlFile(__DIR__.'/index.html');
print "Pdf successfully generated :".$chrome->getPdf().PHP_EOL;


```


### convert Html code to pdf / screenshot
```php

include '../vendor/autoload.php';

use dawood\phpChrome\Chrome;

$chrome=new Chrome(null,'/usr/bin/google-chrome');
$chrome->useHtml("<h2>I am test html</h2>");
print "Pdf successfully generated :".$chrome->getPdf().PHP_EOL;
print "screenShot successfully generated :".$chrome->getScreenShot().PHP_EOL;


```

### convert Html code to pdf / screenshot and save at the desired location
```php

include '../vendor/autoload.php';

use dawood\phpChrome\Chrome;

$chrome=new Chrome(null,'/usr/bin/google-chrome');
$chrome->useHtml("<h2>I am test html</h2>");
print "Pdf successfully generated :".$chrome->getPdf("/tmp/mypdf.pdf").PHP_EOL;
print "screenShot successfully generated :".$chrome->getScreenShot("/tmp/hello/test.jpg").PHP_EOL;


```



## Setting options

The `google-chrome` shell command accepts different types of arguments, 
for the complete list of arguments you can visit
https://peter.sh/experiments/chromium-command-line-switches/



### Wrapper Methods


 * `constructor`: Accepts the $url to visit(for pdf/screenshot) as the first parameter.
 You can pass this as null and later use `setUrl`. The second parameter is the binary
 path of google-chrome installed in your system. If no binaryPath is specified
 it uses the default location `/usr/bin/google-chrome`.
 You can still provide a binary path later using the `setBinaryPath`
 constructor. Default arguments like
 `headless, disable-gpu` are necessary for google-chrome to work on cli
 * `setBinaryPath` Accepts a binary path and sets it for you
 * `setArguments` sets arguments for google-chrome, it accepts an array of arguments in a format
 ```
 [
    $argument1=>$value1,
    $argument2=>$value2,  
 ]
 ```
If your argument does not have values like `--headless` you can pass an empty value
 e.g
 `[--headless=>'']`
* `setArgument` to set arguments for google-chrome. It accepts two parameters `$argument, $value`
 if your argument does not have a value like `--headless` you can pass an empty value e.g
 `setArgument('--headless','')`

* `setChromeDirectory` the directory where google-chrome will save your profile, 
    it is not mandatory as google-chrome by default uses a save directory of its own, however,
    you can use this method to change that according to your requirements
* `setUrl` to set the url to convert to pdf or to take screenshot    

* `useHtmlFile` to use the file instead of the url to convert to pdf or to take screenshot    

* `useHtml` to use the html code instead of the url to convert to pdf or to take screenshot    

* `setOutputDirectory` directory to save the output (screenshots and pdf) the
default directory is a temporary directory of your operating system

* `getPdf` receives an optional path parameter to save the pdf file.
If not specified it will save in the output directory or the temp directory of your
operating system depending on whether or not you set up the output directory.  
For this check the `setOutputDirectory` option, which will convert your provided url to pdf and return the
location of the newly saved pdf

* `getScreenShot` receives an optional path parameter to save the pdf file.
If not provided it will save in the output directory or the temp directory of your
operating system depending on whether or not you set up the output directory for this check `setOutputDirectory` option. It will take a screenshot of your provided url and return the
location of newly saved image

* `setWindowSize` you can set the chrome window size using this method.
It accepts two parameters `$width` and `$height`

* `useMobileScreen` instructs chrome to access site as mobile browser

* `getArguments` returns all the arguments set

there are some other getters available as well, depending on your requirements
 `getUrl , getBinaryPath , getOutputDirectory`





## Installation of google-Chrome (linux/mac )
```shell
wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | sudo apt-key add -
sudo sh -c 'echo "deb http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google.list'

sudo apt-get install libxss1 libappindicator1 libindicator7 libosmesa6

sudo apt-get update
sudo apt-get install -y google-chrome-stable

sudo ln -s /usr/lib/x86_64-linux-gnu/libOSMesa.so.6 /opt/google/chrome/libosmesa.so

```

then try running `google-chrome` from shell to verify it's installation



## Installation of google-Chrome (Windows)
```
Just Install updated version of chrome(after V 61.*)  
that-s it
```

then try running `C:\Program Files (x86)\Google\Chrome\Application>chrome.exe --headless` from cmd terminal to verify it's installation  

> Note  the path of chrome directory can be different in your case  

## License
The **PhpChromeToPdf** is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contribution
Thanks to all of the contributors ,  
Check [Contribution](CONTRIBUTING.md) for contribution rules

## Author
Dawood Ikhlaq and Open source community
