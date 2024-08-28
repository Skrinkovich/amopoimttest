<?php 

function operationsWithFile($fileName, $delimeter)
{
	$filePath = 'files/'.$fileName;
	$fileContents = file_get_contents($filePath);
	$parts = explode($delimeter, $fileContents);
	$lines = array();
	foreach ($parts as $index => $part) {
		preg_match_all('/\d/', $part, $matches);
		$digitCount = count($matches[0]);   
		array_push($lines, htmlspecialchars($part)." = ". $digitCount ); 
	}
	return $lines;
}

function processRequest($PostData)
{
	$returnData = array();  
	$delimeter = "";
    if (isset($PostData['delimeter']) && !empty($PostData['delimeter'])) {  
        $delimeter = htmlspecialchars($PostData['delimeter'], ENT_QUOTES, 'UTF-8'); 
    } else {  $returnData = $returnData + array("error" => "разделитель не введен."); }
    if (isset($_FILES['file']) and $delimeter != "") {
        $file = $_FILES['file'];
		 
        if ($file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'files/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, true);
            } 
			
            $filePath = $uploadDir . basename($file['name']);

            if (move_uploaded_file($file['tmp_name'], $filePath)) {  
				//$returnData = $returnData + array("error" => "Файл загружен.");
            } else {
				$returnData = $returnData + array("error" => "Файл не перемещен."); 
            }
			try {
					$taskResult = operationsWithFile(basename($file['name']), $delimeter);
					$returnData = $returnData + array("result" => $taskResult);  
				} 
			catch (Exception $e) {
				$returnData = $returnData + array("error" => 'Ошибка при выполнении операции обработки файла: '. $e);   
				}
        } else { 
			$returnData = $returnData + array("error" => 'Ошибка загрузки файла: ' . $file['error']); 
        }
    } 
	else {
		$returnData = $returnData + array("error" => 'Файл не выбран');  
    }
	return $returnData;
}

function responseBack($toAnswer)
{ 
	echo json_encode($toAnswer);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
	$producedResult = processRequest($_POST);
	responseBack($producedResult);
} else {
	responseBack(array( array("error" => 'не верный запрос'))); 
}
?>
