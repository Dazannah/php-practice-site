<?php

// json response with php
header('Content-Type: application/json');
$response = "success";
$dataToSend = array("message" => $response);
echo json_encode($dataToSend);

?>