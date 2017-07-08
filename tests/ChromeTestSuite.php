<?php
use dawood\phpChrome\Chrome;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: dawood Ikhlaq
 * Date: 7/8/2017
 * Time: 6:02 PM
 */
class ChromeTestSuite extends TestCase
{

    public function testChromeConstructorProperlySettingValues()
    {
        $url = 'http://example.com';
        $binaryPath = '/usr/bin/google-chrome';
        $chrome = new Chrome($url, $binaryPath);
        $this->assertEquals($url, $chrome->getUrl());
        $this->assertEquals($binaryPath, $chrome->getBinaryPath());
    }

    public function testSetArguments()
    {
        $arguments = [
            '--headless' => '',
            '--disable-gpu' => '',
            '--hide-scrollbars' => '',
            '----timeout=' => '6000',
        ];
        $chrome = new Chrome();
        $chrome->setArguments($arguments);
        foreach ($arguments as $argument => $value) {
            $this->assertArrayHasKey($argument, $chrome->getArguments());
            $this->assertEquals($value, $chrome->getArguments()[$argument]);
        }
    }

    public function testSetBinaryPath()
    {
        $chrome = new Chrome();
        $binaryPath='/usr/local/google-chrome';
        $chrome->setBinaryPath($binaryPath);
        $this->assertEquals($binaryPath,$chrome->getBinaryPath());
    }

    public function testSetChromeDirectory()
    {
        $chrome=new Chrome();
        $userDirectory='/usr/tmp';
        $chrome->setChromeDirectory($userDirectory);
        $chromeArguments=$chrome->getArguments();
        $this->assertArrayHasKey('user-data-dir=',$chromeArguments);
        $this->assertEquals($userDirectory,$chromeArguments['user-data-dir=']);
    }

    public function testSetArgument()
    {
        $chrome=new Chrome;
        $chrome->setArgument('   test     ','           Nothing         ');
        $this->assertArrayHasKey('test',$chrome->getArguments());
        $this->assertEquals('Nothing',$chrome->getArguments()['test']);
    }

    public function testSetUrl()
    {
        $chrome=new Chrome();
        $chrome->setUrl('http://google.com  ');
        $this->assertEquals('http://google.com',$chrome->getUrl());
    }

    public function testSetOutputDirectory()
    {
        $chrome=new Chrome();
        $chrome->setOutputDirectory('/usr/home/   ');
        $this->assertEquals('/usr/home/',$chrome->getOutPutDirectory());
    }

    public function testGetPdf()
    {
        $chrome=new Chrome();
        $pdfLocation=$chrome->getPdf();
        $this->deleteFile($pdfLocation);
        $this->assertNotEmpty($pdfLocation);
    }

    public function testGetScreenshot()
    {
        $chrome=new Chrome();
        $imageLocation=$chrome->getScreenShot();
        $this->deleteFile($imageLocation);
        $this->assertNotEmpty($imageLocation);
    }

    /**
     * deletes provided file
     * @param string $file
     */
    private function deleteFile($file)
    {
        if(!file_exists($file))
        {
            return false;
        }
        unlink($file);
    }
}