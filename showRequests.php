<?php
// error_reporting(E_ALL); // Enable error reporting
// ini_set('display_errors', 1); // Display errors on the page
include 'connection.php';

// Check if download is requested
if (isset($_GET['download']) && $_GET['download'] == 1) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="contacts_data.csv"');

    $output = fopen('php://output', 'w');

    // Output the column headings
    fputcsv($output, ['Name', 'Email', 'Phone', 'Message', 'File Path', 'Submitted At']);

    // Fetch all data
    $sql = "SELECT name, email, phone, message, file_path, submitted_at FROM contacts";
    $result = $con->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $filePath = $row['file_path'];
            $baseURL = "https://dgear.compbiosysnbu.in/";
            $fileURL = !empty($filePath) ? $baseURL . $filePath : "";
            $fileURL;
            fputcsv($output, [
                $row['name'],
                $row['email'],
                $row['phone'],
                $row['message'],
                $fileURL,
                $row['submitted_at']
            ]);
        }
    }
    fclose($output);
    $con->close();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>View Reach Out Messages</title>
    <style>

    </style>
</head>
<?php include 'header.php';?>
<body>
    <div class="body-div">  
    <h3 style="text-align:center;">View Reach Out Requests</h3>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Message</th>
            <th>File</th>
            <th>Submitted At</th>
        </tr>
        <?php
        $sql = "SELECT name, email, phone, message, file_path, submitted_at FROM contacts";
        $result = $con->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>". htmlspecialchars($row['name']) ."</td>";
                echo "<td>". htmlspecialchars($row['email']) ."</td>";
                echo "<td>". htmlspecialchars($row['phone']) ."</td>";
                echo "<td>". nl2br(htmlspecialchars($row['message'])) ."</td>";
                
                if (!empty($row['file_path'])) {
                    echo "<td><a href='". htmlspecialchars($row['file_path']) ."' class='download-btn' download>Attachment</a></td>";
                } else {
                    echo "<td>No file</td>";
                }

                echo "<td>". htmlspecialchars($row['submitted_at']) ."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6' style='text-align:center;'>No records found.</td></tr>";
        }

        $con->close();
        ?>
    </table>
    <h2>Export table</h2>
    <a href="?download=1" class="download-link">Download full data</a>
    </div>  
</body>
<?php include 'footer.php';?>
</html>
