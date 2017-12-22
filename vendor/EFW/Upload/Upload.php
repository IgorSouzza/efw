<?php

namespace EFW\Upload;
use EFW\StringHelper\StringHelper;

class Upload
{
    private $uploadDir;
    private $uploadFile;
    private $fileName;
    private $folder;
    private $fileType;
    private $image;
    
    public function uploadImage(string $folder = null)
    {
        $this->image = $_FILES['img'];
        $this->folder = $folder;
        $this->uploadDir = "uploads" . DIRECTORY_SEPARATOR . "posts". DIRECTORY_SEPARATOR . date("Y") . DIRECTORY_SEPARATOR  . date("m") . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR;
        $this->uploadFile = $this->uploadDir . rand().basename(StringHelper::checkFileName($this->image['name']));
        $this->fileName = basename(StringHelper::checkFileName($this->image['name']));
        $this->fileType = pathinfo($this->uploadFile, PATHINFO_EXTENSION);

        if($this->checkDir() && $this->image['size'] < 1000000){
            if($this->fileType == "jpg" || $this->fileType == "jpeg" || $this->fileType == "png"){
                if(move_uploaded_file($this->image['tmp_name'], $this->uploadFile)) {
                    return true;
                } else {
                    echo "Possível ataque de upload de arquivo!\n";
                    return false;
                }
            }
            else{
                echo "Somente imagens JPG, JPEG, PNG são permitidas!";
                return false;
            }
        }
        else{
            echo "Tamanho do arquivo é muito grande!";
            return false;
        }
    }

    public function getFileDir()
    {
        return $this->uploadFile;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    private function checkDir()
    {
        if(file_exists($this->uploadDir)){
            $this->createDir(); 
            return true;         
        }
        else{
            $this->createDir(); 
            return true;        
        }
    }

    private function createDir()
    {
        if(!file_exists("uploads")){
            mkdir("uploads", 0777, true);
        }
        if(!file_exists($this->uploadDir)){
            mkdir($this->uploadDir, 0777, true);            
        }
    }
}