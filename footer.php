<script
                src="https://code.jquery.com/jquery-3.6.4.js"
                integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
                crossorigin="anonymous"></script>
            

            <script type="text/javascript">

              $(document).ready(function(){
                $(".toggleforms").click(function(){
                    //toggle the forms
                    $("#signUpForm").toggle();
                    
                    $("#logInForm").toggle();
                });
              });

              $("#diary").bind('input propertychange', function() {
                 $.ajax({
                  method: "POST",
                  url: "updatedatabase.php",
                  data:{content: $("#diary").val()}
                
                 });
              });

    </script>
    </body>
</html>
