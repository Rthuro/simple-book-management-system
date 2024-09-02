<?php 
include_once("header.html");
require_once('function.php');
require_once 'books.class.php';

$title = $author = $genre = $publisher = $date = $edition = $copies = $format = $rating = $kids = $teen = $adult ="";
 $age_group = array();
$titleErr = $authorErr = $publisherErr = $editionErr = $copiesErr = $formatErr = $age_groupErr= $dateErr = $genreErr =  "";

function input_err($name_err, $book_info, $book_infoName ){
    if(empty($book_info)){
        $name_err = $book_infoName . " is required";
        return $name_err;
    } 
}

function input_numErr($name_err, $book_info, $book_infoName){
    if(!empty($book_info)){
        if(!is_numeric($book_info)){
            $name_err = $book_infoName .' should be a number';
            return $name_err;
        } else if($book_info <1){
            $name_err = $book_infoName .' should be greater than 1';
            return $name_err;
        }
    }
}

function display_err($name_err){
    if(isset($_POST['addbook']) && !empty($name_err)){
        echo "<span class = 'err'>$name_err</span>";
    }
}
if(isset($_POST['resetInput'])){
    header('location: addbook_info.php');
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addbook'])  ){
    //inputted values
    $title = clean_input($_POST['title']);
    $author = clean_input($_POST['author']);
    $publisher = clean_input($_POST['publisher']);
    $edition = clean_input($_POST['edition']);
    $copies = clean_input($_POST['copies']);

    //not inputted values
    $rating = $_POST['rating'];
    $date = $_POST['date'];

    if(isset($_POST['age'])){
        $age_group = $_POST['age'];
       // foreach($age_group as $i){ echo $i; }
    }

    if(isset($_POST['format'])){
        if( $_POST['format'] == "HardBound"){
            $format = "HardBound";
        } else if ( $_POST['format'] == "SoftBound"){
            $format = "SoftBound";
        }
    }
    
    if(isset($_POST['genre'])){
        if($genre == "none"){
                $genreErr = 'Select a genre';
         } else {
            $genre = $_POST['genre'];
         }
    } 

     //echo "<p>$title</p><p>$author</p><p>$genre</p><p>$publisher</p><p>$date</p><p>$edition</p><p>$copies</p><p>$format</p><p>$rating</p>";

    $add_book = new Book();

    if(!empty($title) && !empty($author) && !empty($genre) && !empty($publisher) && !empty($date) && !empty($edition) && !empty($copies) && !empty($format) && !empty($age_group)){
      
        // session_start();
        // $newBook = array('title' => $title, 'author' => $author,
        // 'genre' => $genre, 'publisher' => $publisher,
        // 'date' => $date, 'edition' => $edition,
        // 'copies' => $copies, 'format' => $format,
        // 'age group' => $age_group  , 'rating' => $rating );

        // $data = $_SESSION['books'];
        // $data[] = $newBook;
        // $_SESSION['books'] = $data;

        if($add_book -> checkDuplicate($title, $author, $genre, $publisher, $date, $edition,$copies, $format, $age_group,$rating) == true){
            echo "<p class='err bookExists'>Book Information Already Exists</p>";
        } else{
            $age_group = implode(", ", $age_group);

            $add_book ->title = $title;
            $add_book ->author = $author;
            $add_book ->genre = $genre;
            $add_book ->publisher = $publisher;
            $add_book ->date = $date;
            $add_book ->edition = $edition;
            $add_book ->copies = $copies;
            $add_book ->format = $format;
            $add_book ->age_group = $age_group;
            $add_book ->rating = $rating;

            if($add_book ->add()){
                header('location: display_book.php');
            } else {
                echo "<p class='err'>Something went wrong when adding new book information</p>";
            }
        }
       
     }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book Information</title>
    <link rel="stylesheet" href="style_add.css?v=<?php echo time(); ?>">
</head>
<body>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
    <h3>Add Book Information</h3>
    <main>
     <section>
            <!-- Book Title -->
        <label for="title">Book Title:</label>
        <input type="text" name="title" value= "<?= (isset($title)) ? $title: '' ?>">
        <?php display_err(input_err($titleErr, $title, "Book title")); ?>

        <!-- Book Author -->
        <label for="author">Author:</label>
        <input type="text" name="author" value= "<?= (isset($author)) ? $author: '' ?>">
        <?php display_err( input_err($authorErr, $author, "Author")); ?>

        <!-- Book Genre -->
        <label for="genre">Genre:</label>
        <select name="genre" id="genre" >
        <option value="none" selected  disabled hidden>Select an Option</option>
            <option value="science" <?= (isset($_POST['genre']) && $genre == 'science') ? 'selected=true': '' ?>>Science</option>
            <option value="history" <?= (isset($_POST['genre']) && $genre == 'history') ? 'selected=true': '' ?>>History </option>
            <option value="math" <?= (isset($_POST['genre']) && $genre == 'math') ? 'selected=true': '' ?>>Math</option>
        </select>
        <?php display_err(input_err($genreErr, $genre, "Genre ")); ?>

        <!-- Book Publisher -->
        <label for="publisher">Publisher:</label>
        <input type="text" name="publisher" value="<?= isset($publisher) ? $publisher: '' ?>">
        <?php display_err(input_err($publisherErr, $publisher, "Publisher title")); ?>
        </section>
        <section>
        <!-- Publication Date -->
        <label for="date">Publication Date:</label>
        <input type="date" name="date" id="" value="<?= isset($date) ? $date: '' ?>" >
        <?php display_err(input_err($dateErr, $date, "Date ")); ?>
  
        <!-- Edition Number -->
        <label for="edition">Edition Number:</label>
        <input type="number" name="edition" value="<?= (isset($edition)) ? $edition: '' ?>">
        <?php display_err( input_err($editionErr, $edition, "Edition"));
            display_err(input_numErr($editionErr, $edition, "Edition"));
        ?>

        <!-- Number of copies -->
        <label for="copies">Number of copies:</label>
        <input type="number" name="copies" value="<?= isset($copies) ? $copies :''?>">
        <?php   display_err(input_err($copiesErr, $copies, "Number Of copies"));
            display_err(input_numErr($copiesErr, $copies, "Number Of copies"));
        ?>

        <!-- Book Format -->
        <p >Book Format:</p>
        <div class="form_row book_format">
            <div>
                <input type="radio" name="format" id="HardBound" value="HardBound"
                <?= (isset($format) && $format == 'HardBound')? 'checked' :''?> >
                <label for="HardBound">HardBound</label>
            
                </div>
                <div>
                 <input type="radio" name="format" id="SoftBound" value="SoftBound" 
                   <?= (isset($format) && $format == 'SoftBound')? 'checked':''?>>
                    <label for="SoftBound">SoftBound</label>
                
                </div>
        </div>
        <?php display_err(input_err($formatErr, $format, "Book format")); ?>
        </section>
        </main>
        <section class="age_rating">
        <div>
                    <!-- Book Age Group -->
                <label for="age" >Age Group:</label>
                <div class="form_row age_group">
                    <div> 
                        
                        <input type="checkbox" name="age[]" id="kids" value="kids"
                        <?= (isset($age_group) && in_array('kids', $age_group, true) ) ? 'checked' : '';   ?>>
                    
                            <label for="kids">Kids</label>
                                
                        </div>
                
                        <div>
                            <input type="checkbox" name="age[]" id="teens" value="teens"
                            <?= (isset($age_group) && in_array('teens', $age_group, true)  ) ? 'checked' : '';   ?>   > 
                            <label for="teens">Teens</label>
                    
                        </div>
                    
                        <div>
                            <input type="checkbox" name="age[]" id="adults" value="adults"
                            <?= (isset($age_group) && in_array('adults', $age_group, true)  ) ? 'checked' : '';  ?> >
                            <label for="adults">Adult</label>
                        
                        </div>
                </div>
                <?php display_err( input_err($age_groupErr, $age_group, "Age group")); ?>
        </div>
        <!-- Book Rating -->
        <div class="ratingContainer">
             <label for="rating" >Book Rating(1-5):</label>
            <input type="range" name="rating" id="rating_val" min="1" max="5" step= "1" value="1">
            <p id="display_ratingVal"></p>  
        </div>
       
        </section>
        <div class="bottomBttn">
             <input type="submit" value="Reset" name="resetInput">
            <input type="submit" value="Add Book Info" name="addbook">
        </div>
        </form>

    <script>
        var rating_val = document.getElementById('rating_val');
        var display_rating = document.getElementById('display_ratingVal');
        display_rating.innerHTML = `Rating: ${rating_val.value}`;

        rating_val.addEventListener("change", function(){
            display_rating.innerHTML = `Rating: ${rating_val.value}`;
        })
           
    
    </script>
</body>
</html>