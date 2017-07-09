<?php
/**
 * Created by PhpStorm.
 * User: dawood ikhlaq <daudmalik06@gmail.com>
 * Date: 7/6/2017
 * Time: 10:53 PM
 */

namespace dawood\phpChrome;

use mikehaertl\shellcommand\Command;
use PHPUnit\Runner\Exception;

class Chrome
{
    private $binaryPath;
    private $arguments;
    private $url;
    private $outPutDirectory;

    /**
     * Chrome constructor.
     * @param null|string $url ,the url to convert to pdf
     * @param null|string $binaryPath , location of google-chrome installed on your machine
     * if no binaryPath is provided default will be used which is
     * /usr/bin/google-chrome
     */
    function __construct($url=null, $binaryPath=null)
    {
        //some necessary default options
        $this->setArguments(
            [
                '--headless'=>'',
                '--disable-gpu'=>'',
            ]
        );
        $this->setOutputDirectory(str_replace('src','tmp',realpath(__DIR__)));
        if(!$binaryPath)
        {
            $binaryPath='/usr/bin/google-chrome';
        }
        $this->setBinaryPath($binaryPath);
        if($url)
        {
            $this->setUrl($url);
        }
    }

    /**
     * set the path of binary of google-chrome
     * @param null|string $binaryPath
     * @throws \Exception
     */
    public function setBinaryPath($binaryPath=null)
    {
        if(!$binaryPath)
        {
            throw new \Exception("No binary Bath Is provided");
        }
        $this->binaryPath=trim($binaryPath);
    }

    /**
     * Directory where the browser stores the user profile
     * @param null $location
     * @throws \Exception
     */
    public function setChromeDirectory($location=null)
    {
        if(!$location)
        {
            throw new \Exception("No binary Bath Is provided");
        }
        $this->setArgument('user-data-dir',$location);
    }
    /**
     * add provided argument to $this->arguments array
     * @param string $argument
     * @param string $value
     */
    public function setArgument($argument, $value)
    {
        $argument=trim($argument);
        if(!empty($value) && !strstr($argument,'='))
        {
            $argument.='=';
        }
        $this->arguments[$argument]=trim($value);
    }

    /**
     * set provided arguments
     * @param array $options
     */
    public function setArguments(array $arguments)
    {
        foreach ($arguments as $argument=>$value)
        {
            $this->setArgument($argument,$value);
        }
    }

    /**
     * set the url to convert to pdf
     * @param null|string $url
     * @throws \Exception
     */
    public function setUrl($url=null)
    {
        if(!$url)
        {
            throw new \Exception('No url provided');
        }
        $this->url=trim($url);
    }

    /**
     * convert the provided url to pdf and return the pdf's location
     * @return string
     */
    public function getPdf()
    {
        $pdfName=md5(time().mt_rand()).'.pdf';
        while(!$this->UniqueName($pdfName))
        {
            $pdfName=rand().$pdfName;
        }
        $printArray=[
            '--print-to-pdf='=>$this->outPutDirectory.'/'.$pdfName,
        ];
        $allArguments=array_merge($printArray,$this->arguments);
        if(!$this->executeChrome($allArguments))
        {
            throw new Exception("Some Error Occurred While Getting Pdf");
        }
        return $this->outPutDirectory.'/'.$pdfName;
    }

    /**
     * convert the provided url to image and return the image's location
     * @return string
     */
    public function getScreenShot()
    {
        $imageName=md5(time().mt_rand()).'.jpg';
        while(!$this->UniqueName($imageName))
        {
            $imageName=rand().$imageName;
        }
        $printArray=[
            '--screenshot='=>$this->outPutDirectory.'/'.$imageName,
        ];
        $allArguments=array_merge($printArray,$this->arguments);
        if(!$this->executeChrome($allArguments))
        {
            throw new Exception("Some Error Occurred While Getting Image");
        }
        return $this->outPutDirectory.'/'.$imageName;
    }

    /**
     * set the output directory to save the pdf and screenshotss
     * @param null $directory
     * @throws \Exception
     */
    public function setOutputDirectory($directory=null)
    {
        if(!$directory)
        {
            throw new \Exception('No url provided');
        }
        $this->outPutDirectory=trim($directory);
        if(!file_exists($directory))
        {
            @mkdir($directory);
        }
    }

    /**
     * execute the chrome using all the provided options
     * @param array $arguments
     */
    private function executeChrome(array $arguments)
    {
        $command = new Command($this->binaryPath);
        foreach ($arguments as $argument=>$value)
        {
            $command->addArg($argument,$value?$value:null);
        }
        $command->addArg($this->url,null);
        if (!$command->execute())
        {
            echo $command->getError().PHP_EOL.'exit Code:'.$command->getExitCode();
            return false;
        }
        unset($command);
        return true;
    }

    /**
     * check if provided fileName exist in our output directory
     * @param string $fileName
     * @return bool , true if provided fileName is unique i.e not present in output directory
     *                false if provided fileNae is not unique , i.e is present in output directory
     */
    private function UniqueName($fileName)
    {
        if(file_exists($this->outPutDirectory.'/'.$fileName))
        {
            return false;
        }
        return true;
    }

    /**
     * set chrome window size
     * @param integer $width
     * @param integer $height
     */
    public function setWindowSize($width, $height)
    {
        $this->setArgument('--window-size',$width.','.$height);
    }

    /**
     *  tell's the chrome to use mobile screen
     */
    public function useMobileScreen()
    {
        $this->setArgument('--user-agent','Mozilla/5.0 (Linux; U; Android 4.0.3; ko-kr; LG-L160L Build/IML74K) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30');
    }

    /**
     * return $this->url
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * return currently used binary path
     * @return mixed
     */
    public function getBinaryPath()
    {
        return $this->binaryPath;
    }

    /**
     * @return mixed arguments to use with chrome
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @return string the output directory to be used by chrome
     */
    public function getOutPutDirectory()
    {
        return $this->outPutDirectory;
    }

}