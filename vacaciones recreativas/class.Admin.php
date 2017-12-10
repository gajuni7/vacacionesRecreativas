<?php
class ADMIN
{
    private $db;
 
    function __construct($DB_con)
    {
      $this->db = $DB_con;
    }
 
    
    public function login($uname,$upass)
    {
       try
       {
          $stmt = $this->db->prepare("SELECT * FROM administradores 
                                          WHERE admin_name=:uname LIMIT 1");
          $stmt->execute(array(':uname'=>$uname));
          $adminRow=$stmt->fetch(PDO::FETCH_ASSOC);
          if($stmt->rowCount() > 0)
          {
             if(password_verify($upass, $adminRow['admin_password']))
             {
                $_SESSION['admin_session'] = $adminRow['admin_id'];
                return true;
             }
             else
             {
                return false;
             }
          }
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
   }
 
   public function is_loggedin()
   {
      if(isset($_SESSION['admin_session']))
      {
         return true;
      }
   }
 
   public function redirect($url)
   {
       header("Location: $url");
   }
 
   public function logout()
   {
        session_destroy();
        unset($_SESSION['admin_session']);
        return true;
   }
}


?>