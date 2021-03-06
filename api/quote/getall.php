<?php 

 // Headers
 header('Access-Control-Allow-Origin: *');

 //the data will be output in json format
 header('Content-Type: application/json');

 include_once '../../classes/Dbase.php';
 require_once '../../classes/Quote.php';

 // instantiate db & connect
 $database = new Dbase();
 $db = $database->connect();


 // instantiate blog post object

 $quote = new Quote($db);

 //get result statement 
 $result = $quote->getAll();
 //get row count
 $num = $result->rowCount();

 // var_dump($num);


 // check if any posts
 if($num > 0) {
 	//post array
 	$quotesArray = array();
 	$quotesArray['data'] = array();

 	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
 		extract($row);

 		$quoteItem = array(
 			'id' => $id,
 			'quote' => html_entity_decode($quote),
 			'author' => $author
 		);

 		//Push to 'data' index of the quotesArray
 		array_push($quotesArray['data'], $quoteItem);
 	}


 	// covert data to json format
 	echo json_encode($quotesArray);

 } else {

 	//if no quote is found
 	echo json_encode(
 		array('message' => 'No Quote Found')
 	);

 }