<?php
//File.php takes in a .yml file and converts it to a .json file
//comments

class File {
	public $filename;
    public $resultsFile;
	public $handle;
    public $fileContentsString;
    public $fileContentsArray;
    public $incidentAssociativeArray;

    public function openFile($filename = 'data/reports.yml'){
        $this->filename = $filename;
        $this->handle = fopen($this->filename, 'r');
    }

    public function readFileContents(){
        $fileContentsString = fread($this->handle, filesize($this->filename));

        $this->fileContentsString = $fileContentsString;
    }

    public function cleanFileContents ()
    {   
        $this->fileContentsArray = explode("\n", trim($this->fileContentsString));

        array_shift($this->fileContentsArray);

        foreach ($this->fileContentsArray as $index => $line) {
            $this->fileContentsArray[$index] = trim($line);
            $firstChar = substr($line, 0, 1);
            if ($firstChar == '-')
            {
                $line = substr($line, 2);
                $this->fileContentsArray[$index] = $line;
            }
        }
        // $this->fileContentsArray = $fileContentsArray;
        // print_r($this->fileContentsArray);
    }   

    public function createAssociativeArray()
    {
        //Create the associative array
        foreach ($this->fileContentsArray as $incidentLine) {
            if ($incidentLine != "") 
            {
                $splitIncidentLine = explode(": ", $incidentLine);
                switch ($splitIncidentLine[0]) {
                    case 'account_id':
                        $associativeArrayItem['accountID'] = $splitIncidentLine[1];
                        break;
                    case 'id':
                        $associativeArrayItem['ID'] = $splitIncidentLine[1];
                        break;
                    case 'n': //latitude
                        $associativeArrayItem['latitude'] = $splitIncidentLine[1];
                        break;
                    case 't': //longitude
                        $associativeArrayItem['longitude'] = $splitIncidentLine[1];
                        break;
                    case 'notes': 
                        $associativeArrayItem['notes'] = $splitIncidentLine[1];
                        break;
                    case 'report_type': 
                        $associativeArrayItem['reportType'] = $splitIncidentLine[1];
                        $this->incidentAssociativeArray[] = $associativeArrayItem;    
                        break;
                    default: //string == location
                        break;
                }
            }  //end of if statement
            array_shift($this->fileContentsArray);
        }  //end of foreach
    }       

    public function createFile($filename = 'data/reports.json'){
        $this->resultsFile = $filename;
        //open file and append to the end of the file
        $this->handle = fopen($this->resultsFile, 'a');

        return $filename;
    }

    public function writeJSONFile ()
    {
        fwrite($this->handle, json_encode(array_values($this->incidentAssociativeArray)));
    }

    public function __destruct()
    {
		fclose($this->handle);
        //close file opened for reading - is this going to close both opened files
    }
}
