<?php 
$article=true;
include_once("main.php");

if (!empty($_POST)) {
    $query="update article set description=:nom, prix_unitaire=:ville where idarticle=:id";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute(["nom"=>$_POST["nom"],"ville"=>$_POST["ville"],"id"=>$_POST["myid"]]);
        header("Location:article.php");
 }
include_once("header.php");
 

if (!empty($_GET["id"])) {
    $query="select * from article where idarticle=:id";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute(["id"=>$_GET["id"]]);
    while ($row=$pdostmt->fetch(PDO::FETCH_ASSOC)):
 
    
?>
<main class="flex-shrink-0">
  <div class="container">
    <hr>
    <h1 class="mt-5" >Modifier un article</h1>
   <div>
    <form class="row g-3" method="POST" >
            <input type="hidden" name="myid" value="<?php echo $row["idarticle"] ?>" >
        <div class="col-md-6">
            <label for="nom" class="form-label">Description</label>
            <input type="texte" class="form-control" id="inputEmail4"name="nom" style="width: 450px;" value="<?php echo $row["description"] ?>" >
        </div>
        <div class="col-md-6">
            <label for="ville" class="form-label"  >Prix Unitaire</label>
            <input type="number" class="form-control" id="inputPassword4"name="ville" style="width: 450px;" value="<?php echo $row["prix_unitaire"] ?>" >
        </div>

        <div class="col-12" >
        <button type="submit" class="btn btn-success" name="ajout" >Modifier</button>
        </div>
        </form>
   </div>
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