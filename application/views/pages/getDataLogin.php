<?php 

$hostname = "localhost";
$username = "root";
$pass = "";
$dataBaseName = "freelancer";

$connection = mysqli_connect($hostname, $username, $pass);
$selection = mysqli_select_db($connection, $dataBaseName);

$mail = $_POST['userName'];
$userName = $_POST['userName'];
$password = $_POST['pass'];


echo "Email :  " .$mail. "<br>";
echo "Username :   " .$userName. "<br>";
echo "Password :   " .$password. "<br>";
//have to take register type from the register table

$success = true;

if(!$connection){
	die("connection failed ".mysqli_error());
	$success = false;
}

if(!$selection){
	die("selection failed ".mysqli_error());
	$success = false;
}

if($success){
	$sql = "SELECT `email`, `userName`, `password`, `registerType` FROM `register` WHERE `email` = '$mail' OR `userName` = '$userName'";
    $result = $connection->query($sql);

	if ($result->num_rows > 0) {
        // output data of each row
             while($row = $result->fetch_assoc()) {
				echo $row['email']. " ".$row['userName']. " ".$row['password']. " ".$row['registerType'];
				if($row['userName'] == $userName || $row['email'] == $mail){
					if($row['password'] == $password){
						$query = "INSERT INTO login (email, password) VALUES ('$mail', '$password')";
						if(mysqli_query($connection,$query)){
							echo "<br>";
							echo "Okay - login information stored in database";

							session_start();
							$_SESSION['userName'] = $row['userName'];
						}else{
							echo "<br>";
							echo "<h1>There is a problem. </h1>";
							echo "<br>";
							echo "<h3>We can not store login information into database!!!</h3>";
							echo "<br>";
						}
						if($row['registerType'] == 'work'){
							echo "<h2>Login is successful!!! <br> You will go to the work home page!!!</h2>";
							header("refresh:1, url= home-loged-work" );
						}else{
							echo "<h2>Login is successful!!! <br> You will go to the hire home page!!!</h2>";
							header("refresh:1, url=home-loged-hire");
						}
					}else{
						echo "<h2>Password is incorrect!!!</h2>";
						header("refresh:2, url=log");
					}
				}/*else{
					echo "<br>";
					echo "Email or username is incorrect!!!";
				}*/
             }
        } else {
            echo "<h2>Email or username is incorrect!!!</h2>";
			header("refresh:1, url=log");
          }
}
?>
