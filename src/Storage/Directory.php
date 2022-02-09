<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-02-09 09:03:52
 * @modify date 2022-02-09 09:03:54
 * @license GPLv3
 * @desc [description]
 */

namespace Zein\Storage;

use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\UnableToCreateDirectory;

class Directory
{
    /**
     * Filesystem instance based adapter
     */
    private $Filesystem = null;

    /**
     * Error Message
     */
    private $Error;

    /**
     * Directory scope
     */
    private array $ListDirectory = [];

    /**
     * Get filesystem instance
     * 
     * @param string $directoryName
     * @return Filesystem
     */
    private function getFileSystem(string $directoryName)
    {
        if (is_null($this->{$directoryName})) die('No adapter available!' . PHP_EOL);
        return new Filesystem($this->{$directoryName});
    }

    /**
     * Create directory based scope
     * 
     * @param string $parentDirectory
     * @param string $newDirectoryName
     * @return bool
     */
    public function createIn(string $parentDirectory, string $newDirectoryName)
    {
        $Filesystem = $this->getFileSystem($parentDirectory);

        try {
            return $Filesystem->createDirectory($newDirectoryName);
        } catch (UnableToCreateDirectory $e) {
            $this->Error = $e->getMessage();
            return false;
        }
    }


    /**
     * Create directory based scope
     * 
     * @param string $parentDirectory
     * @param array $newDirectoryName
     * @return bool
     */
    public function createBatchIn(string $parentDirectory, array $newDirectoryName)
    {
        $Filesystem = $this->getFileSystem($parentDirectory);

        $this->Error = [];
        foreach ($newDirectoryName as $Directory) {
            try {
                $Filesystem->createDirectory($Directory);
            } catch (UnableToCreateDirectory $e) {
                $this->Error[] = $e->getMessage();
            }
        }
    }

    /**
     * Create director based scope
     * 
     * @param string $parentDirectory
     * @param string $newDirectoryName
     * @return bool
     */
    public function listOf(string $parentDirectory, string $currentDirectory = '/', bool $recursive = true)
    {
        $Filesystem = $this->getFileSystem($parentDirectory);

        return $Filesystem->listContents($currentDirectory);
    }

    /**
     * Getter for Error poperty
     * 
     * @return string
     */
    public function getError()
    {
        return $this->Error;
    }

    /**
     * Magic method to organize scope function
     * 
     * @param string $methodName
     * @param array $arguments
     * @return void
     */
    public function __call($methodName, $arguments)
    {
        foreach (get_class_methods($this) as $methodInClass) {
            if (preg_match('/'.$methodInClass.'/i', $methodName))
            {
                $parentDirectory = str_replace($methodInClass, '', $methodName);
                return call_user_func_array([$this, $methodInClass], array_merge([strtolower($parentDirectory)], $arguments));
                break;
            }
        }

        exit('Gak ada');
    }

    /**
     * Magic method to set ListDirectory scope
     * 
     * @param string $directory
     * @param string $directoryPath
     * @return void
     */
    public function __set($directory, $directoryPath)
    {
        $this->ListDirectory[$directory] = new LocalFilesystemAdapter($directoryPath);
    }

    /**
     * Magic method to get scope list
     * 
     * @param string $directory
     * @return void
     */
    public function __get($directory)
    {
        if (array_key_exists($directory, $this->ListDirectory)) return $this->ListDirectory[$directory];
    }
}