<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-02-10 10:13:07
 * @modify date 2022-02-10 10:13:07
 * @license GPLv3
 * @desc [description]
 */

 namespace Zein\Storage\Local;

trait UploadGuard
{
    public function limitSize(int $Maxsize)
    {

    }

    public function streamExists(string $Key)
    {
        return isset($_FILES[$Key]);
    }
}