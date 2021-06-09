<?php
$username='trungvq';
$password='aum@1999';
// connect to mongodb
$m = new MongoDB\Driver\Manager("mongodb://localhost:27019", array("username" => $username, "password" => $password,"database"=>'admin')) ;

/* $bulk  = new MongoDB\Driver\BulkWrite;
$document = array(
  "_id" => new MongoDB\BSON\ObjectID,
  "cdate" => time(), 
  "title" => "Thêm logs", 
  "contents" => 'test logs student',
  "by" => "tuyennx"
);
$bulk ->insert($document);
$m->executeBulkWrite('AUMSYS.studentlogs', $bulk );  */

$filter = [];
$options = [];

$query = new MongoDB\Driver\Query($filter, $options);
$cursor = $m->executeQuery('AUMSYS.studentlogs', $query);

foreach ($cursor as (array)$document) {
    $document->title."<br/>";
}

/* */

/* var_dump($m);
echo "Connection to database successfully";
// select a database
$db = $m->selectDataBase("aumsys");
echo "Database mydb selected";
//$collection = $db->createCollection("studentlogs");
$collection = $db->studentlogs;
echo "Collection selected succsessfully";
$collection->insert($document);
echo "Document inserted successfully";  */
die();