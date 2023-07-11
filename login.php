<?php
 
session_start();
$error = "";
//server = localhost:3307
//password = " "
//dbName = piflat

if (array_key_exists("Logout", $_GET)){

    session_unset();
    setcookie("id", "", time()- 60 * 60);
    $_COOKIE["id"] = "";
    }

    elseif(array_key_exists("id", $_SESSION) OR array_key_exists("id", $_COOKIE)) {
        //Go to the loggedInpage if you're still loggedin
        
}//End test for logout query string

if(array_key_exists("submit",$_POST)) {

   include ('connection.php');
  

   if(!$_POST['email']) {

      $error .= "An email address is required. <br>";
   }

   if(!$_POST['password']) {
      $error .= "A password is required. <br>";
   }

   if($error !=""){
      $error = "<p>There were error(s) in your form </p>" . $error;
   }

   else {
       $emailAddress = mysqli_real_escape_string($link,$_POST['email']);
       $password = mysqli_real_escape_string($link, $_POST['password']);

       $password = password_hash($password, PASSWORD_DEFAULT);
       
       if(isset($_POST['SignUp']) == '1') {
        $query = "SELECT id FROM sign WHERE email = '" . $emailAddress . "' LIMIT 1";
       $result = mysqli_query($link, $query);

       if(mysqli_num_rows($result) > 0) {
        $error = "That email address is taken.";
       }
       else{
        
        $query = "INSERT INTO sign (email, password) VALUES ('" .$emailAddress. "', '". $password."')";
       

        if(!mysqli_query($link,$query)){
            $error .= "<p>Could not sign you up. Please try again later</p>";
            $error .= "<p>" . mysqli_error($link) . "</p>" ;
        }
        else{

            $id = mysqli_insert_id($link);

            $_SESSION['id']= $id;
            
            if(isset($_POST['stayLoggedIn'])) {
                setcookie("id", $id, time() * 60 * 60 * 24 * 365);
                
            }

            header("location: loggedIn.php");

        }//End if for successful /failed signup

       }//End of mysqli_num_rows test

       }
       else {

        $query= "SELECT * FROM sign WHERE email = '" . $emailAddress . " '";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
        $password = mysqli_real_escape_string($link, $_POST['password']);

        if(isset($row) AND array_key_exists("password", $row)) {
            $passwordMatches = password_verify($password, $row['password']);

            if($passwordMatches) {

                $_SESSION['id']= $row['id'];
                if(isset($_POST['stayLoggedIn'])){
                    setcookie("id", $row['id'], time() + 60 * 60 * 24 *365);
                }

                header("location: loggedIn.php");

            }
            else {

                $error = "That email/password combination could not be found";

            }//End else - password matches or doesn't
        }

        else{
            $error = "That email/password combination could not be found";
        }

       }//End if-else SignUp ==1 or 0 
    
   }//End of error existing check

}//End if the summit exists

?>

<?php include('header.php'); ?>

        <div class="container" id="homepageContainer">
            <h1>Diary</h1>

    <!--SignUp form-->
        <div id="error"><?php echo $error; ?></div>

        <form method="post" id="signUpForm">
        <p>Interested? Sign up now!</p>
        

          <fieldset class="form-group">
          
             <input type="email" name="email" class="form-control" placeholder="Email">
          </fieldset>
         
          <fieldset class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password"> <br>
          </fieldset>

          <fieldset class="checkbox">

          Stay Logged In:
            <input type="checkbox" name="stayLoggedIn" value="1">
          </fieldset>

          <fieldset class="form-group">
            <input type="hidden" name="SignUp" value="1">
            <input type="submit" name="submit" class="btn btn-success" value="Sign Up!">
          </fieldset> 

          <p><a class="toggleforms">Log In</a></p>

        </form>

        <!--LogIn form-->

        <form method="post" id="logInForm">
            <P>Log in using your username and password!</P>
             
            <fieldset class="form-group">
               <input type="email" name="email" class="form-control" placeholder="Email"> 
            </fieldset>

            <fieldset class="form-group">
               <input type="password" name="password" class="form-control" placeholder="Password"> <br> 
            </fieldset>

            <fieldset class="checkbox">
                Stay Logged In:
               <input type="checkbox" name="stayLoggedIn" value="1">

            <fieldset class="form-group">
               <input type="hidden" name="LogIn" value="0">
               <input type="submit" name="submit" class="btn btn-success" value="Log In!">
            </fieldset>

            <p><a class="toggleforms">Sign Up</a></p>

        </form>
        </div>
        
        <?php include('footer.php'); ?>