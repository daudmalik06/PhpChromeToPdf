<?php
/*
 * This file is part of PhpChromeToPdf.
 *
 * @author      Dawood Ikhlaq
 * @copyright   Copyright (c) 2017 PhpChromeToPdf
 */

use dawood\phpChrome\Chrome;
use PHPUnit\Framework\TestCase;

class ChromeTestSuite extends TestCase
{
    protected $binaryPath = '/usr/bin/google-chrome';

    public function testChromeConstructorProperlySettingValues()
    {
        $url = 'http://example.com';
        $chrome = new Chrome($url, $this->binaryPath);
        $this->assertEquals($url, $chrome->getUrl());
        $this->assertEquals($this->binaryPath, $chrome->getBinaryPath());
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
        $chrome->setBinaryPath($this->binaryPath);
        $chrome->setArguments($arguments);

        foreach ($arguments as $argument => $value) {
            $this->assertArrayHasKey($argument, $chrome->getArguments());
            $this->assertEquals($value, $chrome->getArguments()[$argument]);
        }
    }

    public function testSetBinaryPath()
    {
        $chrome = new Chrome();
        $chrome->setBinaryPath($this->binaryPath);
        $this->assertEquals($this->binaryPath, $chrome->getBinaryPath());
    }

    public function testSetChromeDirectory()
    {
        $chrome = new Chrome();
        $userDirectory = '/usr/tmp';
        $chrome->setChromeDirectory($userDirectory);
        $chromeArguments = $chrome->getArguments();
        $this->assertArrayHasKey('user-data-dir=', $chromeArguments);
        $this->assertEquals($userDirectory, $chromeArguments['user-data-dir=']);
    }

    public function testSetArgument()
    {
        $chrome = new Chrome();
        $chrome->setArgument('   test     ', '           Nothing         ');
        $this->assertArrayHasKey('test=', $chrome->getArguments());
        $this->assertEquals('Nothing', $chrome->getArguments()['test=']);
    }

    public function testSetUrl()
    {
        $chrome = new Chrome();
        $chrome->setUrl('http://google.com');
        $this->assertEquals('http://google.com', $chrome->getUrl());
    }

    public function testSetOutputDirectory()
    {
        $chrome = new Chrome();
        $chrome->setOutputDirectory('/usr/home/');
        $this->assertEquals('/usr/home/', $chrome->getOutputDirectory());
    }

    public function testGetPdf()
    {
        $chrome = new Chrome();
        $chrome->setBinaryPath($this->binaryPath);

        $pdfLocation = $chrome->getPdf();
        $this->deleteFile($pdfLocation);
        $this->assertNotEmpty($pdfLocation);
    }

    public function testGetScreenshot()
    {
        $chrome = new Chrome();
        $chrome->setBinaryPath($this->binaryPath);

        $imageLocation = $chrome->getScreenShot();
        $this->deleteFile($imageLocation);
        $this->assertNotEmpty($imageLocation);
    }

    /**
     * deletes provided file.
     *
     * @param string $file
     *
     * @return bool
     */
    private function deleteFile($file)
    {
        if (!file_exists($file)) {
            return false;
        }

        unlink($file);
    }

    public function testUseHtmlFile()
    {
        $chrome = new Chrome();
        $htmlFile = __DIR__ . '/index.html';
        file_put_contents($htmlFile, '');
        $chrome->useHtmlFile($htmlFile);
        $this->assertEquals('file://' . $htmlFile, $chrome->getUrl());
        @unlink($htmlFile);
    }

    public function testUseHtmlCode()
    {
        $chrome = new Chrome();
        $htmlCode = '<h1>hello world</h1>';
        $chrome->useHtml($htmlCode);
        $this->assertEquals('data:text/html,' . rawurlencode($htmlCode), $chrome->getUrl());
    }

    public function testSetBinaryShouldThrowException()
    {
        $chrome = new Chrome();
        $binaryPath = '/usr/wrong/google-chrome';
        $this->expectException(\Exception::class);
        $chrome->setBinaryPath($binaryPath);
    }

    public function testPdfPath()
    {
        $chrome = new Chrome();
        $chrome->setBinaryPath($this->binaryPath);

        $pdfLocation = $chrome->getPdf('/tmp/test');
        $this->deleteFile($pdfLocation);
        $this->assertEquals('/tmp/test.pdf', $pdfLocation);
    }

    public function testScreenShotPath()
    {
        $chrome = new Chrome();
        $chrome->setBinaryPath($this->binaryPath);

        $imageLocation = $chrome->getScreenShot('/tmp/jan');
        $this->deleteFile($imageLocation);
        $this->assertEquals('/tmp/jan.jpg', $imageLocation);
    }
}
