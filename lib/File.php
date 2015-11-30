<?php
//File.php takes in a .yml file and converts it to a .json file

class File {
	public $filename;
	public $handle;
    public $fileContentsString;
    public $fileContentsArray;

    public function openFile($filename = 'data/reports.yml'){
        $this->filename = $filename;
        $this->handle = fopen($this->filename, 'r');
        echo "hello";
    }

    public function readFileContents(){
        $fileContentsString = fread($this->handle, filesize($this->filename));

        $this->fileContentsString = $fileContentsString;
    }

    public function cleanFileContents ()
    {   
        $fileContentsArray = explode("\n", trim($this->fileContentsString));

        foreach ($fileContentsArray as $line) {
            $firstTwoChars = substr($line, 0, 2);

            if ($firstTwoChars[0] == '-' && $firstTwoChars[1] == '-') {
                array_shift($fileContentsArray);
            } else {
                break;
            }
        }
        $this->$fileContentsArray = $fileContentsArray;
    }

 //    public function parseContactsArray()
 //    {
 //        //Create the associative array
 //        foreach ($this->fileContentsArray as $incidentLine) {
 //            $incidentArray[] = array (
 //                'accountID' => $this->fileContentsArray[0],
 //                'ID' => $this->fileContentsArray[1],
 //                'location' => $this->fileContentsArray[2],
 //                'notes' => $this->fileContentsArray[3]
 //                'reportType' => $this->fileContentsArray
 //                );
 //        }
 //        return $companyEmployeesInfoArray;
 //    }       

	// public function writeToFile()
 //    {
 //    	$data = date("Y-m-d") . ' ' . date("H:i:s") . ' [' . $logLevel . '] ' . $message;
 //    	fwrite($this->handle, $data . PHP_EOL);
 //    }	

    public function __destruct()
    {
		fclose($this->handle);
    }
}
