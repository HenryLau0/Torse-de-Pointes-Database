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

    if ($file == 'patient.php') {
        require_once __DIR__ . '/patient.php';
    } elseif ($file == 'outcomes.php') {
        require_once __DIR__ . '/outcomes.php';
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
    $PMID = mysqli_real_escape_string($conn, $_POST['PMID']);
    $Age = mysqli_real_escape_string($conn, $_POST['Age']);
    $Sex = mysqli_real_escape_string($conn, $_POST['Sex']);
    $Disease = mysqli_real_escape_string($conn, $_POST['Disease']);
    $BP = mysqli_real_escape_string($conn, $_POST['BP']);
    $HR = mysqli_real_escape_string($conn, $_POST['HR']);
    $Breaths = mysqli_real_escape_string($conn, $_POST['Breaths']);
    $Temp = mysqli_real_escape_string($conn, $_POST['Temp']);
    $QRS = mysqli_real_escape_string($conn, $_POST['QRS']);
    $QT = mysqli_real_escape_string($conn, $_POST['QT']);
    $QTc = mysqli_real_escape_string($conn, $_POST['QTc']);
    $Drugconc = mysqli_real_escape_string($conn, $_POST['Drugconc']);
    $Ionconc = mysqli_real_escape_string($conn, $_POST['Ionconc']);
    
    $date = date("Y-m-d");

    if (isset($_GET['action']) && $_GET['action'] == "edit") {
        $id = $_GET['id'];
        $id = mysqli_real_escape_string($conn, $id);

        $query = "UPDATE patient_t SET PMID='$PMID', Age='$Age', Sex='$Sex', Disease='$Disease', BP='$BP', HR='$HR', Breaths='$Breaths', Temp='$Temp', QRS='$QRS', QT='$QT', QTc='$QTc', Drugconc='$Drugconc', Ionconc='$Ionconc' WHERE `Case ID`='$id'";

        if (mysqli_query($conn, $query)) {
            header("location: patient.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        $query = "INSERT INTO patient_t (PMID, Age, Sex, Disease, BP, HR, Breaths, Temp, QRS, QT, QTc, Drugconc, Ionconc, date_posted) 
              VALUES ('$PMID', '$Age', '$Sex', '$Disease', '$BP', '$HR', '$Breaths', '$Temp', '$QRS', '$QT', '$QTc', '$Drugconc', '$Ionconc', '$date')";

        if (mysqli_query($conn, $query)) {
            header("location: patient.php");
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

<h2 align="center" style="font-weight:bold; font-family: 'Trirong',serif">Patients' Details</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['action'])) {
    if ($_GET['action'] == "edit") {
        $id = $_GET['id'];
        $id = mysqli_real_escape_string($conn, $id);

        $query = "SELECT * FROM patient_t WHERE `Case ID`='$id'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $editPMID = isset($row['PMID']) ? $row['PMID'] : '';
            $editAge = isset($row['Age']) ? $row['Age'] : '';
            $editSex = isset($row['Sex']) ? $row['Sex'] : '';
            $editDisease = isset($row['Disease']) ? $row['Disease'] : '';
            $editBP = isset($row['BP']) ? $row['BP'] : '';
            $editHR = isset($row['HR']) ? $row['HR'] : '';
            $editBreaths = isset($row['Breaths']) ? $row['Breaths'] : '';
            $editTemp = isset($row['Temp']) ? $row['Temp'] : '';
            $editQRS = isset($row['QRS']) ? $row['QRS'] : '';
            $editQT = isset($row['QT']) ? $row['QT'] : '';
            $editQTc = isset($row['QTc']) ? $row['QTc'] : '';
            $editDrugconc = isset($row['Drugconc']) ? $row['Drugconc'] : '';
            $editIonconc = isset($row['Ionconc']) ? $row['Ionconc'] : '';
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
                <form action="patient.php?action=edit&id=<?= $id ?>" method="POST">
                    <label for="pmid">PMID:</label>    
                    <input type="text" id="pmid" name="PMID" value="<?= $editPMID ?>" required><br><br>
                    <label for="pmid">Age:</label>
                    <input type="text" id="Age" name="Age" value="<?= $editAge ?>" required><br><br>
                    <label for="pmid">Sex:</label>
                    <input type="text" id="Sex" name="Sex" value="<?= $editSex ?>" required><br><br>
                    <label for="pmid">Disease:</label>
                    <input type="text" id="Disease" name="Disease" value="<?= $editDisease ?>" required><br><br>
                    <label for="pmid">BP:</label>
                    <input type="text" id="BP" name="BP" value="<?= $editBP ?>" required><br><br>
                    <label for="pmid">HR:</label>
                    <input type="text" id="HR" name="HR" value="<?= $editHR ?>" required><br><br>
                    <label for="pmid">Breaths:</label>
                    <input type="text" id="Breaths" name="Breaths" value="<?= $editBreaths ?>" required><br><br>
                    <label for="pmid">Temp:</label>
                    <input type="text" id="Temp" name="Temp" value="<?= $editTemp ?>" required><br><br>
                    <label for="pmid">QRS:</label>
                    <input type="text" id="QRS" name="QRS" value="<?= $editQRS ?>" required><br><br>
                    <label for="pmid">QT:</label>
                    <input type="text" id="QT" name="QT" value="<?= $editQT ?>" required><br><br>
                    <label for="pmid">QTc:</label>
                    <input type="text" id="QTc" name="QTc" value="<?= $editQTc ?>" required><br><br>
                    <label for="pmid">Drugconc:</label>
                    <input type="text" id="Drugconc" name="Drugconc" value="<?= $editDrugconc ?>" required><br><br>
                    <label for="pmid">Ionconc:</label>
                    <input type="text" id="Ionconc" name="Ionconc" value="<?= $editIonconc ?>" required><br><br>
                    

                    <input type="submit" value="Update"><br><br>
                    <button type="button" onclick="window.location.href='patient.php'">Cancel</button><br><br>
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
                window.location.href = "patient.php?action=confirm_delete&id=<?= $id ?>";
            } else {
                window.location.href = "patient.php";
            }
        </script>

        <?php
            } else if ($_GET['action'] == "confirm_delete" && isset($_GET['id'])) {
                $id = $_GET['id'];
                $id = mysqli_real_escape_string($conn, $id);

                $query = "DELETE FROM patient_t WHERE `Case ID`='$id'";

                if (mysqli_query($conn, $query)) {
                    header("location: patient.php");
                    exit();
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }
        }

        $recordsPerPage = 30;
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($currentPage - 1) * $recordsPerPage;

        $query = "SELECT * FROM patient_t LIMIT $offset, $recordsPerPage"; // SQL Query
        $result = mysqli_query($conn, $query);
        $resultCheck = mysqli_num_rows($result);
        ?>


<form action="patient.php" method="POST" style="max-width:400px; padding:20px; margin: 0 auto" class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin">
    <div id="pmidSection" class="w3-row w3-section">
        Add Details (PMID): <input type="text" name="PMID" id="PMID" onchange="showSourceTextbox()" required/><br/>
    </div><br>

    <div id="sourceSection" style="display: none;" class="w3-row w3-section">
        Age: <input type="number" name="Age" id="Age" required/><br><br>
        Sex (M or F): <input type="text" name="Sex" id="Sex" required/><br><br>
        Disease: <input type="text" name="Disease" id="Disease" required/><br><br>
        BP: <input type="text" name="BP" id="BP" required/><br><br>
        HR: <input type="number" name="HR" id="HR" required/><br><br>
        Breaths: <input type="number" name="Breaths" id="Breaths" required/><br><br>
        Temp: <input type="number" name="Temp" id="Temp" required/><br><br>
        QRS: <input type="text" name="QRS" id="QRS" required/><br><br>
        QT: <input type="text" name="QT" id="QT" required/><br><br>
        QTc: <input type="text" name="QTc" id="QTc" required/><br><br>
        Drug conc: <input type="number" name="Drugconc" id="Drugconc" required/><br><br>
        Ion conc: <input type="number" name="Ionconc" id="Ionconc" required/><br><br>
        <input type="submit" value="Add" class="w3-button w3-block w3-section w3-blue w3-ripple w3-padding"><br><br>
    </div>
</form>

<table class="table" border="1px" width="100%">
    <tr style="text-align:center;font-size:20px">
        <th>Case ID</th>
        <th>PMID</th>
        <th>Age</th>
        <th>Sex</th>
        <th>Disease</th>
        <th>BP [mmHg]</th>
        <th>HR [1/min]</th>
        <th>Breaths [1/min]</th>
        <th>Temp [°C]</th>
        <th>ECG QRS [ms]</th>
        <th>ECG QT [ms]</th>
        <th>ECG QTc [ms]</th>
        <th>Drug conc</th>
        <th>Ion conc</th>
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
            echo '<td align="center">' . (isset($row['PMID']) ? $row['PMID'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['Age']) ? $row['Age'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['Sex']) ? $row['Sex'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['Disease']) ? $row['Disease'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['BP']) ? $row['BP'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['HR']) ? $row['HR'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['Breaths']) ? $row['Breaths'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['Temp']) ? $row['Temp'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['QRS']) ? $row['QRS'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['QT']) ? $row['QT'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['QTc']) ? $row['QTc'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['Drugconc']) ? $row['Drugconc'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['Ionconc']) ? $row['Ionconc'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['date_posted']) ? $row['date_posted'] : '') . " - " . (isset($row['time_posted']) ? $row['time_posted'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['date_edited']) ? $row['date_edited'] : '') . " - " . (isset($row['time_edited']) ? $row['time_edited'] : '') . "</td>";
            echo '<td align="center"><a href="patient.php?action=edit&id=' . (isset($row['Case ID']) ? $row['Case ID'] : '') . '&page=' . $currentPage . '" class="edit-button">Edit</a></td>';
            echo '<td align="center"><a href="patient.php?action=delete&id=' . (isset($row['Case ID']) ? $row['Case ID'] : '') . '&page=' . $currentPage . '" class="delete-button">Delete</a></td>';
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
    $query = "SELECT COUNT(*) AS total FROM patient_t";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $totalRecords = $row['total'];
    $totalPages = ceil($totalRecords / $recordsPerPage);
    $url = "patient.php?page=";

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
