<?php
// include database connection file
include_once("control/config.php");
 
// Check if form is submitted for user update, then redirect to homepage after update
if(isset($_POST['update']))
{	
	$id = $_POST['id'];
	$uid=$_POST['data_uid'];
	$nama=$_POST['nama'];
	$email=$_POST['email'];
	$saldo=$_POST['saldo'];
		
	// update user data
	$result = mysqli_query($mysqli, "UPDATE data_rfid SET data_uid='$uid',nama='$nama',email='$email',saldo='$saldo' WHERE id=$id");
	
	// Redirect to homepage to display updated user in list
	header("Location: index.php");
}
?>
<?php
// Display selected user data based on id
// Getting id from url
$id = $_GET['id'];
 
// Fetech user data based on id
$result = mysqli_query($mysqli, "SELECT * FROM data_rfid WHERE id=$id");

 
while($user_data = mysqli_fetch_array($result))
{
	//$tuid=$user_data['data_uid'];
	$uid=$user_data['data_uid'];
	$nama=$user_data['nama'];
	$email=$user_data['email'];
	$saldo=$user_data['saldo'];
}
?>
<html>
<head>	
	<title>Edit User Data</title>
</head>
 
<body>
	<a href="index.php">Home</a>
	<br/><br/>
	
	<form name="update_user" method="post" action="edit.php">
		<table border="0">
			<tr> 
				<td>uid : </td>
				<td><input type="text" name="data_uid" value=<?php echo $uid; ?>></td>
			</tr>
			<tr> 
				<td>Name</td>
				<td><input type="text" name="nama" value=<?php echo $nama;?>></td>
			</tr>
			<tr> 
				<td>Email</td>
				<td><input type="text" name="email" value=<?php echo $email;?>></td>
			</tr>
			<tr> 
				<td>Saldo</td>
				<td><input type="float" name="saldo" value=<?php echo $saldo;?>></td>
			</tr>
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>
</html>