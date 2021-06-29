<?php
/**
 * This file is part of the mime files.
 * Copyright, 2021 by the mime org.
 */

if (isset($_POST['upload']))
{
    uploadFile($_FILES['mimefile']);
}

function uploadFile(array $file)
{
    if ($file['error'])
    {
        echo "Error " . $file['error']. " - Your upload failed!";
        return false;
    }
    
    $mime = mime_content_type($file['tmp_name']);
    
    if (strpos($mime, 'image') !== 0)
    {
        echo "Error 9 - Please upload only mime images!";
        return false;
    }
    
    $data = file_get_contents($file['tmp_name']);
    
    if (stripos($data, '<?php') !== false)
    {
        echo "Error 10 - You are an evil hacker!"; # This does not seem to help :/
        return false;
    }
    
    $dir = "upload/" . session_id();
    @mkdir($dir, 0x777, true); # create upload dir
    
    $path = 'upload/'.session_id().'/'.$file['name'];
    
    if (!rename($file['tmp_name'], $path))
    {
        echo "Error 11 - Cannot move uploaded file.";
        return false;
    }
    
    echo "Your file has been uploaded!";
    return true;
}
