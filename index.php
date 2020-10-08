<?php

   //get movies from the json file 
   function getMovies($jsonFile){
       $jsondata = file_get_contents($jsonFile);
       $movies = json_decode($jsondata, true);
       return $movies;
      }
   function dbConnect(){
   $servername = "localhost";
   $username = "root";
   $password = "peter123";
   $result = false;
   //return new PDO("mysql:host=$servername;dbname=movies", $username, $password);
   try {
   $conn = new PDO("mysql:host=$servername;dbname=movies", $username, $password);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $result=$conn;
   }catch(PDOException $e) {
    "Connection failed: " . $e->getMessage();
   }
   return $result;
    }
   function insertRecords(){
   $conn=dbConnect();
   if(!$conn){
   return "Check your db connection";
   }
   $sql = $conn->prepare("SELECT movieID,mymovies.name as moviename,genre.name as genre FROM mymovies INNER JOIN genre ON mymovies.genreID=genre.genreID");
   $sql->setFetchMode(PDO::FETCH_ASSOC);
   $sql->execute();
   if($sql->rowCount() = 0) {
      $mymovies=getMovies("/home/peter/Downloads/download.json");
      foreach ($mymovies as $movie) {
      $title=$movie["title"];
      $movieid=$movie["movieID"];
      $genre=$movie["genre"];
      
      $genre_result = "INSERT INTO genre (name) VALUES ('$genre')";
      $conn->exec($genre_result);
      $lastgenre_id = $conn->lastInsertId();
      
      $movie_result = "INSERT INTO mymovies (movieID, name, genreID) VALUES ('$movieid','$title','$lastgenre_id')";
     $conn->exec($movie_result);
         }
   }else{
      return "Result already exist in the db";
   }
   
   }
   function displayRecords(){
      $conn=dbConnect();
      if(!$conn){
      return "Check your db connection";
      }
   $sql = $conn->prepare("SELECT movieID,mymovies.name as moviename,genre.name as genre FROM mymovies INNER JOIN genre ON mymovies.genreID=genre.genreID");
   $sql->setFetchMode(PDO::FETCH_ASSOC);
   $sql->execute();
   if($sql->rowCount() != 0) {

      ?>
      <table border="0">
         <tr COLSPAN=2 BGCOLOR="#6D8FFF">
            <td>ID</td>
            <td>Movie Name</td>
            <td>Genre</td>
         </tr>
       <?php     
       while($row=$sql->fetch()) 
       {
            echo "<tr>".
                 "<td>".$row["movieID"]."</td>".
                 "<td>".$row["moviename"]."</td>".
                 "<td>".$row["genre"]."</td>".
                 "</tr>";
       }
      
      }
      else
      {
           echo "don't exist records for list on the table";
      }
      
      ?>
      </table>
      <?php
   }
      insertRecords();
      displayRecords();
 ?>
