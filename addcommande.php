<?php $commande=true;
if (isset($_POST["retour"])) {
  header("Location:commande.php");
}
include_once("main.php"); 
include_once("header.php");

$query="select idclient from clients";
$objstmt=$pdo->prepare($query);
$objstmt->execute();

$query2="select idarticle from article";
$objstmt2=$pdo->prepare($query2);
$objstmt2->execute();

if (!empty($_POST["nom"])&&!empty($_POST["ville"])) {
    $query="insert into commande (idclient,date) values (:idcl,:periode)";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute(["idcl"=>$_POST["nom"],"periode"=>$_POST["ville"]]);
    $idcm=$pdo->lastInsertId();
    
    $query2="insert into ligne_commande (idcommande,idarticle,quantite) values (:idcmd,:idat,:qte)";
    $pdostmt2=$pdo->prepare($query2);
    $pdostmt2->execute(["idcmd"=>$idcm,"idat"=>$_POST["inputidarticle"],"qte"=>$_POST["inputqte"]]);
    $pdostmt2->closeCursor(); 
  
  }
?>

<main class="flex-shrink-0">
  <div class="container">
    <hr>
<h1 class="mt-5" >Ajouter une commande</h1>
<form class="row g-3" method="POST" >
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">ID client</label>
    <select name="nom" class="form-control" id="inputEmail4"> <?php foreach ($objstmt->fetchAll(PDO::FETCH_NUM) as $tab){
       foreach ($tab as $elmt) { 
         echo "<option value=".$elmt.">".$elmt."</option>";
          }
       } ?> </select>
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Date</label>
    <input type="date" class="form-control" id="inputPassword4"name="ville" >
  </div>
  <div class="col-md-6">
      <label for="inputidarticle" class="form-label"  >Article</label>
      <select name="inputidarticle" class="form-control" id="inputidarticle"> <?php foreach ($objstmt2->fetchAll(PDO::FETCH_NUM) as $tab){
        foreach ($tab as $elmt) { 
          echo "<option value=".$elmt.">".$elmt."</option>";
            }
        } ?> </select>
  </div>
  <div class="col-md-6">
    <label for="inputqte" class="form-label"  >Quantité</label>
    <input type="text" class="form-control" id="inputqte"name="inputqte" >
  </div>
  <div class="col-12" style="display: flex; justify-content: space-around;" >

  <button type="submit" class="btn btn-danger" name="retour" >Retour</button>

  <button type="submit" class="btn btn-primary" name="ajout" >Ajouter</button>
  </div>
</form>
</div>
</main>
<?php
include_once("footer.php");
?>