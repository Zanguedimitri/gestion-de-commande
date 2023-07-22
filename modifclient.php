<?php 
$client=true;
include_once("main.php");
if (!empty($_POST)) {
    $query="update clients set nom=:nom, ville_id=:ville, telephone=:telephone where idclient=:id";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute(["nom"=>$_POST["nom"],"ville"=>$_POST["ville"],"telephone"=>$_POST["fone"],"id"=>$_POST["myid"]]);
        header("Location:client.php");
 }
include_once("header.php");
 

if (!empty($_GET["id"])) {
    $query="select * from clients where idclient=:id";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute(["id"=>$_GET["id"]]);
    while ($row=$pdostmt->fetch(PDO::FETCH_ASSOC)):
 
    
?>
<main class="flex-shrink-0">
  <div class="container">
    <hr>
    <h1 class="mt-5" >Modifier un client</h1>
    <form class="row g-3" method="POST" >
        <input type="hidden" name="myid" value="<?php echo $row["idclient"] ?>" >
    <div class="col-md-6">
        <label for="nom" class="form-label"  >Nom</label>
        <input type="texte" class="form-control" id="inputEmail4"name="nom" value="<?php echo $row["nom"] ?>" >
    </div>
    <div class="col-md-6">
        <label for="ville" class="form-label"  >Ville</label>
        <input type="texte" class="form-control" id="inputPassword4"name="ville" value="<?php echo $row["ville_id"] ?>" >
    </div>
    <div class="col-md-6">
        <label for="fone" class="form-label"name="">Telephone</label>
        <input type="number" class="form-control" id="inputAddress" name="fone" value="<?php echo $row["telephone"] ?>" >
    </div>
    <div class="col-12" style="    display: flex; justify-content: center;" >

    <button type="submit" class="btn btn-success" name="ajout" >Modifier</button>
    </div>
    </form>
    </div>
    </main>
<?php 
endwhile ;
$pdostmt->closeCursor();
}

?>
<?php
include_once("footer.php");
?>
</div>
</main>