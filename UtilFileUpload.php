<?php
/*
 * @Author : ndione24
 * twitter : @NdioneNdione1
 */



class UtilFileUpload
{
    private array $files;
    private string $filename = "";
    private array $errors = [];
    private $maxSize = null;
    private string $targetDirectory=""; // default current directory

    private ?array $acceptedExtensions = null;


    function __construct(array $files)
    {
        $this->files = $files;
    }


    public function generateName()
    {
        $name = basename($this->files["name"]);
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $this->filename = uniqid() . "." . $extension;
        return $this;
    }


    public function acceptedExtensions($acceptedExtensions)
    {
        $this->acceptedExtensions = $acceptedExtensions;
        return $this;
    }


    public function getError()
    {
        return $this->errors;
    }


    public function process()
    {
        // check type
        if (!is_null($this->acceptedExtensions)) {
            if (!in_array(pathinfo(basename($this->files["name"]), PATHINFO_EXTENSION), $this->acceptedExtensions)) {
                $this->errors[] = "file type not accepted";
                return;
            }
        }

        if(strlen($this->targetDirectory)==0){
            $this->targetDirectory =getcwd();
        }
        
        // check size
        if (!is_null($this->maxSize)) {
            if ($this->files["size"] > $this->maxSize) {
                $this->errors[] = "exceeded size limit";
                return;
            }
        }

        if ($this->files["error"] == UPLOAD_ERR_OK) {
            $tmp_name = $this->files["tmp_name"];
            if (strcmp($this->filename, "") == 0) {
                $this->filename = $tmp_name;
            }
            if (!move_uploaded_file($tmp_name, $this->targetDirectory . DIRECTORY_SEPARATOR . $this->filename)) {
                echo $this->targetDirectory;
                echo "Err ********" . $this->files["error"];
                $this->errors[] = "Please check permission of your target Directory";
            }
        } else {
            $this->errors[] = "Error for uploading";
        }

    }


    public function moveTo($directory)
    {
        $this->targetDirectory = $directory;
        return $this;
    }


    function setName($filename)
    {
        $this->filename = $filename;
    }


    function getFilename()
    {
        return $this->filename;
    }


    function sizeLimit($maxSize)
    {
        $this->maxSize = $maxSize;
        return $this;
    }


}
