<!-----------------start php code for database connection---------------------->
<?php
$my_host="localhost";
$my_user="root";
$my_pass="";
$my_db="dhoni";
$conn=mysqli_connect($my_host,$my_user,$my_pass,$my_db);
if(!$conn)
{
die("Connection Failed");
}
?>
<!-------------------End php code for data base connection---------------------->

<!-----------------start php code for data insert------------------------------->
<?php
if(isset($_POST['rReg']))
{
if(($_POST['rName']=="")||($_POST['rEmail']=="")||($_POST['rPass']=="")||($_POST['rConPass']=="")||empty($_POST['rGender'])||($_POST['rCity']=="")||empty($_POST['rEdu'])||empty($_FILES['rImage']))
{
$msg='<div class="alert alert-warning mt-3 text-center">Please fill all the fields</div>';
}
else
{
$rName=$_POST['rName'];
$rEmail=$_POST['rEmail'];
$rPass=$_POST['rPass'];
$rConPass=$_POST['rConPass'];
$rGender=$_POST['rGender'];
$rCity=$_POST['rCity'];
$rEdu=$_POST['rEdu'];
$rImage=$_FILES['rImage'];
$rFinalEdu=implode(',',$rEdu);
$iName=$_FILES['rImage']['name'];
$i_tmp_name=$_FILES['rImage']['tmp_name'];
move_uploaded_file($i_tmp_name,'images/'.$iName);
$sql="SELECT rEmail FROM kholi WHERE rEmail='".$rEmail."'";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)==1)
{
$msg='<div class="alert alert-warning mt-3 text-center">Email already registered</div>';
}
else
{
if($rPass==$rConPass)
{
$sql="INSERT INTO kholi(rName,rEmail,rPass,rConPass,rGender,rCity,rEdu,rImage)VALUES('$rName','$rEmail','$rPass','$rConPass','$rGender','$rCity','$rFinalEdu','$iName')";
if(mysqli_query($conn,$sql))
{
$msg='<div class="alert alert-warning mt-3 text-center">Data Entered Successfully</div>';
}
}
else
{
$msg='<div class="alert alert-warning mt-3 text-center">Password and confirm password must be same</div>';
}
}
}
}
?>
<!--------------------End php code for data insert---------------------------------->

<!----------------------------start registration page------------------------------->
<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

<title>ImageCrud.com</title>
</head>
<body>

<?php
$a=[];
$b=[];
if(isset($_POST['Edit']))
{
$Srno=$_POST['Srno'];
$sql="SELECT *FROM kholi WHERE Srno='".$Srno."'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$a=$row['rEdu'];
$b=explode(',',$a);
}
?>

<div class="container mt-5">
<div class="row">
<div class="col-sm-6">

<form action="" method="POST" enctype="multipart/form-data" class="shadow-lg p-5">
<h4>Welcome to Registration Page</h4>

<div class="form-group">
<label for="Name">Name</label>
<input type="text" placeholder="Type your name here" name="rName" class="form-control"
value="<?php if(isset($row['rName'])) {echo $row['rName'];}?>">
</div>

<div class="form-group">
<label for="Email">Email</label>
<input type="text" placeholder="Type your email here" name="rEmail" class="form-control"
value="<?php if(isset($row['rEmail'])) {echo $row['rEmail'];}?>">
</div>

<div class="form-group">
<label for="Password">Password</label>
<input type="password" placeholder="Type your password here" name="rPass" class="form-control"
value="<?php if(isset($row['rPass'])) {echo $row['rPass'];}?>">
</div>

<div class="form-group">
<label for="Confirm Password">Confirm Password</label>
<input type="password" placeholder="Confirm your password here" name="rConPass" class="form-control"
value="<?php if(isset($row['rConPass'])) {echo $row['rConPass'];}?>">
</div>

<div class="form-group">
<label for="Gender">Gender</label>
Male<input type="radio" name="rGender" value="Male" class="form-inline"
<?php if(isset($row['rGender']) && $row['rGender']=="Male") {echo "checked";}?>>

Female<input type="radio" name="rGender" value="Female" class="form-inline"
<?php if(isset($row['rGender']) && $row['rGender']=="Female") {echo "checked";}?>>

Others<input type="radio" name="rGender" value="Others" class="form-inline"
<?php if(isset($row['rGender']) && $row['rGender']=="Others") {echo "checked";}?>>
</div>

<div class="form-group">
<label for="City">City</label>
<select name="rCity" class="form-inline">
<option value=""></option>
<option value="Durgapur"
<?php if(isset($row['rCity']) && $row['rCity']=="Durgapur") {echo "selected";}?>>Durgapur</option>

<option value="Kolkata"
<?php if(isset($row['rCity']) && $row['rCity']=="Kolkata") {echo "selected";}?>>Kolkata</option>

<option vlaue="Asansol"
<?php if(isset($row['rCity']) && $row['rCity']=="Asansol") {echo "selected";}?>>Asansol</option>
</select>
</div>

<div class="form-group">
<label for="Education">Education</label>
10thPass<input type="checkbox" name="rEdu[]" value="10thPass"
<?php if(in_array('10thPass',$b)) {echo "checked";}?>>

12thPass<input type="checkbox" name="rEdu[]" value="12thPass"
<?php if(in_array('12thPass',$b)) {echo "checked";}?>>
</div>

<input type="file" name="rImage" required>

<input type="hidden" name="Srno" value="<?php if(isset($row['Srno'])) {echo $row['Srno'];}?>">
<input type="submit" value="Update" name="Update" class="btn btn-danger">

<input type="submit" value="Register" name="rReg" class="btn btn-info">
<?php if(isset($msg)) {echo $msg;}?>
</form>
</div>
</div>
</div>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
-->
</body>
</html>
<!-------------------------------End registration form-------------------------------->
<!-------------------------------start php code for fetch data----------------------->
<?php
$sql="SELECT *FROM kholi";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0)
{
echo '<table border="3">';
echo "<tr>";
echo "<thead>";
echo "<th>Name</th>";
echo "<th>Email</th>";
echo "<th>Passoword</th>";
echo "<th>Confirm Password</th>";
echo "<th>Gender</th>";
echo "<th>City</th>";
echo "<th>Education</th>";
echo "<th>Profile Picture</th>";
echo "<th>Delete</th>";
echo "<th>Edit</th>";
echo "</thead>";
echo "</tr>";
echo "<tbody>";
while($row=mysqli_fetch_assoc($result))
{
echo "<tr>";
echo "<td>".$row['rName']."</td>";
echo "<td>".$row['rEmail']."</td>";
echo "<td>".$row['rPass']."</td>";
echo "<td>".$row['rConPass']."</td>";
echo "<td>".$row['rGender']."</td>";
echo "<td>".$row['rCity']."</td>";
echo "<td>".$row['rEdu']."</td>";
echo '<td><img src="images/'.$row['rImage'].'"></td>';
echo '<td><form action="" method="POST">
<input type="hidden" name="Srno" value='.$row['Srno'].'>
<input type="submit" value="Delete" name="Delete">
</form></td>';
    
echo '<td><form action="" method="POST">
<input type="hidden" name="Srno" value='.$row['Srno'].'>
<input type="submit" value="Edit" name="Edit">
</form></td>';
echo "</tr>";
}
echo "</tbody>";
echo "</table>";
}
else
{
echo "Data not found";
}
?>
<!-------------------------------End php code  for fetch data------------------------->

<!-------------------------------start php code for delete button---------------------->
<?php
if(isset($_POST['Delete']))
{
$Srno=$_POST['Srno'];
$sql="SELECT *FROM kholi";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$dImage=$row['rImage'];
unlink('images/'.$dImage);
$sql="DELETE FROM kholi WHERE Srno='".$Srno."'";
if(mysqli_query($conn,$sql))
{
echo '<div class="alert alert-warning mt-3 text-center">Data Deleated Successfully</div>';
}
else
{
echo '<div class="alert alert-warning mt-3 text-center">unable to Data Deleated Successfully</div>';
}
}
?>
<!-------------------------------End php code  for delete button----------------------->

<!-------------------------------start php code  for update button--------------------->
<?php
if(isset($_POST['Update']))
{
if(($_POST['rName']=="")||($_POST['rEmail']=="")||($_POST['rPass']=="")||($_POST['rConPass']=="")||empty($_POST['rGender'])||($_POST['rCity']=="")||empty($_POST['rEdu'])||empty($_FILES['rImage']))
{
$msg="<br>Fill all The Fields";
}
else
{
$Srno=$_POST['Srno'];
$rName=$_POST['rName'];
$rEmail=$_POST['rEmail'];
$rPass=$_POST['rPass'];
$rConPass=$_POST['rConPass'];
$rGender=$_POST['rGender'];
$rCity=$_POST['rCity'];
$rEdu=$_POST['rEdu'];
$rImage=$_FILES['rImage'];
$rFinalEdu=implode(',',$rEdu);
$iName=$_FILES['rImage']['name'];
$i_tmp_name=$_FILES['rImage']['tmp_name'];
move_uploaded_file($i_tmp_name,'images/'.$iName);
$sql="UPDATE kholi SET rName='$rName',rEmail='$rEmail',rPass='$rPass',rConPass='$rConPass',rGender='$rGender',
rCity='$rCity',rEdu='$rFinalEdu',rImage='$iName' WHERE Srno='".$Srno."'";
if(mysqli_query($conn,$sql))
{
echo '<div class="alert alert-warning mt-3 text-center">Data Updated Successfully</div>';
}
else
{
echo '<div class="alert alert-warning mt-3 text-center">Unable to Update data</div>';
}
}
}
?>
<!-------------------------------End php code  for update button----------------------->