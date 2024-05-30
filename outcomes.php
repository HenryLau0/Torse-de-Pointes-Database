<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}

// Close the current session
session_write_close();

// Include the chosen PHP file
if (isset($_GET['file'])) {
    $file = $_GET['file'];

    if ($file == 'outcomes.php') {
        require_once __DIR__ . '/outcomes.php';
    } elseif ($file == 'patient.php') {
        require_once __DIR__ . '/patient.php';
    } elseif ($file == 'drugs.php') {
        require_once __DIR__ . '/drugs.php';
    } elseif ($file == 'properties.php') {
        require_once __DIR__ . '/properties.php';
    }
}

$user = $_SESSION['user'];

$conn = mysqli_connect("localhost", "root", "", "torsade_de_pointes");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $Management = mysqli_real_escape_string($conn, $_POST['Applied Clinical TdP Management']);
    $QRS = mysqli_real_escape_string($conn, $_POST['QRS Postintervention [ms]']);
    $QT_QTc = mysqli_real_escape_string($conn, $_POST['QT/QTc Post Intervention [ms]']);
    $Results = mysqli_real_escape_string($conn, $_POST['Therapy Results']);
    $Comments = mysqli_real_escape_string($conn, $_POST['Comments']);
    
    $date = date("Y-m-d");

    if (isset($_GET['action']) && $_GET['action'] == "edit") {
        $id = $_GET['id'];
        $id = mysqli_real_escape_string($conn, $id);

        $query = "UPDATE outcome_t SET 'Applied Clinical TdP Management'='$Management', 'QRS Postintervention [ms]'='$QRS', 'QT/QTc Post Intervention [ms]'='$QT_QTc', 'Therapy Results'='$Results', Comments='$Comments' WHERE `Case ID`='$id'";

        if (mysqli_query($conn, $query)) {
            header("location: outcomes.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        $query = "INSERT INTO outcome_t ('Applied Clinical TdP Management', 'QRS Postintervention [ms]', 'QT/QTc Post Intervention [ms]', 'Therapy Results', Comments, date_posted) 
              VALUES ('$Management', '$QRS', '$QT_QTc', '$Results', '$Comments', '$date')";

        if (mysqli_query($conn, $query)) {
            header("location: outcomes.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<html>
<head>
    <title>Torsade de Pointes</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        .table {
            margin: 0 auto;
            width: 90%;
        }

        th, td {
            text-align: center;
            padding: 8px;
            font-size: 13px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        th {
            background-color: #001E97;
            color: white;
        }

        .edit-button {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 8px 16px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin: 4px 2px;
        transition-duration: 0.4s;
        cursor: pointer;
        border-radius: 4px;
    }

    .edit-button:hover {
        background-color: #45a049;
        text-decoration: none;
    }

    .delete-button {
        background-color: red;
        border: none;
        color: white;
        padding: 8px 16px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin: 4px 2px;
        transition-duration: 0.4s;
        cursor: pointer;
        border-radius: 4px;
    }

    .delete-button:hover {
        background-color: red;
        text-decoration: none;
    }
    </style>
</head>

<body>
<nav style="text-align:center;" class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand">Torsade de Pointes</a>
    <a class="navbar-brand" style="font-size:20px; color:cyan;" href="home.php">Home</a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Details
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="patient.php">Patients' Details</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="outcomes.php">Outcomes</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="drugs.php">Drugs</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="properties.php">Drugs Properties</a>
                </div>
            </li>
        </ul>
        <a href="logout.php">
            <button type="button" class="btn btn-danger">Log Out</button>
        </a>
    </div>
</nav><br>

<h2 align="center" style="font-weight:bold; font-family: 'Trirong',serif">Outcomes</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['action'])) {
    if ($_GET['action'] == "edit") {
        $id = $_GET['id'];
        $id = mysqli_real_escape_string($conn, $id);

        $query = "SELECT * FROM outcome_t WHERE `Case ID`='$id'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $editManagement = isset($row['Applied Clinical TdP Management']) ? $row['Applied Clinical TdP Management'] : '';
            $editQRS = isset($row['QRS Postintervention [ms]']) ? $row['QRS Postintervention [ms]'] : '';
            $editQT_QTc = isset($row['QT/QTc Post Intervention [ms]']) ? $row['QT/QTc Post Intervention [ms]'] : '';
            $editResults = isset($row['Therapy Results']) ? $row['Therapy Results'] : '';
            $editComments = isset($row['Comments']) ? $row['Comments'] : '';
            ?>

            <style>
                .form-container {
                    max-width: 400px;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: #f7f7f7;
                    border: 1px solid #ddd;
                }

                .form-container label {
                    display: block;
                    margin-bottom: 10px;
                    font-weight: bold;
                }

                .form-container input[type="text"] {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    margin-bottom: 15px;
                }

                .form-container input[type="submit"],
                .form-container button {
                    padding: 10px 20px;
                    background-color: #4CAF50;
                    border: none;
                    color: #fff;
                    border-radius: 5px;
                    cursor: pointer;
                }

                .form-container button {
                    background-color: #f44336;
                    margin-top: 10px;
                }
            </style>

            <div class="form-container">
                <form action="outcomes.php?action=edit&id=<?= $id ?>" method="POST">
                    <label for="Applied Clinical TdP Management">Applied Clinical TdP Management:</label>    
                    <textarea type="text" id="Applied Clinical TdP Management" name="Applied Clinical TdP Management" style="height:200px; margin-top: 6px; width:360px" placeholder="Write something.." value="<?= $editManagement ?>" required></textarea><br><br>
                    <label for="QRS Postintervention [ms]">QRS Postintervention [ms]:</label>
                    <input type="text" id="QRS Postintervention [ms]" name="QRS Postintervention [ms]" value="<?= $editQRS ?>" required><br><br>
                    <label for="QT/QTc Post Intervention [ms]">QT/QTc Post Intervention [ms]:</label>
                    <input type="text" id="QT/QTc Post Intervention [ms]" name="QT/QTc Post Intervention [ms]" value="<?= $editQT_QTc ?>" required><br><br>
                    <label for="Therapy Results">Therapy Results:</label>
                    <textarea type="text" id="Therapy Results" name="Therapy Results" style="height:200px; margin-top: 6px; width:360px" placeholder="Write something.." value="<?= $editResults ?>" required></textarea><br><br>
                    <label for="Comments">Comments:</label>
                    <textarea type="text" id="Comments" name="Comments" style="height:200px; margin-top: 6px; width:360px" placeholder="Write something.." value="<?= $editComments ?>" required></textarea><br><br>
                    
                    <input type="submit" value="Update"><br><br>
                    <button type="button" onclick="window.location.href='outcomes.php'">Cancel</button><br><br>
                </form>
            </div>

            <?php
                } else {
                    echo "No record found.";
                }
            } else if ($_GET['action'] == "delete" && isset($_GET['id'])) {
                $id = $_GET['id'];
                $id = mysqli_real_escape_string($conn, $id);
            ?>

        <script>
            var result = confirm("Are you sure you want to delete this record?");
            if (result) {
                window.location.href = "outcomes.php?action=confirm_delete&id=<?= $id ?>";
            } else {
                window.location.href = "outcomes.php";
            }
        </script>

        <?php
            } else if ($_GET['action'] == "confirm_delete" && isset($_GET['id'])) {
                $id = $_GET['id'];
                $id = mysqli_real_escape_string($conn, $id);

                $query = "DELETE FROM outcome_t WHERE `Case ID`='$id'";

                if (mysqli_query($conn, $query)) {
                    header("location: outcomes.php");
                    exit();
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }
        }

        $recordsPerPage = 30;
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($currentPage - 1) * $recordsPerPage;

        $query = "SELECT * FROM outcome_t LIMIT $offset, $recordsPerPage"; // SQL Query
        $result = mysqli_query($conn, $query);
        $resultCheck = mysqli_num_rows($result);
        ?>


<form action="outcomes.php" method="POST" style="max-width:400px; padding:20px; margin: 0 auto" class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin">
    <div id="pmidSection" class="w3-row w3-section">
        Applied Clinical TdP Management: <input type="text" name="PMID" id="PMID" onchange="showSourceTextbox()" required/><br/>
    </div><br>

    <div id="sourceSection" style="display: none;" class="w3-row w3-section">
        Applied Clinical TdP Management: <input type="text" name="Applied Clinical TdP Management" id="Applied Clinical TdP Management" required/><br><br>
        QRS Postintervention [ms]: <input type="text" name="QRS Postintervention [ms]" id="QRS Postintervention [ms]" required/><br><br>
        QT/QTc Post Intervention [ms]: <input type="text" name="QT/QTc Post Intervention [ms]" id="QT/QTc Post Intervention [ms]" required/><br><br>
        Therapy Results: <input type="text" name="Therapy Results" id="Therapy Results" required/><br><br>
        Comments: <input type="text" name="Comments" id="Comments" required/><br><br>
        <input type="submit" value="Add" class="w3-button w3-block w3-section w3-blue w3-ripple w3-padding"><br><br>
    </div>
</form>

<table class="table" border="1px" width="100%">
    <tr style="text-align:center;font-size:20px">
        <th>Case ID</th>
        <th>Applied Clinical TdP Management</th>
        <th>QRS Postintervention [ms]</th>
        <th>QT/QTc Post Intervention [ms]</th>
        <th>Therapy Results</th>
        <th>Comments</th>
        <th>Post Time</th>
        <th>Edited Time</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo '<td align="center">' . (isset($row['Case ID']) ? $row['Case ID'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['Applied Clinical TdP Management']) ? $row['Applied Clinical TdP Management'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['QRS Postintervention [ms]']) ? $row['QRS Postintervention [ms]'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['QT/QTc Post Intervention [ms]']) ? $row['QT/QTc Post Intervention [ms]'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['Therapy Results']) ? $row['Therapy Results'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['Comments']) ? $row['Comments'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['date_posted']) ? $row['date_posted'] : '') . " - " . (isset($row['time_posted']) ? $row['time_posted'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['date_edited']) ? $row['date_edited'] : '') . " - " . (isset($row['time_edited']) ? $row['time_edited'] : '') . "</td>";
            echo '<td align="center"><a href="outcomes.php?action=edit&id=' . (isset($row['Case ID']) ? $row['Case ID'] : '') . '&page=' . $currentPage . '" class="edit-button">Edit</a></td>';
            echo '<td align="center"><a href="outcomes.php?action=delete&id=' . (isset($row['Case ID']) ? $row['Case ID'] : '') . '&page=' . $currentPage . '" class="delete-button">Delete</a></td>';
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7' align='center'>No records found.</td></tr>";
    }
    ?>
</table>
    
<div class="d-flex justify-content-center mt-4">
    <?php
    // Pagination
    $query = "SELECT COUNT(*) AS total FROM outcome_t";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $totalRecords = $row['total'];
    $totalPages = ceil($totalRecords / $recordsPerPage);
    $url = "outcomes.php?page=";

    if ($totalPages > 1) {
        echo '<nav aria-label="Page navigation example">
                    <ul class="pagination">';
        if ($currentPage > 1) {
            echo '<li class="page-item"><a class="page-link" href="' . $url . ($currentPage - 1) . '">Previous</a></li>';
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $currentPage) {
                echo '<li class="page-item active"><a class="page-link" href="' . $url . $i . '">' . $i . '</a></li>';
            } else {
                echo '<li class="page-item"><a class="page-link" href="' . $url . $i . '">' . $i . '</a></li>';
            }
        }

        if ($currentPage < $totalPages) {
            echo '<li class="page-item"><a class="page-link" href="' . $url . ($currentPage + 1) . '">Next</a></li>';
        }
        echo '</ul></nav>';
    }
    ?>
</div>

<script>
    function showSourceTextbox() {
        var pmid = document.getElementById("PMID").value;
        var sourceSection = document.getElementById("sourceSection");
        if (pmid.length > 0) {
            sourceSection.style.display = "block";
        } else {
            sourceSection.style.display = "none";
        }
    }
</script>
</body>
</html>
