
<?php
session_start();
include_once 'dbconnect.php';
if(isset($_SESSION['customers'])!="")
{
	header("Location:home.php");//This will be a home page of your website protected by login form.
}
if(isset($_POST['btn-login']))
{
	$uname = mysql_real_escape_string($_POST['uname']);
	$upass = mysql_real_escape_string($_POST['pass']);
	$result=mysql_query("SELECT * FROM customers WHERE uname='$uname'") or die(mysql_error());
	$row=mysql_fetch_array($result);
	
	if($row['password']==$upass)
	{
		$_SESSION['customers'] = $row['id'];
		header("Location:home.php");
	}
	else
	{
		?>
        <script>alert('wrong details');</script>
        <?php
	}
	
}
?>
<html>
<head>
  <meta charset="UTF-8">
  <title>Eloot</title>
  <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto+Slab'>

      <style>
      /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
      * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
html, body {
  height: 100%;
  background-color: #F15A5C;
  font-family: "Roboto Slab", serif;
  color: white;
}
.preload * {
  transition: none !important;
}
label {
  display: block;
  font-weight: bold;
  font-size: small;
  text-transform: uppercase;
  font-size: 0.7em;
  margin-bottom: 0.35em;
}
input[type="text"], input[type="password"] {
  width: 100%;
  border: none;
  padding: 0.5em;
  border-radius: 2px;
  margin-bottom: 0.5em;
  color: #333;
}
input[type="text"]:focus, input[type="password"]:focus {
  outline: none;
  box-shadow: inset -1px -1px 3px rgba(0, 0, 0, 0.3);
}
button {
  padding-left: 1.5em;
  padding-right: 1.5em;
  padding-bottom: 0.5em;
  padding-top: 0.5em;
  border: none;
  border-radius: 2px;
  background-color: #7E5AF1;
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.25);
  color: white;
  box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.45);
}
small {
  font-size: 1em;
}
.login--login-submit {
  float: right;
}
.login--container {
  width: 600px;
  background-color: #F15A5C;
  margin: 0 auto;
  position: relative;
  top: 25%;
}
.login--toggle-container {
  position: absolute;
  background-color: #F15A5C;
  right: 0;
  line-height: 2.5em;
  width: 50%;
  height: 120px;
  text-align: right;
  cursor: pointer;
  transform: perspective(1000px) translateZ(1px);
  transform-origin: 0% 0%;
  transition: all 1s cubic-bezier(0.06, 0.63, 0, 1);
  backface-visibility: hidden;
}
.login--toggle-container .js-toggle-login {
  font-size: 4em;
  text-decoration: underline;
}
.login--active .login--toggle-container {
  transform: perspective(1000px) rotateY(180deg);
  background-color: #bc1012;
}
.login--username-container, .login--password-container {
  float: left;
  background-color: #F15A5C;
  width: 50%;
  height: 120px;
  padding: 0.5em;
}
.login--username-container {
  transform-origin: 100% 0%;
  transform: perspective(1000px) rotateY(180deg);
  transition: all 1s cubic-bezier(0.06, 0.63, 0, 1);
  background-color: #bc1012;
  backface-visibility: hidden;
}
.login--active .login--username-container {
  transform: perspective(1000px) rotateY(0deg);
  background-color: #F15A5C;
}
footer {
  position: absolute;
  bottom: 12px;
  left: 20px;
}
#head{
padding-left:20%;
}
    </style>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

</head>
<header>
  &nbsp &nbsp &nbsp &nbsp <div id="head"><h1 style="font-family:font-family: 'Anton', sans-serif; font-size:100px;">ELoot</h1></div>
</header>
<body>
  <div class='preload login--container'>
  <div class='login--form'>
    <div class='login--username-container'>
 <form method="post">
      <label>Username</label>
      <input autofocus placeholder='Username' name="uname" type='text' required>
    </div>
    <div class='login--password-container'>
      <label>Password</label>
      <input placeholder='Password'name="pass"  type='password' required>
      <button class='js-toggle-login login--login-submit' type="submit" name="btn-login" >Login</button></br></br>
	  <div class='js-toggle-login'><a href="register.php">Create an Account</a></div>
    </div>
</form>
  </div>
  <div class='login--toggle-container'>
    <small>Hey you,</small>
    <div class='js-toggle-login'>Login</div>
    <small>already</small></br></br>
	<a href="register.php">Create an Account</a>
  </div>
</div>
<footer>
 
  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</footer>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script>

</body>
</html>
