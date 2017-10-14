
<?php
session_start();
if(isset($_SESSION['customers'])!="")
{
	header("Location: home.php");
}
include_once 'dbconnect.php';
if(isset($_POST['btn-signup']))
{
	$name = mysql_real_escape_string($_POST['name']);
 $address = mysql_real_escape_string($_POST['address']);
   $uname = mysql_real_escape_string($_POST['uname']);
   $password = mysql_real_escape_string($_POST['password']);
   $email = mysql_real_escape_string($_POST['email']); 
   $mobile = mysql_real_escape_string($_POST['mobile']);
	
	if(mysql_query("INSERT INTO customers(name,address,uname,password,email,mobile) VALUES('$name','$address','$uname','$password','$email','$mobile')"))
	{
		?>
        <script>alert('successfully registered, now signin and enjoy ');</script>
        <?php
	}
	else
	{
		?>
        <script>alert('error while registering you...');</script>
        <?php
	}
}
?>
<html>
<title>online retail market:###</title>
<head>
<script>
var users = [
{ name: 'ianpirro' },
{ name: 'joeschmoe' },
{ name: 'superdev' }
]
var loginform = {
  
  init: function() {
    this.bindUserBox();
  },
  
  bindUserBox: function() {
    var result = {};
    
    $(".form").delegate("input[name='un']", 'blur',  function(){
      var $self = $(this);
      
      // this grep would be replaced by $.post tp check db for user
      result = $.grep(users, function(elem, i){  
        return (elem.name == $self.val());
      });
      
      // This would be callback
      if (result.length === 1) {
        if( $("div.login-wrap").hasClass('register')) {
          loginform.revertForm();
          return;
        }
        else{
          return;
        }
      }
      
      if( !$("div.login-wrap").hasClass('register') ) {
        if ( $("input[name='un']").val().length > 4 )
          loginform.switchForm();
      }
    });
  },
  switchForm: function() {
    var $html = $("div.login-wrap").addClass('register');
    $html.children('h2').html('Register');
    $html.find(".form input[name='pw']").after("<input type='password' placeholder='Re-type password' name='rpw' />");
    $html.find('button').html('Sign up');
    $html.find('a p').html('Have an account? Sign in');
  },
  revertForm: function() {
    var $html = $("div.login-wrap").removeClass('register');
    $html.children('h2').html('Login');
    $html.find(".form input[name='rpw']").remove();
    $html.find('button').html('Sign in');
    $html.find('a p').html("Don't have an account? Register");
  },
  submitForm: function(){
    // ajax to handle register or login
  }
  
} // loginform {}
// Init login form
loginform.init();
// vertical align box   
(function(elem){ 
    elem.css("margin-top", Math.floor( ( $(window).height() / 2 ) - ( elem.height() / 2 ) ) );
}($(".login-wrap")));
$(window).resize(function(){
    $(".login-wrap").css("margin-top", Math.floor( ( $(window).height() / 2 ) - ( $(".login-wrap").height() / 2 ) ) );
  
});
</script>
<style>
#head{
padding-top:25px;
padding-bottom:25px;
padding-left:25px;
padding-right:25px;
background:#585754; 
margin:0px;
     }
	  </style>
	  <style>
	  
	
#right{
float:right;
align:top;
}
hname.h1name{
width:30%;
text-color:white;
text-style
}
.hname{
display:inline;
}
body{
background-color:#E6E6E6;
}
ul {position:static;
    list-style-type: marker;
    margin: 0;
    padding: 0;
    overflow: hidden;
}
li {
-webkit-transition: height 2s; /* Safari 3.1 to 6.0 */
    transition: height 2s;
    float: left;
	border-style:solid;
	border-width:5px;
	border-color:#2e2d29;
	background-color:#2e2d29;
}
a { text-align:center;
    display: block;
    width: 60px;
	color:white;
    
}
#ad
{padding-left:5px;
 padding-right:5px;
 padding-bottom:20px;
 padding-top:20px;
 margin-left:auto;
 margin-right:auto;
 background-color:white;
 width:1000px;
 height:300px;
 border-style:solid;
	border-width:1px;
}
#offer1{background-color:gray;
 padding-left:2px;
 padding-right:2px;
 padding-bottom:2px;
 padding-top:2px;
border-style:solid;
	border-width:1px;
}
.box2:hover{
z-index:500;
border-style:solid;
border-color:yellow;
-moz-transition:-moz-transform 0.5s ease-in; 
-webkit-transition:-webkit-transform 0.5s ease-in; 
-o-transition:-o-transform 0.5s ease-in;
}
footer{
padding:0;
margin:0;
 padding-top:500px;
background-color:#434343;
outline:0;
width:100%;
	
}
#product-header{
padding-left:5px;
 padding-right:5px;
 padding-bottom:5px;
 padding-top:5px;
 background-color:black;
 }
 #product-img{
 padding-left:500px;
 padding-right:500px;
 padding-bottom:180px;
 padding-top:180px;
 background-color:white;
 margin:80px;
 float:center;
 
 }
 #product-header2{
padding-left:5px;
 padding-right:5px;
 padding-bottom:5px;
 padding-top:5px;
 background-color:red;
 margin:2px;
 }
 #product-img2{
 padding-left:500px;
 padding-right:500px;
 padding-bottom:180px;
 padding-top:180px;
 background-color:white;
 margin:80px;
 float:center;
 
 }
 .left-ad {
  float: left;
  width:50%;
  text-align: right;
  margin: 20px 10px;
  display: inline;
}
#right-ad {
  float:left;
  width:50%;
  text-align: left;
  margin: 2px 1px;
  display: inline;
}
.box2 {
position:static;
  display:inline-block;
  background-color:white;
  width: 150px;
  height: 200px;
  margin: 1px;
}
.three-column {
  padding: 1em;
  -moz-column-count: 3;
  -moz-column-gap: 1em;
  -webkit-column-count: 3;
  -webkit-column-gap: 1em;
  column-count: 3;
  column-gap: 1em;
}
.list{color:white;
size:20;
}
#nav1{
  padding-top:2px;
  padding-bottom:2px;
  background-color:#2e2d29;
}
#ylpi{
 padding-top:2px;
  padding-bottom:2px;
  margin-left:auto;
   margin-right:auto;
  width:600px;
  background-color:#2e2d29;
  border-style:solid;
border-width:1px;
margin-bottom:1px;
  margin-top:1px;
}
.cylpi{
color:white;
text-align:center;
size:20px;
}
#last-items{
margin-left:auto;
   margin-right:auto;
     width:1200px;
  background-color:#E6E6E6;
}
.searchbar{
margin-left:auto;
   margin-right:auto;
     width:650px;
  
}
.signup{color:red;}
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}
html {
  background: #95a5a6;
  background-image: url(http://subtlepatterns2015.subtlepatterns.netdna-cdn.com/patterns/dark_embroidery.png);
  font-family: 'Helvetica Neue', Arial, Sans-Serif;
}
html .login-wrap {
  position: relative;
  margin: 0 auto;
  background: #ecf0f1;
  width: 350px;
  border-radius: 5px;
  box-shadow: 3px 3px 10px #333;
  padding: 15px;
}
html .login-wrap h2 {
  text-align: center;
  font-weight: 200;
  font-size: 2em;
  margin-top: 10px;
  color: #34495e;
}
html .login-wrap .form {
  padding-top: 20px;
}
html .login-wrap .form input[type="text"],
html .login-wrap .form input[type="password"],
html .login-wrap .form button {
  width: 80%;
  margin-left: 10%;
  margin-bottom: 25px;
  height: 40px;
  border-radius: 5px;
  outline: 0;
  -moz-outline-style: none;
}
html .login-wrap .form input[type="text"],
html .login-wrap .form input[type="password"] {
  border: 1px solid #bbb;
  padding: 0 0 0 10px;
  font-size: 14px;
}
html .login-wrap .form input[type="text"]:focus,
html .login-wrap .form input[type="password"]:focus {
  border: 1px solid #3498db;
}
html .login-wrap .form a {
  text-align: center;
  font-size: 10px;
  color: #3498db;
}
html .login-wrap .form a p {
  padding-bottom: 10px;
}
html .login-wrap .form button {
  background: #e74c3c;
  border: none;
  color: white;
  font-size: 18px;
  font-weight: 200;
  cursor: pointer;
  transition: box-shadow .4s ease;
}
html .login-wrap .form button:hover {
  box-shadow: 1px 1px 5px #555;
}
html .login-wrap .form button:active {
  box-shadow: 1px 1px 7px #222;
}
html .login-wrap:after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  background: -webkit-linear-gradient(left, #27ae60 0%, #27ae60 20%, #8e44ad 20%, #8e44ad 40%, #3498db 40%, #3498db 60%, #e74c3c 60%, #e74c3c 80%, #f1c40f 80%, #f1c40f 100%);
  background: -moz-linear-gradient(left, #27ae60 0%, #27ae60 20%, #8e44ad 20%, #8e44ad 40%, #3498db 40%, #3498db 60%, #e74c3c 60%, #e74c3c 80%, #f1c40f 80%, #f1c40f 100%);
  height: 5px;
  border-radius: 5px 5px 0 0;
}
</style>

</head>


<body>


<center>
<div class="login-wrap">
  <h2>Sign Up</h2>
  <form method="post">
  <div class="form">
    <input type="text" name="name" placeholder="Name" required />
	 <input type="text" name="address" placeholder="Address" required />
	  <input type="text" name="uname" placeholder="User Name" required />
	   <input type="text" name="email" placeholder="Your Email" required />
	    <input type="password" name="password" placeholder="Your Password" required />
   <input type="text" name="mobile" placeholder="mobile number" required />
    <button type="submit" name="btn-signup">Sign Up</button>
    <a href="/home.php"> <p> Already have an account? Login here </p></a>
  </div>
</form>
</div>
</center>
  <script src='https://code.jquery.com/jquery-1.10.0.min.js'></script>

    <script src="js/index.js"></script>





      
    &copy; 


</body>
</html>
