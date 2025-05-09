<!-- view_log.php -->
<?php
include 'includes/header.php';
?>

<form action="view_log.php" method="post">
    <label for="log_date">Chọn ngày xem nhật ký:</label>
    <input type="date" id="log_date" name="log_date">
    <input type="submit" value="Xem nhật ký">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedDate = $_POST['log_date'];
    $logFile = "logs/log_{$selectedDate}.txt";

    if (file_exists($logFile)) {
        $fileContent = file_get_contents($logFile);
        echo nl2br($fileContent);
    } else {
        echo "Không có nhật ký cho ngày này.";
    }
}

include 'includes/footer.php';
?>
