<?php 

include "connection.php";

$sql = "Select device.sno,device.fname,device.lname,device.mac,device.email, max(ca.availability) as availability, ca.last_modified 
from current_availability ca join device on device.mac = ca.mac
group by device.email;";
$stmt = $pdo->prepare($sql);
$stmt->execute();


$table = "<table width='100%' class='table table-striped table-bordered table-hover' id='term-view'>";
$table.= "
<thead>
<tr>
<b>
<th>First Name</th>
<th>Last Name</th>
<th>Email</th>
<th>Availability</th>
</b>
</tr>
</thead>";

$table.= "<tbody>";

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  $table.="<tr>";

  $table.= "<td>".$row['fname']."</td>";
  $table.= "<td>".$row['lname']."</td>";
  $table.= "<td>".$row['email']."</td>";
  $table.= "<td>".$row['availability']."</td>";


  $table.= "</tr>";

}
$table.= "</tbody></table>";


?>


<html>
<head>

</head>
<body>
	<?php if(isset($error)) echo $error; ?>
	<div class="container">
		<p><center><h1>View Faculty Avilability</h1></center></p>
    <br>
		<?php echo $table; ?>
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