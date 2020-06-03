<?php


class filedetails {
    var $fileowner;
    var $createddate;
    var $filesize;
    var $file;
    var $filepath;
    function __construct($owner, $filedate, $file, $filesize, $filepath){
        $this->fileowner=$owner;
        $this->createddate=$filedate;
        $this->filesize = $filesize;
        $this->file= $file;
        $this->filepath =$filepath;
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

class pdffiles{
   var $pdffiles;
   function __construct(){
       $this->pdffiles= array();
   }
   // Define a function to output files in a directory
    function outputFiles($path){
        $valid_files = array('pdf');
        // Check directory exists or not
        if(file_exists($path) && is_dir($path)){
            // Search the files in this directory
            $files = glob($path ."*.*");
            if(count($files) > 0){
                // Loop through retuned array
                foreach($files as $file){
                    if(is_file("$file")){
                        $ext = pathinfo($file, PATHINFO_EXTENSION);
                        if(in_array($ext, $valid_files)){
                            $date = date("F d Y H:i:s", filectime($file));
                            $size = filesize($file);
                            $owner = fileowner($file);
                            $filepath = $file;
                            $pdfdetails = new filedetails($owner, $date, basename($file), $size, $filepath);
                            array_push($this->pdffiles, $pdfdetails); 
                        }
                    } else if(is_dir("$file")){
                        // Recursively call the function if directories found
                        $this->outputFiles("$file");
                    }
                }
                
            }
        }
    }

  function get_pdf_files(){
      return $this->pdffiles;
  }
}

// Comparator function used for comparator 
// createddate of two object/files 
function comparator($object1, $object2) { 
    $datetime1 = strtotime($object1->createddate); 
    $datetime2 = strtotime($object2->createddate); 
    return $datetime2 - $datetime1;
} 


$pdf_file_instance = new pdffiles(); 
// Call the function
$pdf_file_instance->outputFiles("C:/Users/SbuMassango/Downloads/");
// echo json_encode($pdf_file_instance->get_pdf_files());

 $file_data_objects_array = $pdf_file_instance->get_pdf_files();
//Sorting the files
usort($file_data_objects_array, 'comparator');
//Picking the first thress files.
$latest_files_in_dir = array_slice($file_data_objects_array, 0, 3);
// All files in the directory.
//echo json_encode($file_data_objects_array);
// Get the latest three files in the director.
echo json_encode($latest_files_in_dir);
?>