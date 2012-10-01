<?php
//mysql database configuration
Human::log("MYSQL");
//DbManager::$cnx = new DbConnection( "server", "db-name" , "user-name", "password" );
DbManager::$cnx= new DbConnection( "localhost", "POVtest" , "root", "shicshoc" );
DbManager::$autoTables = true;




