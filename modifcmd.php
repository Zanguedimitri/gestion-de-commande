<?php 
$commande=true;
include_once("main.php");

$query="select idclient from clients";
$objstmt=$pdo->prepare($query);
$objstmt->execute();

$query2="select idarticle from article";
$objstmt2=$pdo->prepare($query2);
$objstmt2->execute();

if (!empty($_POST)) {
    $query="update commande set idclient=:idcl, date=:date where idcommande=:id";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute(["idcl"=>$_POST["inputidcl"],"date"=>$_POST["inputdate"],"id"=>$_POST["myid"]]);

    $query2="update ligne_commande set quantite=:qte, idarticle=:art where idcommande=:id";
    $pdostmt2=$pdo->prepare($query2);
    $pdostmt2->execute(["id"=>$_POST["myid"], "qte"=>$_POST["inputqte"],"art"=>$_POST["inputart"]]);

    
        header("Location:commande.php");
 }
include_once("header.php");

if (!empty($_GET["id"])) {
    $query="select * from commande where idcommande=:id";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute(["id"=>$_GET["id"]]);

    $query2="select * from ligne_commande where idcommande=:id";
    $pdostmt2=$pdo->prepare($query2);
    $pdostmt2->execute(["id"=>$_GET["id"]]);

    while ($row=$pdostmt->fetch(PDO::FETCH_ASSOC) and $row2=$pdostmt2->fetch(PDO::FETCH_ASSOC) ):
 
    
?>
<main class="flex-shrink-0">
  <div class="container">
    <hr>
    <h1 class="mt-5" >Modifier une commande</h1>
    <form class="row g-3" method="POST" >

        <input type="hidden" name="myid" value="<?php echo $row["idcommande"] ?>" >

    <div class="col-md-6">
        <label for="inputidcl" class="form-label">ID clients</label>
        <select name="inputidcl" class="form-control" id="inputidcl"> 
        <?php 
        foreach ($objstmt->fetchAll(PDO::FETCH_NUM) as $tab){
        foreach ($tab as $elmt) { 
            if ($row["idclient"]==$elmt) {
                $selected="selected";
            }else {
                $selected="";
            }
            echo "<option value=".$elmt." ".$selected.">".$elmt."</option>";
            }
        } ?> </select>
  </div>
  
    <div class="col-md-6">
        <label for="inputdate" class="form-label">Date</label>
        <input type="date" class="form-control" id="inputdate" name="inputdate" value="<?php echo $row["date"] ?>" >
    </div>

    <div class="col-md-6">
        <label for="inputqte" class="form-label">Quantité</label>
        <input type="text" class="form-control" id="inputqte" name="inputqte" value="<?php echo $row2["quantite"] ?>" >
    </div>
    <div class="col-md-6">
        <label for="inputart" class="form-label">Article</label>
        <select name="inputart" class="form-control" id="inputart"> 
        <?php 
        foreach ($objstmt2->fetchAll(PDO::FETCH_NUM) as $tab){
        foreach ($tab as $elmt) { 
            if ($row["idarticle"]==$elmt) {
                $selected="selected";
            }else {
                $selected="";
            }
            echo "<option value=".$elmt." ".$selected.">".$elmt."</option>";
            }
        } ?> </select>
  </div>

    <div class="col-12" style=" display: flex; justify-content: center;" >

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