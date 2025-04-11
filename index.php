<?php
include 'database.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil userid dari username
$username = $_SESSION['username'];
$get_user = mysqli_query($conn, "SELECT id FROM users WHERE username = '$username'");
$user_data = mysqli_fetch_assoc($get_user);
$userid = $user_data['id'];

// Logout
if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

// Proses tambah tugas
if (isset($_POST['add'])) {
    $task = isset($_POST['task']) ? trim($_POST['task']) : "";
    $deadline = isset($_POST['deadline']) ? $_POST['deadline'] : "";
    $priority = isset($_POST['priority']) ? $_POST['priority'] : "Medium";

    if (!empty($task) && !empty($deadline)) {
        $q_insert = "INSERT INTO tasks (userid, tasklabel, taskstatus, deadline, priority) 
                     VALUES ('$userid', '$task', 'open', '$deadline', '$priority')";
        $run_q_insert = mysqli_query($conn, $q_insert);

        if ($run_q_insert) {
            header("Location: index.php");
            exit;
        } else {
            echo "<script>alert('Gagal menambahkan tugas: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Task dan deadline harus diisi!');</script>";
    }
}

// Ambil daftar tugas hanya milik user ini
$q_select = "SELECT * FROM tasks WHERE userid = '$userid' ORDER BY taskid DESC";
$run_q_select = mysqli_query($conn, $q_select);

// Hapus tugas
if (isset($_GET['delete'])) {
    $taskid = $_GET['delete'];
    $q_delete = "DELETE FROM tasks WHERE taskid ='$taskid' AND userid = '$userid'";
    $run_q_delete = mysqli_query($conn, $q_delete);
    header("Location: index.php");
    exit;
}

// Update status tugas (open/close)
if (isset($_GET['done'])) {
    $taskid = $_GET['done'];
    $status = ($_GET['status'] == 'open') ? 'close' : 'open';
    $q_update = "UPDATE tasks SET taskstatus ='$status' WHERE taskid = '$taskid' AND userid = '$userid'";
    $run_q_update = mysqli_query($conn, $q_update);
    header("Location: index.php");
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TO DO LIST</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');

* { 
    padding: 0;
    margin: 0;
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
    padding: 0 px;
    height: 100vh;
    margin: 0px auto;
}

.header { 
    padding: 15px;
    height: 80px;
    color: #fff;
}

.header.title {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.header.title i {
    font-size: 18px;
    margin-right: 8px;
}

.header.title span {
    font-size: 18px;
}

.header.description {
    font-size: 13px;
}

.content { 
    /*border: 1px solid #ddd;*/
    margin-top: 0px;
    padding: 15px;
    border-radius: 5px;
    
}    

.main-card{
    background-color:#blue;
    padding: 15px;
    margin-bottom: 12px;
    color: #1D1616;
    border-radius: 5px;
    /*border: 1px solid #ddd;*/
    margin-bottom: 25px;
} 

.input-control {
    width: 100%;
    display: block;
    padding: 0.5rem;
    font-size: 1rem;
    margin-bottom: 10px;
}   

.text-right {
    text-align: right;
}   

.button {
    padding: 0.5rem 1rem;
    font-size: 1rem;
    cursor: pointer;
    background: #4ECDC4; 
    background: -webkit-linear-gradient(to right, #556270, #4ECDC4);  
    background: linear-gradient(to right, #556270, #4ECDC4);
    border: 1px solid;
    border-radius: 3px;
}

.task-item {
    width: calc(115% - 50px); /* Menyesuaikan dengan margin/padding */
    margin-left: -16px;
    margin-right: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px;
    background-color: #fff;
    border-radius: 5px;
    border: 1px solid #ddd;
    transition: box-shadow 0.3s ease-in-out;
   
}

.task-item:hover {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.text-orange {
    color: orange;
}

.task-item input[type="checkbox"] {
    margin-right: 12px;
    transform: scale(1.2);
}

.task-item span {
    flex-grow: 1;
    text-align: left;
    font-weight:400;
}

.task-deadline {
    font-size: 14px;
    text-align: right;
    color: #888;
    margin-right: 10px;
    white-space: nowrap;
}

.task-actions {
    display: flex;
    gap: 10px;
}

.task-actions a {
    cursor: pointer;
    font-size: 18px;
    color: #555;
    transition: color 0.2s;
}

.task-actions a:hover {
    color: #ff6b6b;
}

.logout-btn {
    background: #556270;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
}

.logout-btn:hover {
    background: #4ECDC4;
}

.task-link {
    text-decoration: none;
    color: inherit;
    display: block;
    padding: 15px;
   /* border: 1px solid #ddd;*/s
    border-radius: 5px;
    margin-bottom: 15px;
    background-color: #fff
    transition: box-shadow 0.3s;
}

.task-link:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

</style>
</head>
<body>

    <div class="logout">
        <form action="" method="post">
            <button type="submit" name="logout" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="container">
        <div class="header">
            <div class="title">
                <i class='bx bx-sun'></i>
                <span> TO DO LIST </span>
            </div>
            <div class="description">
                <?= date("l, d M Y") ?>
            </div>
            
        </div>

        <div class="content">

        </div>
        <div class="card">
        
        <form action="" method="post" style="width: 100%;">
    <input type="text" name="task" placeholder="New subtask" class="task-input" style="width: 100%; padding: 8px; font-size: 16px; margin-bottom: 5px;">
    
    <input type="date" name="deadline" class="date-input" style="width: 100%; padding: 8px; font-size: 16px; margin-bottom: 5px;">
    
    <select name="priority" class="priority-select" style="width: 100%; padding: 8px; font-size: 16px; margin-bottom: 5px;">
        <option value="Medium">Medium</option>
        <option value="Low">Low</option>
        <option value="High">High</option>
    </select>
    <br>
    <div class="text-right">
        <button type="submit" name="add" style="padding: 5px 12px; font-size:16 px; cursor pointer;">Add</button>
    </div>
</form>


       <?php if (mysqli_num_rows($run_q_select) > 0) { 
    while ($r = mysqli_fetch_array($run_q_select)) { ?>
        <div class="card">
            <a href="details.php?taskid=<?= $r['taskid'] ?>" class="task-link">
                <div class="task-item <?= $r['taskstatus'] == 'close' ? 'done' : '' ?>">
                    <div>


                        <input type="checkbox" onclick="window.location.href = '?done=<?= $r['taskid'] ?>&status=<?= $r['taskstatus'] ?>'" <?= $r['taskstatus'] == 'close' ? 'checked' : '' ?>>
                        
                        <span><?= htmlspecialchars($r['tasklabel']) ?></span>
                    </div>
                    <div class="task-deadline"><?= date("d M Y", strtotime($r['deadline'])) ?><br>
                    <span class="task-priority"> <strong><?= htmlspecialchars($r['priority']) ?></strong></span>
                </div>

                </div>
            </a>
            <div class="task-actions">
                <a href="edit.php?id=<?= $r['taskid'] ?>" class="text-blue" title="Edit"><i class="bx bx-edit"></i></a>
                <a href="?delete=<?= $r['taskid'] ?>" class="text-orange" title="Hapus" onclick="return confirm('Are you sure?')"><i class="bx bx-trash"></i></a>
            </div>
        </div>

        <!-- <div class="task-item">
            <div>

            </div>
            <div class="task-deadline">
                
                  
                </div>
         </div>

        </div> -->
   <div class="task-actions">
</div>

  
        <?php }} else { ?>
            <div class="card">Belum ada tugas</div>
        <?php } ?>

        

    </div>  

</body> 
</html>