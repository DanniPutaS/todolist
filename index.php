<?php
	include 'database.php';


	if(isset($_POST['add'])){
		$q_insert = "insert into tasks (tasklabel, taskstatus) value (
		'".$_POST['task']."',
		'open'
		)";
		$run_q_insert = mysqli_query($conn, $q_insert);
		if($run_q_insert){
			header('Refresh:0; url=index.php');
		}
	}

	$q_select = "select * from tasks order by taskid desc";
	$run_q_select = mysqli_query($conn, $q_select);
	// delete 
	if(isset($_GET['delete'])){
		$q_delete = "delete from tasks where taskid = '".$_GET['delete']."' ";
		$run_q_delete = mysqli_query($conn, $q_delete);
		header('Refresh:0; url=index.php');
	}
	// proses update data (close or open)
	if(isset($_GET['done'])){
		$status = 'close';
		if($_GET['status'] == 'open'){
			$status = 'close';
		}else{
			$status = 'open';
		}
		$q_update = "update tasks set taskstatus = '".$status."' where taskid = '".$_GET['done']."' ";
		$run_q_update = mysqli_query($conn, $q_update);
		header('Refresh:0; url=index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>To Do List</title>
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="style.css">
	<style>
@import url('https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&display=swap');
</style>
</head>
	<body>
	<div class="container">
		<div class="header">
			<div class="title">
				<i class='bx bxs-book-content'></i>
				<span>To Do List</span>
			</div>
			<div class="description">
				<?= date("l, d M Y") ?>
			</div>
		</div>
		<div class="content">
			<div class="card">
				<form action="" method="post">
					<input type="text" name="task" class="input-control" placeholder="Tambahkan Tugas:">
					<div class="text-right">
						<button type="submit" name="add">Add</button>
					</div>
				</form>
			</div>
			<?php
				if(mysqli_num_rows($run_q_select) > 0){
					while($r = mysqli_fetch_array($run_q_select)){
			?>
			<div class="card">
				<div class="task-item <?= $r['taskstatus'] == 'close' ? 'done':'' ?>">
					<div>
						<input type="checkbox" onclick="window.location.href = '?done=<?= $r['taskid'] ?>&status=<?= $r['taskstatus'] ?>'" <?= $r['taskstatus'] == 'close' ? 'checked':'' ?>>
						<span><?= $r['tasklabel'] ?></span>
					</div>
					<div>
						<a href="edit.php?id=<?= $r['taskid'] ?>" class="text-orange" title="Edit"><i class="bx bx-edit"></i></a>
						<a href="?delete=<?= $r['taskid'] ?>" class="text-red" title="Remove" onclick="return confirm('Are you sure ?')"><i class="bx bx-trash"></i></a>
					</div>
				</div>
			</div>
			<?php }} else { ?>
				<div>Belum ada task</div>
			<?php } ?>
		</div>
	</div>
<footer>
  <center>
	  <span>Original Design By:</span><a href="http://youtube.com/@dzulfikarnurfikr?si=9YZ29CwxBKM6Z0YZ"><i class='bx bxl-youtube'></i></a><br>
	  <span>Remake By:</span>
	  <a href="https://www.instagram.com/dannptrs?igsh=MWo1bjhzNDhueTY2Mw=="><i class='bx bxl-instagram-alt'></i></a>
	  </center>
	  </footer>
</body>
</html>
</html>