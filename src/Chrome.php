<?php
/*
 * This file is part of PhpChromeToPdf.
 *
 * @author      Dawood Ikhlaq
 * @copyright   Copyright (c) 2017 PhpChromeToPdf
 */

namespace dawood\phpChrome;

use Exception;
use mikehaertl\shellcommand\Command;

class Chrome
{
    /**
     * The location of the Chrome binary to be used.
     *
     * @var string
     */
    private $binaryPath;

    /**
     * A list of arguments to execute Chrome with.
     *
     * @var string
     */
    private $arguments;

    /**
     * The url that should be converted to a PDF.
     *
     * @var string
     */
    private $url;

    /**
     * The directory to be used as output.
     *
     * @var string
     */
    private $outputDirectory;

    /**
     * The command being executed.
     *
     * @var mikehaertl\shellcommand\Command;
     */
    private $command;

    /**
     * Chrome constructor.
     *
     * If you don't know the Executable Path, launch Chrome and visit chrome://version.
     *
     * @param string $url             The url to convert to a pdf
     * @param string $binaryPath      Location of google-chrome installed on your machine
     * @param string $outputDirectory Directory to save the output
     */
    public function __construct($url = '', $binaryPath = '', $outputDirectory = null)
    {
        // Set default options
        $this->setArguments([
            '--headless' => '',
            '--disable-gpu' => '',
            '--incognito' => '',
            '--enable-viewport' => '',
        ]);

        $this->setOutputDirectory($outputDirectory ?: sys_get_temp_dir());

        if ($binaryPath) {
            $this->setBinaryPath($binaryPath);
        }

        if ($url) {
            $this->setUrl($url);
        }
    }

    /**
     * Set the binary to use for executing Chrome.
     *
     * @param string $binaryPath
     */
    public function setBinaryPath($binaryPath)
    {
        $this->binaryPath = trim($binaryPath);
        $this->abortIfChromeIsNotInstalled();
    }

    /**
     * Set the location of the browser's user profile.
     *
     * @param string $location
     */
    public function setChromeDirectory($location)
    {
        $this->setArgument('user-data-dir', $location);
    }

    /**
     * Add a single provided argument to the arguments to run Chrome with.
     *
     * @param string $argument
     * @param string $value
     */
    public function setArgument($argument, $value)
    {
        $argument = trim($argument);
        $value = trim($value);
        if (!$argument) {
            return;
        }
        if ($value && !preg_match('/=$/', $argument)) {
            $argument .= '=';
        }

        $this->arguments[$argument] = $value;
    }

    /**
     * Set a list of arguments.
     *
     * @param array $arguments
     */
    public function setArguments(array $arguments)
    {
        foreach ($arguments as $argument => $value) {
            $this->setArgument($argument, $value);
        }
    }

    /**
     * Set the target URL.
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = trim($url);
    }

    /**
     * Convert the provided URL to a PDF and return its location.
     *
     * @param null|string $pdfPath The path to the PDF
     *
     * @return string
     *
     * @throws Exception
     */
    public function getPdf($pdfPath = null)
    {
        if ($pdfPath && !preg_match('/\.pdf$/', $pdfPath)) {
            $pdfPath .= '.pdf';
        }
        $pdfName = $this->getUniqueName('pdf');

        $location = $pdfPath ?: $this->outputDirectory . DIRECTORY_SEPARATOR . $pdfName;
        $printArray = [
            '--print-to-pdf=' => $location,
        ];

        $allArguments = array_merge($printArray, $this->arguments);
        if (!$this->executeChrome($allArguments)) {
            throw new Exception('Error #' . $this->command->getExitCode() . ' while creating PDF: '
                . $this->command->getError());
        }

        return $location;
    }

    /**
     * Convert the provided url to image and return the image's location.
     *
     * @param null|string $imagePath desired location and file to save the screenshot file
     *                               e.g /home/my.jpg
     *
     * @return string
     *
     * @throws Exception
     */
    public function getScreenShot($imagePath = null)
    {
        if ($imagePath && !strstr($imagePath, '.jpg') && !strstr($imagePath, '.png')) {
            $imagePath .= '.jpg';
        }

        $screenshotPath = $imagePath ?: $this->outputDirectory . '/' . $this->getUniqueName('jpg');
        $printArray = [
            '--screenshot=' => $screenshotPath,
        ];

        $allArguments = array_merge($printArray, $this->arguments);
        if (!$this->executeChrome($allArguments)) {
            throw new Exception('An error occured while getting the image');
        }

        return $screenshotPath;
    }

    /**
     * Set the output directory for PDF and screenshots.
     *
     * @param string $directory
     */
    public function setOutputDirectory($directory)
    {
        $this->outputDirectory = trim($directory);

        if (!file_exists($directory)) {
            @mkdir($directory);
        }
    }

    /**
     * Execute Chrome using all provided arguments.
     *
     * @param array $arguments
     *
     * @return bool
     */
    private function executeChrome(array $arguments)
    {
        $this->command = new Command($this->binaryPath);
        foreach ($arguments as $argument => $value) {
            $this->command->addArg($argument, $value ?: null);
        }

        $this->command->addArg($this->url, null);

        if (!$this->command->execute()) {
            echo $this->command->getError() . PHP_EOL;
            echo 'Exit code: ' . $this->command->getExitCode() . PHP_EOL;

            return false;
        }

        return true;
    }

    /**
     * Check if the provided file is unique and doesn't already exist in the
     * output directory.
     *
     * @param string $fileName
     *
     * @return bool
     */
    private function isUniqueName($fileName)
    {
        return !file_exists($this->outputDirectory . DIRECTORY_SEPARATOR . $fileName);
    }

    /**
     * Set the size of  the Chrome window.
     *
     * @param int $width
     * @param int $height
     */
    public function setWindowSize($width, $height)
    {
        $this->setArgument('--window-size', $width . ',' . $height);
    }

    /**
     * Sets a mobile user agent for Chrome.
     */
    public function useMobileScreen()
    {
        $this->setArgument('--user-agent', 'Mozilla/5.0 (Linux; U; Android 4.0.3; ko-kr; LG-L160L Build/IML74K) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30');
    }

    /**
     * Set the provided filename as the target url using the file:// protocol.
     *
     * @param string $file
     *
     * @throws Exception if file not found
     */
    public function useHtmlFile($file)
    {
        if (!file_exists($file)) {
            throw new Exception("$file not found");
        }

        $this->setUrl("file://$file");
    }

    /**
     * Allow using html code to be converted to pdf or to take screenshot.
     *
     * @param string $html
     */
    public function useHtml($html)
    {
        $this->setUrl('data:text/html,' . rawurlencode($html));
    }

    /**
     * Throws an exception if the provided chrome binary is not available.
     *
     * @throws Exception
     */
    private function abortIfChromeIsNotInstalled()
    {
        $command = new Command(trim($this->binaryPath . ' --version'));
        $command->execute();

        $error = $command->getError();
        if ($error && (!strstr($error, 'Google Chrome') || !strstr($error, 'Chromium'))) {
            throw new Exception('Problem in running Chrome\'s binary: ' . $error);
        }
    }

    /**
     * Returns a unique filename with the given extension.
     *
     * @return string
     */
    private function getUniqueName($extension)
    {
        do {
            $name = md5(time() . mt_rand()) . '.' . $extension;
        } while (!$this->isUniqueName($name));

        return $name;
    }

    /**
     * Gets the Url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the path of the currently used binary.
     *
     * @return string
     */
    public function getBinaryPath()
    {
        return $this->binaryPath;
    }

    /**
     * Gets a list of all arguments that Chrome is launched with.
     *
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Get the output directory to be used by Chrome.
     *
     * @return string
     */
    public function getOutputDirectory()
    {
        return $this->outputDirectory;
    }
}
