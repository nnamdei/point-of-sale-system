<?php
namespace App\Matto;
use Session;

class FileUpload{
    public $slugs = array();
    public $totalSuccess = 0;
    public $report = 'Something went wrong';

    private $request;
    private $name;
    private $title;
    private $path;
    
    public function __construct($request,$name = 'photo',$title = '',$path = 'public/images'){
        $this->request = $request;
        $this->name = $name;
        $this->title = ($title == '' ? 'image-'.time() : $title);
        $this->path = $path;

        if(is_array($request->$name)){
            $files = $request->$name;
            for($i = 0; $i<count($files); $i++){
               if($this->upload($files[$i],str_slug($this->title.'-'.$i.'-'.time()))){
                    $this->totalSuccess++;
               }
            }
        }
        else{
            if($this->upload($request->$name,str_slug($this->title))){
                $this->totalSuccess = 1;
             }
        }
            
        $this->report =  $this->totalSuccess.' files uploaded';;
         }

    private function upload($filebag,$nameToStore){
			//Get file with the extension_loaded
			$fileNameWithExt = $filebag->getClientOriginalName();
			//Get just filename
			$fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
			//Get Extension
			$fileExt = $filebag->getClientOriginalExtension();
            //Filenames to store
            $slug = $nameToStore.".$fileExt";
			//Upload image
			if($filebag->storeAs($this->path,$slug)){
                array_push($this->slugs, $slug);
                return true;
            }
                return false;

    }
        
}
?>