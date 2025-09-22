<?php
include('../includes/header.php');
require_once __DIR__ . '/../../config/database.php';

$studentId = isset($_GET['studentId']) ? intval($_GET['studentId']) : 0;

$sql = "SELECT studentId, studentName, studentClass, studentNiveau, studentIsActive FROM students WHERE studentId = :studentId";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
$stmt->execute();
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if ($student) {
    echo "<h1>" . htmlspecialchars($student['studentName']) . "</h1>";
    echo "<p>Klas: " . htmlspecialchars($student['studentClass']) . "</p>";
    echo "<p>Niveau: " . htmlspecialchars($student['studentNiveau']) . "</p>";
    echo "<p>Status: " . ($student['studentIsActive'] ? 'Actief' : 'Inactief') . "</p>";
} else {
    echo "<p>Student niet gevonden.</p>";
}
include('../includes/footer.php');
?>