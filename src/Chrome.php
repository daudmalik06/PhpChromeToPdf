<?php
/**
 * Created by PhpStorm.
 * User: dawood ikhlaq <daudmalik06@gmail.com>
 * Date: 7/6/2017
 * Time: 10:53 PM
 */

namespace dawood\phpChrome;

use mikehaertl\shellcommand\Command;

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
                '--incognito'=>'',
                '--enable-viewport'=>'',
            ]
        );
        $this->setOutputDirectory(sys_get_temp_dir());
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
        $this->abortIfChromeIsNotInstalled();
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
     * @param string|null $pdfPath desired location and file to save the pdf file
     * e.g /home/my.pdf
     * @return string
     * @throws \Exception
     */
    public function getPdf($pdfPath=null)
    {
        if($pdfPath && !strstr($pdfPath,".pdf"))
        {
            $pdfPath.=".pdf";
        }
        $pdfName=$this->returnUniqueName("pdf");
        $printArray=[
            '--print-to-pdf='=>$pdfPath?$pdfPath:$this->outPutDirectory.'/'.$pdfName,
        ];
        $allArguments=array_merge($printArray,$this->arguments);
        if(!$this->executeChrome($allArguments))
        {
            throw new \Exception("Some Error Occurred While Getting Pdf");
        }
        return $pdfPath?$pdfPath:$this->outPutDirectory.'/'.$pdfName;
    }

    /**
     * convert the provided url to image and return the image's location
     * @param string|null $imagePath $ImagePath desired location and file to save the screenshot file
     * e.g /home/my.jpg
     * @return string
     * @throws \Exception
     */
    public function getScreenShot($imagePath=null)
    {
        if($imagePath && !strstr($imagePath,".jpg") && !strstr($imagePath,".png"))
        {
            $imagePath.=".jpg";
        }
        $imageName=$this->returnUniqueName("jpg");
        $printArray=[
            '--screenshot='=>$imagePath?$imagePath:$this->outPutDirectory.'/'.$imageName,
        ];
        $allArguments=array_merge($printArray,$this->arguments);
        if(!$this->executeChrome($allArguments))
        {
            throw new \Exception("Some Error Occurred While Getting Image");
        }
        return $imagePath?$imagePath:$this->outPutDirectory.'/'.$imageName;
    }

	/**
	 * Download pdf
	 *
     * @param string|null $pdfPath desired location and file to save the pdf file
     * e.g /home/my.pdf
	 * @return file
	 * @throws \Exception
	 */
	public function downloadPdf($pdfPath=null)
	{
		return $this->download($this->getPdf($pdfPath));
	}

	/**
	 * Download screenshot
	 *
     * @param string|null $imagePath desired location and file to save the screenshot file
     * e.g /home/my.jpg
	 * @return file
	 * @throws \Exception
	 */
	public function downloadScreenShot($imagePath=null)
	{
		return $this->download($this->getScreenShot($imagePath));
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
     * Download file to browser
     *
     * @param string $path path to download from
     * @return file pdf or image that is downloaded
     * @throws \Exception
     */
    private function download($path)
    {
        if (!file_exists($path)) {
            throw new \Exception($path.' does not exist or is not readable');
        }

		if (PHP_SAPI === 'cli') {
			throw new \Exception('Cannot download from CLI');
		}

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="'.basename($path).'"');
        header('Pragma: public');
        header('Content-Length: ' . filesize($path));
        readfile($path);
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

    /**
     * set the provided file as current url with file:// protocol
     * @param string $file
     * @throws \Exception if file not found
     */
    public function useHtmlFile($file)
    {
        if(!file_exists($file))
        {
            throw new \Exception("$file not found");
        }
        $this->setUrl("file://".$file);
    }

    /**
     * allow using html code to be converted to pdf or to take screenshot
     * @param string|null $html
     * @throws \Exception
     */
    public function useHtml($html=null)
    {
        if(!$html)
        {
            throw new \Exception("No html provided");
        }
        $this->setUrl('data:text/html,' . rawurlencode($html));
    }

    /**
     * @throws \Exception if the provided chrome's binary is not available/installed
     */
    private function abortIfChromeIsNotInstalled()
    {
        $command = new Command(trim($this->binaryPath.' --version'));
        $command->execute();
        if($command->getError() && (!strstr($command->getError(),"Google Chrome") || !strstr($command->getError(),"Chromium")))
        {
            throw new \Exception("there is problem in running provided chrome's binary Error message is :".$command->getError());
        }
    }

    private function returnUniqueName($extension)
    {
        $uniqueName=md5(time().mt_rand()).'.'.$extension;
        while(!$this->UniqueName($uniqueName))
        {
            $uniqueName=rand().$uniqueName;
        }
        return $uniqueName;
    }

}
