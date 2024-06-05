<?php
   session_start() ;
   require "db.php" ;

   if ( !isAuthenticated()) {
      header("Location: index.php") ;
      exit ;
   }
   
   // delete session file
   session_destroy() ;
   // delete session cookie
   setcookie("PHPSESSID", "", 1 , "/") ; // delete memory cookie 

   // redirect to login page.
   header("Location: index.php") ;      