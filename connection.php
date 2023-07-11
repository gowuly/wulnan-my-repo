<?php

$link = mysqli_connect("localhost:3307",
                        "root", "",
                        "piflat");
     
   if(mysqli_connect_error()) {
       die("data connection error");
   }
?>