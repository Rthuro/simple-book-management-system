<?php 
    require_once 'books.class.php';
    include_once('header.html');

    $booksObj = new Book();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['del_records'])) {
            echo "
            <section id='deleteModal'>
                <p>Confirm action? All records will be permanently deleted.</p>
                <form action='' method='post'>
                    <input type='submit' name='cancel' value='Cancel' id='cancel'  style='cursor:pointer;'>
                    <input type='submit' name='confirm' value='Delete' id='confirm' style='cursor:pointer;'>
                </form>
            </section>";
        } 
       
    }
   
    if (isset($_POST['confirm'])) {
                $booksObj->delete();
                header('Location: display_book.php'); 
               exit(0); 
     } elseif (isset($_POST['cancel'])) {
                header('Location: display_book.php'); 
                exit(0);
        }
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Information</title>
   <link rel="stylesheet" href="style_display.css?v=<?php echo time(); ?>">
</head>
<body>
   
    <table>
       <thead>
        <tr>
            <td>Book Title</td>
            <td>Author</td>
            <td>Genre</td>
            <td>Publisher</td>
            <td>Publication Date</td>
            <td>Edition</td>
            <td>Number of Copies</td>
            <td>Format</td>
            <td>Age Group</td>
            <td>Rating</td>
        </tr>
       </thead>
        <tbody>
            <?php     
             $booksObj -> showAll(); 
            ?>
        </tbody>
    </table>
    <form action='' method='post'>
        <input type='submit' name='del_records' value ='Delete Records' id='delBttn' style="cursor:pointer;">
    </form>
     
    <script>
        function deleteModal(){
            const modal = document.getElementById('deleteModal');
            const cancelBttn = document.getElementById('cancel');
            const confirmBttn = document.getElementById('confirm');

            cancelBttn.addEventListener('click', function(){
            modal.style.display = 'none';
            })
            confirmBttn.addEventListener('click', function(){
            modal.style.display = 'none';
            })
        }
    </script>
</body>
</html>