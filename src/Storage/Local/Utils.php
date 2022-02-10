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

    /**
     * Bypass chaning method
     */
    public function nextIfError()
    {
        return !empty($this->Error);  
    }

    /**
     * Convert filesize to byte
     * 
     * @param string $Format
     */
    public function toByteSize(string $Format) {
        $Unitmap = ['B'=> 0, 'KB'=> 1, 'MB'=> 2, 'GB'=> 3, 'TB'=> 4, 'PB'=> 5, 'EB'=> 6, 'ZB'=> 7, 'YB'=> 8];
        $InjectUnit = strtoupper(trim(substr($Format, -2)));

        if (intval($InjectUnit) !== 0) {
            $InjectUnit = 'B';
        }

        if (!in_array($InjectUnit, array_keys($Unitmap))) {
            return false;
        }

        $intervalUnits = trim(substr($Format, 0, strlen($Format) - 2));
        if (!intval($intervalUnits) == $intervalUnits) {
            return false;
        }

        return $intervalUnits * 1024;
    }
}