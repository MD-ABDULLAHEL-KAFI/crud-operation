<?php
	$hostname="localhost";
	$username = "root";
	$password="";
	$db_name="kafi";
	$con = mysqli_connect($hostname,$username,$password,$db_name);

?>
<?php
	$mgs="";
	$class="";
	if (isset($_GET['delete'])) {
		$USER_NO = $_GET['delete'];
		$sql="UPDATE `user` SET `IS_DELETED`=1 WHERE `USER_NO`= $USER_NO";
		$query =mysqli_query($con,$sql);
		if($query){
			$mgs="Data deleted successfully";
			$class="alert alert-success alert-dismissible col-md-12";
			echo "<meta http-equiv='Refresh' content='3; url=index.php'>";
		}
	}
	if (isset($_POST['submit'])) {
		$FULL_NAME = $_POST['FULL_NAME'];
		$EMAIL = $_POST['EMAIL'];
		$PASSWORD = md5($_POST['PASSWORD']);
		$COURSE_NAME = $_POST['COURSE_NAME'];
		$SQL ="SELECT * FROM `user` WHERE `EMAIL` ='$EMAIL'";
		$QUERY =mysqli_query($con,$SQL);
		$count = mysqli_num_rows($QUERY);
		if($count <1){
			$sql = "INSERT INTO `user` SET FULL_NAME = '$FULL_NAME',EMAIL = '$EMAIL', PASSWORD ='$PASSWORD',COURSE_NAME='$COURSE_NAME'";
			$query =mysqli_query($con,$sql);
			if($query){
				$mgs="Data inserted successfully";
				$class="alert alert-success alert-dismissible col-md-12";
			}else{
				$mgs="Data insert Fail";
				$class="alert alert-danger alert-dismissible col-md-12";
			}
		}else{
			$mgs="Duplicate Email Found";
				$class="alert alert-danger alert-dismissible col-md-12";
		}
		
	}

	if (isset($_POST['update'])) {
		$FULL_NAME = $_POST['FULL_NAME'];
		$EMAIL = $_POST['EMAIL'];
		$USER_NO = $_POST['USER_NO'];
		$COURSE_NAME = $_POST['COURSE_NAME'];
		$SQL ="SELECT * FROM `user` WHERE `EMAIL` ='$EMAIL' AND `USER_NO` != '$USER_NO'";
		$QUERY =mysqli_query($con,$SQL);
		$count = mysqli_num_rows($QUERY);
		if($count <1){
			 $sql = "UPDATE `user` SET FULL_NAME = '$FULL_NAME',EMAIL = '$EMAIL',COURSE_NAME='$COURSE_NAME' WHERE USER_NO ='$USER_NO'";
			$query =mysqli_query($con,$sql);
			if($query){
				$mgs="Data Updated successfully";
				$class="alert alert-success alert-dismissible col-md-12";
				echo "<meta http-equiv='Refresh' content='3; url=index.php'>";
			}else{
				$mgs="Data update Fail";
				$class="alert alert-danger alert-dismissible col-md-12";
			}
		}else{
			$mgs="Duplicate Email Found";
				$class="alert alert-danger alert-dismissible col-md-12";
		}
		
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<?php
			if (isset($_GET['edit'])):
				$USER_NO = $_GET['edit'];
				$sql="SELECT * FROM `user` WHERE `USER_NO`='$USER_NO'";
				$result = mysqli_fetch_array(mysqli_query($con,$sql));
		?>

			<form method="post">
				<div class="<?=$class?>" <?php if($mgs=="") echo "style='display:none'" ;?>>
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				  	<?=$mgs?>
				  	<input type="hidden" class="form-control"  name="USER_NO" value="<?=$result['USER_NO']?>">
				</div>
				<div class="form-group">
				    <label for="exampleInputEmail1">Name</label>
				    <input type="text" class="form-control"  name="FULL_NAME" value="<?=$result['FULL_NAME']?>">
				    
				  </div>
			  <div class="form-group">
			    <label for="exampleInputEmail1">Email address</label>
			    <input type="email" class="form-control"  name="EMAIL" value="<?=$result['EMAIL']?>">
			    
			  </div>
			  <div class="form-group">
			      <label for="exampleInputEmail1">Course</label>
			      <input type="text" class="form-control"  name="COURSE_NAME" value="<?=$result['COURSE_NAME']?>">
			   </div>
			  
			  <button name="update" type="submit" class="btn btn-primary">Update</button>
			</form>
		<?php else :?>

		<form method="post">
			<div class="<?=$class?>" <?php if($mgs=="") echo "style='display:none'" ;?>>
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			  	<?=$mgs?>
			</div>
			<div class="form-group">
			    <label for="exampleInputEmail1">Name</label>
			    <input type="text" class="form-control"  name="FULL_NAME" placeholder="Enter Name">
			    
			  </div>
		  <div class="form-group">
		    <label for="exampleInputEmail1">Email address</label>
		    <input type="email" class="form-control"  name="EMAIL" placeholder="Enter email">
		    
		  </div>
		  <div class="form-group">
		    <label for="exampleInputPassword1">Password</label>
		    <input type="password" class="form-control"  name="PASSWORD" placeholder="Password">
		  </div>
		  <div class="form-group">
		      <label for="exampleInputEmail1">Course</label>
		      <input type="text" class="form-control"  name="COURSE_NAME" placeholder="Enter Course Name">
		   </div>
		  <button name="submit" type="submit" class="btn btn-primary">Submit</button>
		</form>
	<?php endif;?>
		<br><br><br>
		<div style="height: 100px">
			<h1>View Data</h1>
		</div>

		<table class="table table-bordered table-striped table-hover">
			<tr>
				<th>Sl</th>
				<th>Full Name</th>
				<th>Email</th>
				<th>Course</th>
				<th>Action</th>
			</tr>
			<?php
			 	$i=1;
				$sql_show ="SELECT * FROM `user` WHERE `IS_DELETED`=0";
				$show_query = mysqli_query($con,$sql_show);
				while($row = mysqli_fetch_array($show_query)):
			?>
				<tr>
					<td><?=$i++?></td>
					<td><?=$row['FULL_NAME']?></td>
					<td><?=$row['EMAIL']?></td>
					<td><?=$row['COURSE_NAME']?></td>
					<td>
						<a class="btn btn-danger" href="<?='index.php'.'?delete='.$row['USER_NO']?>" onclick="return confirm('Are u sure want to delete this data?')"> Delete</a>
						<a class="btn btn-info" href="<?='index.php'.'?edit='.$row['USER_NO']?>" onclick="return confirm('Are u sure want to edit this data?')"> Edit</a>
					</td>
				</tr>
			<?php endwhile;?>
		</table>
	</div>
	
</body>
</html>