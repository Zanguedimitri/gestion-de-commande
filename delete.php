 <?php
 include_once("main.php");
 if (!empty($_GET["id"])) {
    $query="delete from clients where idclient=:id";
    $objstmt=$pdo->prepare($query);
    $objstmt->execute(["id"=>$_GET["id"]]);
    $objstmt->closeCursor();
    header("Location:client.php");
    
 }
 include_once("main.php");
 if (!empty($_GET["idarticle"])) {
    $query="delete from article where idarticle=:idarticle";
    $objstmt=$pdo->prepare($query);
    $objstmt->execute(["idarticle"=>$_GET["idarticle"]]);
    $objstmt->closeCursor();
    header("Location:article.php");
    
 }
 include_once("main.php");
 if (!empty($_GET["idcmd"])) {
    $query="delete from commande where idcommande=:icmd";
    $objstmt=$pdo->prepare($query);
    $objstmt->execute(["icmd"=>$_GET["idcmd"]]);
    $objstmt->closeCursor();

    $query2="delete from ligne_commande where idcommande=:icmd";
    $objstmt2=$pdo->prepare($query2);
    $objstmt2->execute(["icmd"=>$_GET["idcmd"]]);
    $objstmt2->closeCursor();
    header("Location:commande.php");
    
 }
 ?>