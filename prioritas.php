if (isset($_POST['add'])) {
    $task = isset($_POST['task']) ? trim($_POST['task']) : "";
    $deadline = isset($_POST['deadline']) ? $_POST['deadline'] : "";
    $priority = isset($_POST['priority']) ? $_POST['priority'] : "Medium";

    if (!empty($task) && !empty($deadline)) {
        $q_insert = "INSERT INTO tasks (tasklabel, taskstatus, deadline, priority) VALUES ('$task', 'open', '$deadline', '$priority')";
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