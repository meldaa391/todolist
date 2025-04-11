<?php
include 'database.php';

// Proses penyimpanan subtask
if (isset($_POST['save_subtask'])) {
    $taskid = $_GET['taskid'] ?? null;

    if (!$taskid || !is_numeric($taskid)) {
        die("Task ID is missing or invalid.");
    }

    $taskid = (int) $taskid;
    $subtask = mysqli_real_escape_string($conn, $_POST['subtask']);

    if (empty($subtask)) {
        die("Subtask field is empty.");
    }

    $stmt = $conn->prepare("INSERT INTO subtasks (taskid, subtask) VALUES (?, ?)");
    $stmt->bind_param("is", $taskid, $subtask);
    
    if ($stmt->execute()) {
        echo "<script>alert('Subtask added successfully!'); window.location.href = 'details.php?taskid=$taskid';</script>";
    } else {
        die("Query Error: " . mysqli_error($conn));
    }
}

// Proses penghapusan subtask
if (isset($_GET['delete'])) {
    $subtask_id = (int) $_GET['delete'];
    $taskid = $_GET['taskid'] ?? null;
    
    mysqli_query($conn, "DELETE FROM subtasks WHERE id = '$subtask_id'");
    header("Location: details.php?taskid=$taskid");
    exit();
}

// Proses edit subtask
if (isset($_POST['edit_subtask'])) {
    $subtask_id = (int) $_POST['subtask_id'];
    $new_subtask = mysqli_real_escape_string($conn, $_POST['new_subtask']);
    $taskid = $_GET['taskid'] ?? null;

    mysqli_query($conn, "UPDATE subtasks SET subtask = '$new_subtask' WHERE id = '$subtask_id'");
    header("Location: details.php?taskid=$taskid");
    exit();
}

// Ambil daftar subtask
$taskid = $_GET['taskid'] ?? null;
$subtasks = [];
if ($taskid) {
    $taskid = (int) $taskid;
    $result = mysqli_query($conn, "SELECT * FROM subtasks WHERE taskid = '$taskid'");
    while ($row = mysqli_fetch_assoc($result)) {
        $subtasks[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #556270, #4ECDC4);
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
        }
        textarea, input[type='text'] {
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            border: none;
            text-align: center;
            font-size: 16px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            margin: 5px;
            background: linear-gradient(to right, #556270, #4ECDC4);
            color: white;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background: rgba(255, 255, 255, 0.3);
            padding: 15px;
            margin: 5px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .edit-input {
            display: none;
        }

        .form-inline {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-inline textarea {
            flex: 1;
            resize: none;
        }
    </style>
    <script>
        function enableEdit(id) {
            document.getElementById('text-' + id).style.display = 'none';
            document.getElementById('input-' + id).style.display = 'inline';
            document.getElementById('save-' + id).style.display = 'inline';
        }

        function prepareSave(id) {
            const newValue = document.getElementById('input-' + id).value;
            document.getElementById('save-input-' + id).value = newValue;
        }
    </script>
</head>
<body>
    <div class="container">
        <h3>Subtask:</h3>
        <div class="form-section">
            <form method="post" class="form-inline">
                <textarea name="subtask" placeholder="Add Subtask..."></textarea>
                <button type="submit" name="save_subtask">ADD</button>
            </form>
        </div>

        <ul>
            <?php foreach ($subtasks as $sub) : ?>
                <li>
                    <span id="text-<?= $sub['id'] ?>"><?= htmlspecialchars($sub['subtask']) ?></span>
                    <input type="text" id="input-<?= $sub['id'] ?>" class="edit-input" value="<?= htmlspecialchars($sub['subtask']) ?>">

                    <div class="actions">
                        <a href="?taskid=<?= $taskid ?>&delete=<?= $sub['id'] ?>">Delete</a>
                        <button type="button" onclick="enableEdit(<?= $sub['id'] ?>)">Edit</button>

                        <form method="post" style="display:inline;" onsubmit="prepareSave(<?= $sub['id'] ?>)">
                            <input type="hidden" name="subtask_id" value="<?= $sub['id'] ?>">
                            <input type="hidden" name="new_subtask" id="save-input-<?= $sub['id'] ?>">
                            <button type="submit" id="save-<?= $sub['id'] ?>" name="edit_subtask" class="edit-input">Save</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
