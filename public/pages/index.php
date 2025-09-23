<?php include('../includes/header.php');

require_once __DIR__ . '/../../config/database.php';

$sql = "SELECT unitId, unitName, unitIsActive FROM units";
$stmt = $conn->prepare($sql);
$stmt->execute();
$units = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlStudents = "SELECT studentId, studentName FROM students";
$stmtStudents = $conn->prepare($sqlStudents);
$stmtStudents->execute();
$students = $stmtStudents->fetchAll(PDO::FETCH_ASSOC);

?>


<section id="banner">
    <div>
        <div>
            <h1>Welkom bij ons platform</h1>
        </div>
        <div class="banner-text">
            <p>Ontdek de kracht van onze innovatieve oplossingen en <br> begin vandaag nog met het transformeren van je
                werkflow.</p>
        </div>
        <div>
            <button class="black-btn">Aan de slag</button>
        </div>
    </div>

    <div class="ballLeft"></div>
    <div class="ballRight"></div>

</section>

<section id="units">

    <div class="wave">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 120 1440 100">
            <path
                d="M0,160L60,154.7C120,149,240,139,360,138.7C480,139,600,149,720,144C840,139,960,117,1080,122.7C1200,128,1320,150,1380,155L1440,160L1440,220L0,220Z">
            </path>
        </svg>
    </div>

    <div class="content">

        <form class="searchbar">
            <button type="submit"><i class="fas fa-search"></i></button>
            <input type="text" placeholder="Zoek leerlingen" id="student-search" />
            <div id="search-dropdown"></div>
        </form>

        <div class="card-row">
            <?php foreach($units as $unit): ?>
                <div class="card">
                    <div class="card-body">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px"
                                fill="#0BF61A">
                                <path
                                    d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240Zm40 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="card-title"><?php echo htmlspecialchars($unit['unitName']); ?></h3>
                            <p class="card-text">Body text for whatever you’d like to say. Add main takeaway points, quotes,
                                anecdotes, or even a very very short story. </p>
                            <div>
                                <a href="units.php?id=<?php echo $unit['unitId']; ?>">
                                    <button class="white-btn">Bekijk</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    </div>

</section>


<script>
// Zet de PHP-array van studenten om naar JS
window.students = <?php echo json_encode($students); ?>;
</script>
<?php include('../includes/footer.php');?>