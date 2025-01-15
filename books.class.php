<?php
require_once 'database.php';
class Book{
   public $id = '';
   public $title = '';
   public $author = '';
   public $genre = '';
   public $publisher = '';
   public $date = '';
   public $edition = '';
   public $copies = '';
   public $format = '';
   public $age_group = '';
   public $rating = '';

   protected $db;
   function __construct()
   {
    $this -> db = new Database();
   }

   function add(){
    $sql = "INSERT INTO books (title, author, genre, publisher, publication_date,edition, number_of_copies, format, age_group, rating ) VALUES (:title, :author, :genre, :publisher, :publication_date, :edition, :number_of_copies, :format, :age_group, :rating); ";

    $query = $this -> db -> connect() -> prepare($sql);
    $query -> bindParam(':title', $this -> title);
    $query -> bindParam(':author', $this -> author);
    $query -> bindParam(':genre', $this -> genre);
    $query -> bindParam(':publisher', $this -> publisher);
    $query -> bindParam(':publication_date', $this -> date);
    $query -> bindParam(':edition', $this -> edition);
    $query -> bindParam(':number_of_copies', $this -> copies);
    $query -> bindParam(':format', $this -> format);
    $query -> bindParam(':age_group', $this -> age_group);
    $query -> bindParam(':rating', $this -> rating);

    if($query -> execute()){
        return true;
    } else {
        return false;
    }
   }

   function checkDuplicate($title, $author, $genre, $publisher, $publication_date,$edition, $number_of_copies, $format, $age_group, $rating){
    $age_group = implode(", ", $age_group);
        $sql = "SELECT title, author, genre, publisher, publication_date,edition, number_of_copies, format, age_group, rating from books WHERE title = '$title' AND  author = '$author' AND genre ='$genre' AND publisher = '$publisher' AND publication_date ='$publication_date' AND edition ='$edition' AND number_of_copies= '$number_of_copies' AND format= '$format' AND age_group= '$age_group' AND rating='$rating' ;";

        $query = $this -> db -> connect() -> prepare($sql);
         $query -> execute();
         $res = $query -> rowCount();
            if($res){
               return true;
            } else {
                return false;
            }
   }


   function showAll(){
    $sql = "SELECT title, author, genre, publisher, publication_date,edition, number_of_copies, format, age_group, rating FROM books ORDER BY title ASC;";
    $query = $this -> db -> connect() -> prepare($sql);
    
    if($query -> execute()){
        foreach( $query as $rows){
            echo "<tr><td>{$rows['title']}</td>
            <td>{$rows['author']}</td>
            <td>{$rows['genre']}</td>
            <td>{$rows['publisher']}</td>
            <td>{$rows['publication_date']}</td>
            <td>{$rows['edition']}</td>
            <td>{$rows['number_of_copies']}</td>
            <td>{$rows['format']}</td>
            <td>{$rows['age_group']}</td>
            <td>{$rows['rating']}</td></tr> ";
            }
    }
   
   }

   function delete(){
    $sql = "TRUNCATE TABLE `books`;";
    $query = $this -> db -> connect() -> prepare($sql);
    $execute = $query -> execute();
    if($execute){
        return true;
    } else {
        return false;
    }
   }

   

}