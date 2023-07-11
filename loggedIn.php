<?php

    session_start();

    $diaryContent = "";

    if(array_key_exists("id", $_COOKIE)) {
        $SESSION['id'] =$_COOKIE['id'];

    }

    if(array_key_exists("id", $_SESSION)) {
        

        include('connection.php');

        $query = "SELECT diary FROM sign WHERE id = ".

        mysqli_real_escape_string($link, $_SERVER['id']). " LIMIT 1";

        $result = mysqli_query($link, $query);

        $row = mysqli_fetch_array($result);

        $diaryContent = $row['diary'];
    }

    else{
        header("location:login.php");
        
    }

    include('header.php');
?>

<div class="container-fluid">
    <textarea id="diary" class="form-control">
        <?php echo $diaryContent; ?>
    </textarea>
</div>

<?php
    include('footer.php');
?>