<?php
	include 'database.php';

    // select data yang akan di edit
    $q_select = "select * from tasks where taskid ='".$_GET['id']."' ";
    $run_q_select = mysqli_query($conn, $q_select);
    $d = mysqli_fetch_object($run_q_select);

    //proses edit data 
    if(isset($_POST['edit'])){
    	$q_update = "update tasks set tasklabel= '".$_POST['task']."' where taskid ='".$_GET['id']."' ";
    	$run_q_update = mysqli_query($conn, $q_update);
    	// header('Refresh:0; url=index.php ');
    }
?> 

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale1">
	<title>TO DO LIST</title>
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');
		* { 
			padding:0;
			margin:0;
			box-sizing: border-box;
		}
		body { 
			font-family: 'Cormorant Garamond', serif;
			background: #4ECDC4;  
		    background: -webkit-linear-gradient(to right, #556270, #4ECDC4);  
		    background: linear-gradient(to right, #556270, #4ECDC4); 
        }

		.container { 
		 	width: 590px;
		 	padding:0px;
		 	height:100vh;
		 	margin:0px auto;
		}
		.header { 
			padding:15px;
			height: 80px;
			color:#fff;
		}
		.header.title {
		 	display:flex;
			align-items:center;
		 	margin-bottom:pxpx;
		}
		.header.title i {
		 	font-size: 18px;
		 	margin-right: 8px;
		 	color:#fff;
		}
		.header.title span {
		 	font-size:18px;
		 	padding:15px;
		}
		.header.description {
		 	font-size:13px;
		}

		/* Diperbaiki agar jaraknya lebih dekat ke Thursday */
		.content{ 
		 	border: 1px solid transparent;
		 	margin-top: 10px;
		}

		.card {
		 	background-color:#fff;
		 	padding:15px;
		 	border-radius:5px;
		 	margin-bottom:10px;
		 	color:#1D1616;
		} 
		.input-control {
			width:100%;
			display:block;
			padding:0.5rem;
			font-size:1rem;
			margin-bottom:10px;
		}	
		 
		.text-right{
			text-align:right;
		}	
		button {
			padding:0.5rem 1rem;
			font-size:1rem;
			cursor:pointer;
			background: #4ECDC4; 
   		    background: -webkit-linear-gradient(to right, #556270, #4ECDC4);  
   		    background: linear-gradient(to right, #556270, #4ECDC4); 
			color:#fff;	
			border:1px solid;
			border-radius:3px;
		}
		.task-item {
		 	display:flex;
		 	justify-content:space-between;
		}
		.text-blue {
			color: blue;
		}
		.text-orange{
			color:orange;
		}
		.task-item.done span {
			text-decoration:line-through;
			color:#ccc;
		} 
	</style>
</head>
<body>
	
 	<div class="container">

 		<div class="header">
 			<div class="title">
 				<a href="index.php"><i class='bx bx-left-arrow'></i></a>
 				<span> BACK </span>
 			</div>
 			<div class="description">
 				<?= date("l, d M Y") ?>
 			</div>
 		</div>
 				
 		<div class="content">
			<div class="card">
				<form action="" method="post"> 
					<input type="text" name="task" class="input-control" placeholder="Edit task" value="<?= $d->tasklabel ?>">
					<div class="text-right">
						<button type="submit" name="edit">Edit</button>
					</div>
				</form>
			</div>
		</div>

 	</div>	
</body>	
</html>
