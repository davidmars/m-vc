<?php
//mysql database configuration
DbManager::$cnx = new DbConnection( "server", "db-name" , "user-name", "password" );
DbManager::$autoTables = true;


