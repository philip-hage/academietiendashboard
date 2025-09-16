<?php
require_once __DIR__ . '/../../config/database.php';

$sql = "SELECT id, unitNumber, studentId, classId FROM units";
$stmt = $conn->prepare($sql);
$stmt->execute();
$units = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Units overzicht</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <div class="row">
        <?php foreach($units as $unit): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($unit['unitNumber']); ?></h5>
                        <p class="card-text">
                            Student ID: <?php echo htmlspecialchars($unit['studentId']); ?><br>
                            Class ID: <?php echo htmlspecialchars($unit['classId']); ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>