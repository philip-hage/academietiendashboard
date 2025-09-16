<?php include('../includes/header.php');

require_once __DIR__ . '/../../config/database.php';

$sql = "SELECT unitId, unitName, unitIsActive FROM units";
$stmt = $conn->prepare($sql);
$stmt->execute();
$units = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
         <path d="M0,160L60,154.7C120,149,240,139,360,138.7C480,139,600,149,720,144C840,139,960,117,1080,122.7C1200,128,1320,150,1380,155L1440,160L1440,220L0,220Z"></path>
      </svg>
   </div>

  <div class="content">
   <form class="searchbar">
      <button type="submit"><i class="fas fa-search"></i></button>
      <input type="text" placeholder="Zoek leerlingen" />
    </form>
      <?php foreach($units as $unit): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($unit['unitName']); ?></h5>
                        <p class="card-text">Status: <?php echo $unit['unitIsActive'] ? 'Actief' : 'Inactief'; ?></p>
                        <a href="units.php?id=<?php echo $unit['unitId']; ?>" class="btn btn-primary">Bekijk Unit</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
  </div>
    
   </div>

</section>



<?php include('../includes/footer.php');?>