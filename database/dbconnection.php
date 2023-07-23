<?php

/*
Database management class

This class povides centalize access of DB connection
*/

function getDbConnecion()
{
    $host = 'localhost';
    $user = 'u481218741_root';
    $password = "Group12#Group12#";
    $db_name = 'u481218741_movies';
    $connection = new mysqli($host, $user, $password, $db_name);

    if (!$connection) {
        die("Failed to connect with MySQL: " . mysqli_connect_error());
    }

    return $connection;
}
