<?php include "base.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>User Management System (Tom Cameron for NetTuts)</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>  
<body>  
<div id="main">
<?php
if(!empty($_POST['email']) && !empty($_POST['password']))
{
	$username = ($_POST['email']);
    $password = md5(($_POST['password']));
    $email = ($_POST['email']);
    
	 $checkusername = $db->prepare("SELECT * FROM users WHERE Username =?");
     $checkusername->execute(array($username));
     
     if($checkusername->rowCount() > 0)
     {
     	echo "<h1>Error</h1>";
        echo "<p>Sorry, that username is taken. Please go back and try again.</p>";
     }
     else
     {
     	$registerquery = $db->prepare("INSERT INTO users (Username, Password, EmailAddress) VALUES(:user,:pass,:email)");
        $registerquery->execute(array(':user' => $username, ':pass' => $password, ':email' => $email));
        if($registerquery->rowCount() == 1)
        {
        	echo "<h1>Success</h1>";
        	echo "<p>Your account was successfully created. Please <a href=\"index.php\">click here to login</a>.</p>";
            echo "<p>We are now redirecting you to the member area.</p>";

            $subject = "Successfully register in OURS Grant Proposal Management system.";
            $message = "Hello! This is a simple email message.";
            $from = "OURS@alaska.edu";
            $headers = "From:" . $from;
            mail($email,$subject,$message,$headers);
            echo "Mail Sent.";

        }
        else
        {
     		echo "<h1>Error</h1>";
        	echo "<p>Sorry, your registration failed. Please go back and try again.</p>";    
        }    	
     }
}
else
{
	?>
    
   <h1>Register</h1>
    
   <p>Please enter your details below to register.</p>
    
	<form method="post" action="register.php" name="registerform" id="registerform">
	<fieldset>
		<label for="email">Email Address:</label><input type="text" name="email" id="email" /><br />
        <label for="password">Password:</label><input type="password" name="password" id="password" /><br />
        <input type="submit" name="register" id="register" value="Register" />
	</fieldset>
	</form>
    
   <?php
}
?>
</div>
</body>
</html>