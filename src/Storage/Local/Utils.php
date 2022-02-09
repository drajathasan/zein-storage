<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-02-09 17:35:14
 * @modify date 2022-02-09 20:25:40
 * @license GPLv3
 * @desc [description]
 */

namespace Zein\Storage\Local;

trait Utils
{
    /**
     * Check if directory is exists or not
     *
     * @param string $DirectoryName
     * @param string $childPath
     * @return boolean
     */
    public function isExists(string $DirectoryName, string $childPath = '/')
    {
        $getContents = $this->listOf($DirectoryName);

        if (!is_null($getContents) && $childPath === '/') return true;

        foreach ($getContents as $Contents) {
            if ($Contents->path() === $childPath) return true;
        }

        return false;
    }
}