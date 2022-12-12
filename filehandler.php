<?php

global $fileDir;

function moveFile($file, $filePrefix,$location){
    global $fileDir;

    $fileName = $file["name"];
    $fileType = $file["type"];
    $fileTempName = $file["tmp_name"]; 
    $fileError = $file["error"];
    $fileSize = $file["size"];
    $fileExtension = explode(".",$fileName);
    $fileActualExt = strtolower(end($fileExtension));
    $allowedFiles = array("jpg","jpeg","png");
    if(in_array($fileActualExt,$allowedFiles)){
        if($fileError===0){
            #5000000bytes=5mb
            if($fileSize<5000000){ 
                $fileNameNew = uniqid($filePrefix,false).".".$fileActualExt;
                $fileDestination = "images/".$location."/".$fileNameNew;
                move_uploaded_file($fileTempName,$fileDestination);
                $fileDir = $fileDestination;
            }else{
                echo "has to be less than 5mb";
            }
        }else{
            echo "There was an error!";
        }
    }else{
        echo "Can't upload file of this type!";
    }

}

function getFileDir(){
    global $fileDir;
    return $fileDir;
}

function deleteOldFile($filename){
    if(file_exists($filename)){
        unlink($filename);
    }
}