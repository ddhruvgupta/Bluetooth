<?php 

session_start();

  if(!isset($_SESSION['success'])){
    header("location: ./utils/login.php");
    return;
  }

include "./utils/connection.php";


if($_SESSION['role'] == 'admin'){
  $sql = "Select * from device";
}elseif($_SESSION['role'] == 'faculty'){
  $sql = "Select * from device where email = :email";
}else{
    header("location: index.php");
    return;
}

$stmt = $pdo->prepare($sql);
$stmt->execute(array(':email' => $_SESSION['email'] ));


$table = "<table width='100%' class='table table-striped table-bordered table-hover' id='term-view'>";
$table.= "
<thead>
<tr>
<b>
<th>First Name</th>
<th>Last Name</th>
<th>Email</th>
<th>Device name</th>
<th>Bluetooth Address</th>
<th>Alter</th>
</b>
</tr>
</thead>";

$table.= "<tbody>";

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  $table.="<tr>";

  $table.= "<td>".$row['fname']."</td>";
  $table.= "<td>".$row['lname']."</td>";
  $table.= "<td>".$row['email']."</td>";
  $table.= "<td>".$row['device_name']."</td>";
  $table.= "<td>".$row['mac']."</td>";
  $table.="<td>
     <form method='post'>
    <input type='hidden' id='sno' name='sno' value={$row['sno']} >
    <input type='hidden' id='mac' name='mac' value={$row['mac']} >
    <input type='submit' name='delete' value='delete'>
    </form>
    </td>";

  $table.= "</tr>";

}
$table.= "</tbody></table>";


if(isset($_POST['delete'])){
  $sql = "DELETE from device where sno = :sno";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':sno'=>$_POST['sno']));

  $sql = "DELETE from current_availability where mac = :mac";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':mac'=>$_POST['mac']));

  $_SESSION['insert'] = 'Record Successfully Deleted';
  header('location: viewDevices.php');
  return;
}

?>


<html>
<head>

</head>
<body>
	<?php if(isset($error)) echo $error; ?>
	<div class="container">
		<p><center><h1>View Device List</h1></center></p>
    <br>
		<?php 
    echo $table; 
    echo("<a href='utils/logout.php'>LOGOUT</a>");
    ?>
	</div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.6/css/select.bootstrap.min.css">


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script type="text/javascript">

  $( document ).ready(function() {
    $(document).ready(function() {
      $('#term-view').DataTable({
        responsive: true

      });

    });
  });

</script>

</html>