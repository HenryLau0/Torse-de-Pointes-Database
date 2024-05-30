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

    if ($file == 'properties.php') {
        require_once __DIR__ . '/properties.php';
    } elseif ($file == 'outcomes.php') {
        require_once __DIR__ . '/outcomes.php';
    } elseif ($file == 'patient.php') {
        require_once __DIR__ . '/patient.php';
    } elseif ($file == 'drugs.php') {
        require_once __DIR__ . '/drugs.php';
    }
}

$user = $_SESSION['user'];

$conn = mysqli_connect("localhost", "root", "", "torsade_de_pointes");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $SMILE = mysqli_real_escape_string($conn, $_POST['SMILE']);
    $MW = mysqli_real_escape_string($conn, $_POST['Molecular Weight (g/mol)']);
    $TPSA = mysqli_real_escape_string($conn, $_POST['TPSA']);
    $LogP = mysqli_real_escape_string($conn, $_POST['LogP']);
    $HBA = mysqli_real_escape_string($conn, $_POST['HBA']);
    $HBD = mysqli_real_escape_string($conn, $_POST['HBD']);
    $Rotatable = mysqli_real_escape_string($conn, $_POST['No of Rotatable bonds']);
    $Heavy = mysqli_real_escape_string($conn, $_POST['No of Heavy atoms']);
    
    $date = date("Y-m-d");

    if (isset($_GET['action']) && $_GET['action'] == "edit") {
        $id = $_GET['id'];
        $id = mysqli_real_escape_string($conn, $id);

        $query = "UPDATE drugs_properties_t SET SMILE='$SMILE', 'Molecular Weight (g/mol)'='$MW', TPSA='$TPSA', LogP='$LogP', HBA='$HBA', HBD='$HBD', 'No of Rotatable bonds'='$Rotatable', 'No of Heavy atoms'='$Heavy' WHERE `Suspected Drugs`='$id'";

        if (mysqli_query($conn, $query)) {
            header("location: properties.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        $query = "INSERT INTO drugs_properties_t (SMILE, 'Molecular Weight (g/mol)', TPSA, LogP, HBA, HBD, 'No of Rotatable bonds', 'No of Heavy atoms', date_posted) 
              VALUES ('$SMILE', '$MW', '$TPSA', '$RoA', '$LogP', '$HBA', '$HBD', '$Rotatable', '$Heavy','$date')";

        if (mysqli_query($conn, $query)) {
            header("location: properties.php");
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
        width: 80%;
        border-collapse: collapse;
    }

    th,
    td {
        text-align: center;
        padding: 8px;
        font-size: 15px;
        word-wrap: break-word;
    }

    td.column {
        max-width: 200px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    th {
        background-color: #001E97;
        color: white;
    }

    /* Add the following styles to decrease column size */
    td {
        max-width: 400px; /* Adjust the width as needed */
        overflow: hidden;
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

<h2 align="center" style="font-weight:bold; font-family: 'Trirong',serif">Drugs Properties</Details></Details></h2>

<?php
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['action'])) {
    if ($_GET['action'] == "edit") {
        $id = $_GET['id'];
        $id = mysqli_real_escape_string($conn, $id);

        $query = "SELECT * FROM drugs_properties_t WHERE `Suspected Drugs`='$id'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $editSMILE = isset($row['SMILE']) ? $row['SMILE'] : '';
            $editMW = isset($row['Molecular Weight (g/mol)']) ? $row['Molecular Weight (g/mol)'] : '';
            $editLogP = isset($row['LogP']) ? $row['LogP'] : '';
            $editTPSA = isset($row['TPSA']) ? $row['TPSA'] : '';
            $editHBA = isset($row['HBA']) ? $row['HBA'] : '';
            $editHBD = isset($row['HBD']) ? $row['HBD'] : '';
            $editRotatable = isset($row['No of Rotatable bonds']) ? $row['No of Rotatable bonds'] : '';
            $editHeavy = isset($row['No of Heavy atoms']) ? $row['No of Heavy atoms'] : '';
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
                <form action="properties.php?action=edit&id=<?= $id ?>" method="POST">
                    <label for="SMILE">SMILE:</label>    
                    <input type="text" id="SMILE" name="SMILE" value="<?= $editSMILE ?>" required><br><br>
                    <label for="Molecular Weight (g/mol)">Molecular Weight (g/mol):</label>
                    <input type="text" id="Molecular Weight (g/mol)" name="Molecular Weight (g/mol)" value="<?= $editMW ?>" required><br><br>
                    <label for="TPSA">TPSA:</label>
                    <input type="text" id="TPSA" name="TPSA" value="<?= $editTPSA ?>" required><br><br>
                    <label for="LogP">LogP:</label>
                    <input type="text" id="LogP" name="LogP" value="<?= $editLogP ?>" required><br><br>
                    <label for="HBA">HBA:</label>
                    <input type="text" id="HBA" name="HBA" value="<?= $editHBA ?>" required><br><br>
                    <label for="HBD">HBD:</label>
                    <input type="text" id="HBD" name="HBD" value="<?= $editHBD ?>" required><br><br>
                    <label for="No of Rotatable bonds">No of Rotatable bonds:</label>
                    <input type="text" id="No of Rotatable bonds" name="No of Rotatable bonds" value="<?= $editRotatable ?>" required><br><br>
                    <label for="No of Heavy atoms">No of Heavy atoms:</label>
                    <input type="text" id="No of Heavy atoms" name="No of Heavy atoms" value="<?= $editHeavy ?>" required><br><br>
                    
                    <input type="submit" value="Update"><br><br>
                    <button type="button" onclick="window.location.href='properties.php'">Cancel</button><br><br>
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
                window.location.href = "properties.php?action=confirm_delete&id=<?= $id ?>";
            } else {
                window.location.href = "properties.php";
            }
        </script>

        <?php
            } else if ($_GET['action'] == "confirm_delete" && isset($_GET['id'])) {
                $id = $_GET['id'];
                $id = mysqli_real_escape_string($conn, $id);

                $query = "DELETE FROM drugs_properties_t WHERE `Case ID`='$id'";

                if (mysqli_query($conn, $query)) {
                    header("location: properties.php");
                    exit();
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }
        }

        $recordsPerPage = 30;
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($currentPage - 1) * $recordsPerPage;

        $query = "SELECT * FROM drugs_properties_t LIMIT $offset, $recordsPerPage"; // SQL Query
        $result = mysqli_query($conn, $query);
        $resultCheck = mysqli_num_rows($result);
        ?>


<form action="properties.php" method="POST" style="max-width:400px; padding:20px; margin: 0 auto" class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin">
    <div id="pmidSection" class="w3-row w3-section">
        Add SMILE: <input type="text" name="PMID" id="PMID" onchange="showSourceTextbox()" required/><br/>
    </div><br>

    <div id="sourceSection" style="display: none;" class="w3-row w3-section">
        Molecular Weight (g/mol): <input type="text" name="Molecular Weight (g/mol)" id="Molecular Weight (g/mol)" required/><br><br>
        TPSA: <input type="text" name="TPSA" id="TPSA" required/><br><br>
        LogP: <input type="text" name="LogP" id="LogP" required/><br><br>
        HBA: <input type="text" name="HBA" id="HBA" required/><br><br>
        HBD: <input type="text" name="HBD" id="HBD" required/><br><br>
        No of Rotatable bonds: <input type="text" name="No of Rotatable bonds" id="No of Rotatable bonds" required/><br><br>
        No of Heavy atoms: <input type="text" name="No of Heavy atoms" id="No of Heavy atoms" required/><br><br>
        <input type="submit" value="Add" class="w3-button w3-block w3-section w3-blue w3-ripple w3-padding"><br><br>
    </div>
</form>

<table class="table" border="1px" width="100%">
    <tr style="text-align:center;font-size:20px">
        <th>Suspected Drugs</th>
        <th>SMILE</th>
        <th>Molecular Weight (g/mol)</th>
        <th>TPSA</th>
        <th>LogP</th>
        <th>HBA</th>
        <th>HBD</th>
        <th>No of Rotatable bonds</th>
        <th>No of Heavy atoms</th>
        <th>Post Time</th>
        <th>Edited Time</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo '<td align="center">' . (isset($row['Suspected Drugs']) ? $row['Suspected Drugs'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['SMILE']) ? $row['SMILE'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['Molecular Weight (g/mol)']) ? $row['Molecular Weight (g/mol)'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['TPSA']) ? $row['TPSA'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['LogP']) ? $row['LogP'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['HBA']) ? $row['HBA'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['HBD']) ? $row['HBD'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['No of Rotatable bonds']) ? $row['No of Rotatable bonds'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['No of Heavy atoms']) ? $row['No of Heavy atoms'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['date_posted']) ? $row['date_posted'] : '') . " - " . (isset($row['time_posted']) ? $row['time_posted'] : '') . "</td>";
            echo '<td align="center">' . (isset($row['date_edited']) ? $row['date_edited'] : '') . " - " . (isset($row['time_edited']) ? $row['time_edited'] : '') . "</td>";
            echo '<td align="center"><a href="properties.php?action=edit&id=' . (isset($row['Suspected Drugs']) ? $row['Suspected Drugs'] : '') . '&page=' . $currentPage . '" class="edit-button">Edit</a></td>';
            echo '<td align="center"><a href="properties.php?action=delete&id=' . (isset($row['Suspected Drugs']) ? $row['Suspected Drugs'] : '') . '&page=' . $currentPage . '" class="delete-button">Delete</a></td>';
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
    $query = "SELECT COUNT(*) AS total FROM drugs_properties_t";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $totalRecords = $row['total'];
    $totalPages = ceil($totalRecords / $recordsPerPage);
    $url = "properties.php?page=";

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
