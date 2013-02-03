<?php
/**
 * Class for file uploads. 
 * User: Alf Magne
 * Date: 03.02.13
 * Time: 00:41
 */
class ChessFileUpload extends LudoDBModel
{
    protected $JSONConfig = true;
    private static $tempPath;
    protected $validExtensions = null;

    public static $validServices = array('save','read');

    public function __construct($id = null)
    {
        if (!isset(self::$tempPath)) {
            self::$tempPath = LudoDBRegistry::get('FILE_UPLOAD_PATH');
            if (!isset(self::$tempPath)) {
                throw new Exception("Temp path for file uploads not set. Use LudoDBRegistry::set('FILE_UPLOAD_PATH', 'your/path'); to set path", 500);
            }
        }
        parent::__construct($id);
    }

    public function save($values)
    {
        $this->extractUploadedFile();
        return parent::save($values);
    }

    private function extractUploadedFile()
    {
        if (empty($_FILES)) {
            throw new Exception("No files uploaded", 400);
        }
        $file = array_shift($_FILES);
        $this->setValue('file_size', $file['size']);
        $this->setValue('display_name', $file['name']);
        $this->setValue('created_date', date("Y-m-d H:i:s"));
        $tempPath = $this->getTempPath($file['name']);
        $this->setValue('path_on_server', $tempPath);
        move_uploaded_file($file['tmp_name'], $tempPath);
    }

    private function getTempPath($filename)
    {
        $extension = $this->getExtension($filename);
        return LudoDBRegistry::get('FILE_UPLOAD_PATH') . "/uploaded" . date("YmdHis") . '-' . rand(10000, 99999) . "." . $extension;
    }

    private function getExtension($filename)
    {
        if (!strstr($filename, '.')) {
            return strtolower($filename);
        }
        $posPeriod = strrpos($filename, ".");
        $ret = strtolower(substr($filename, $posPeriod + 1));
        if (isset($this->validExtensions) && !in_array($ret, $this->validExtensions)) {
            throw new Exception("Invalid upload file type", 400);
        }
        return $ret;
    }
}
