<?php

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

session_start();

$ammount = $_POST['ammount'];

$_SESSION['ammount'] = $ammount;
$id = $_GET['id'];
$affiliate = $_GET['affiliate'];

?>
<script>
    window.location.href='buy?id=<?php echo $id; ?>&affiliate=<?php echo $affiliate; ?>'
</script>
