<?php
$username='trungvq';
$password='aum@1999';
$db = new Mongo('mongodb://localhost', array(
  'username' => 'abc',
  'password' => 'abc@123',
  'db'       => 'abc'
));
// connect to mongodb
$m = new MongoClient();
echo "Connection to database successfully";
  // select a database
$db = $m->examplesdb;
echo "Database examplesdb selected";