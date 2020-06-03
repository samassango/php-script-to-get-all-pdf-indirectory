<?php

class filedetails {
    var $fileowner;
    var $createddate;
    var $filesize;
    var $file;
    function __construct($owner, $filedate, $file, $filesize){
        $this->fileowner=$owner;
        $this->createddate=$filedate;
        $this->filesize = $filesize;
        $this->file= $file; 
    }

    public function set_file_owner($owner){
        $this->fileowner = $owner;
    }

    public function set_file_modified_date($filedate){
        $this->createddate = $filedate;
    }

    public function set_file_size($size){
        $this->filesize = $size;
    }

    public function set_file($file){
        $this->file = $file; 
    }

    public function get_file_owner(){
        return $fileowner;
    }
    public function get_file_modified_date(){
        return $this->$createddate;
    }

    public function get_file_size(){
        return $this->$filesize;
    }

    public function get_file(){
        return $this->$file; 
    }
    
}
  
// Comparator function used for comparator 
// createddate of two object/files 
function comparator($object1, $object2) { 
    $datetime1 = strtotime($object1->createddate); 
    $datetime2 = strtotime($object2->createddate); 
    return $datetime2 - $datetime1;
} 
// The file path you want to pick the documents from.
$files_dir_path = realpath("C:/Users/SbuMassango/Downloads/"); 
 
$pdffiles = array();
$pdffilesdetails = array();
$valid_files = array('pdf');
if(is_dir($files_dir_path)){
  foreach(scandir($files_dir_path) as $file){
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    if(in_array($ext, $valid_files)){
        $date = date("F d Y H:i:s", filectime($files_dir_path."/".$file));
        $size = filesize($files_dir_path."/".$file);
        $owner = fileowner($files_dir_path."/".$file);
        $pdfdetails = new filedetails($owner, $date, $file, $size);
      array_push($pdffiles, $pdfdetails);
    }   
 }
}

$file_data_objects_array = $pdffiles;
//Sorting the files
usort($file_data_objects_array, 'comparator');
//Picking the first thress files.
$latest_files_in_dir = array_slice($file_data_objects_array, 0, 3);
// All files in the directory.
//echo json_encode($file_data_objects_array);
// Get the latest three files in the director.
echo json_encode($latest_files_in_dir);
?>