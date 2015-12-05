<?php 

require_once '../lib/File.php';

function ymlToJson ($ymlFilename)
{
	$filename = new File();
	$filename->openFile($ymlFilename);
	$filename->readFileContents();
	$filename->cleanFileContents();
	$filename->createAssociativeArray();
	$jsonFilename = $filename->createFile('data/reports.json');
	$filename->writeJSONFile();

	return $jsonFilename;
}

$jsonFilename = ymlToJson('data/reports.yml');
//comments