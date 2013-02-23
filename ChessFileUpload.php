<?php
/**
 * Class for file uploads. 
 * User: Alf Magne
 * Date: 03.02.13
 */
class ChessFileUpload extends LudoDBModel implements LudoDBService
{
    protected $JSONConfig = true;
    private static $tempPath;
    protected $validExtensions = null;

    const FILE_UPLOAD_KEY = 'FILE_UPLOAD_PATH';

    public function __construct($id = null)
    {
        if (!isset(self::$tempPath)) {
            self::$tempPath = LudoDBRegistry::get(self::FILE_UPLOAD_KEY);
            if (!isset(self::$tempPath)) {
                throw new Exception("Temp path for file uploads not set. Use LudoDBRegistry::set(self::FILE_UPLOAD_KEY, 'your/path'); to set path", 500);
            }
        }
        parent::__construct($id);
    }

    public function getValidServices(){
        return array('save','read');
    }

    public static function setUploadPath($path){
        LudoDBRegistry::set(self::FILE_UPLOAD_KEY, $path);
    }

    public function save()
    {
        if(!CurrentPlayer::getInstance()->hasAccessTo(ChessRoles::LOGIN)){
            throw new Exception("You do not have access to upload files");
        }
        $this->extractUploadedFile();
        $this->commit();
        return $this->getId();
    }

    private function extractUploadedFile()
    {

        if (empty($_FILES)) {
            throw new LudoDBException("No files uploaded", 400);
        }

        $file = array_shift($_FILES);
        $this->setValue('file_size', $file['size']);
        $this->setValue('display_name', $file['name']);
        $this->setValue('created_date', date("Y-m-d H:i:s"));
        $this->setValue('user_id', CurrentPlayer::getInstance()->getId());
        $tempPath = $this->getTempPath($file['name']);
        $this->setValue('path_on_server', $tempPath);
        move_uploaded_file($file['tmp_name'], $tempPath);

        if(!file_exists($tempPath)){

            copy($file['tmp_name'], $tempPath);
            if(!file_exists($tempPath)){
                throw new LudoDBException("Could not write temp file " . $file['tmp_name'] . " to " . LudoDBRegistry::get(self::FILE_UPLOAD_KEY));
            }
        }
    }

    public function getPathOnServer(){
        return $this->getValue('path_on_server');
    }

    private function getTempPath($filename)
    {
        $extension = $this->getExtension($filename);
        return LudoDBRegistry::get(self::FILE_UPLOAD_KEY) . "/uploaded" . date("YmdHis") . '-' . rand(10000, 99999) . "." . $extension;
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

    public function validateArguments($service, $arguments){
        return true;
    }

    public function validateServiceData($service, $arguments){
        switch($service){
            case "save":
                return isset($_FILES) && !empty($_FILES);
            default:
                return true;
        }
    }
}
