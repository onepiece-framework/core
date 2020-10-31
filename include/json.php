<?php

if(($_SERVER['CONTENT_TYPE'] ?? null) === 'application/json' ){
	$input = file_get_contents("php://input");
	$_POST = json_decode($input, true);
}
