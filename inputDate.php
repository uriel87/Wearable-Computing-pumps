
<!DOCTYPE html>
<HTML dir=ltr>
<head>
	<title> PHP </title>
	<meta charset = "utf-8">
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="My_code.js"></script>
	<link rel="stylesheet" text="css\text" href="links.css">
</head>
</head>
	<body> 
		<div id=container>
			<div id=information>
				<?php 
					$id=$_REQUEST['id'];
					$password=$_REQUEST['password'];
					$db_user = "uriel";
					$db_password = "";
					$db_server = "localhost";
					$dataBase = "wearablecomputing";
					// Create connection
					$conn = new mysqli($db_server, $db_user, $db_password,$dataBase);

					// Check connection
					if ($conn->connect_error) {
						die("Connection failed: ".$conn->connect_error);
					}
					$sql = "SELECT * FROM userdata";
					$result = $conn->query($sql);

					if ($result->num_rows > 0)
					{
						// output data of each row
						while($row = $result->fetch_assoc())
						{
							if( ($row["id"] == $id) && ($row["password"] == $password) )
							{
								echo "<a href='pump.php'>Go to input your data</a>";
								exit(-1);
							}
						}
					}
					echo "User name or password inncorect"."<br>";
					echo "<a href='index.html'>Try again</a>"."<br>";
					$conn->close();
				 ?>
			</div>
		</div>
</body>
</HTML>