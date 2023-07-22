
<?php 
$index=true; 
include_once("header.php");
include_once("main.php"); 

$query="SELECT art.description, art.prix_unitaire, lc.quantite, cmd.date, c.ville_id, c.telephone, c.nom, v.ville_nom FROM article art, commande cmd , ligne_commande lc , clients c, villes_france v WHERE c.idclient=cmd.idclient AND  cmd.idcommande=lc.idcommande AND art.idarticle=lc.idarticle AND  c.ville_id=v.ville_id ";
$pdostmt=$pdo->prepare($query);
$pdostmt->execute();
?>
<main class="flex-shrink-0">
  <div class="container">
    <br>
  <h1 class="mt-5">Acceuils</h1>
    <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>NOM</th>
                    <th>TELEPHONE</th>
                    <th>VILLE</th>
                    <th>DATE</th>
                    <th>DESCRIPTION</th>
                    <th>PRIX_UNITAIRE</th>
                    <th>QUANTITE</th>
                </tr>
            </thead>
            <tbody> 
            <?php while ($ligne=$pdostmt->fetch(PDO::FETCH_ASSOC)):
                ?>
                <tr>
                    <td><?php echo $ligne["nom"] ?> </td>
                    <td><?php echo $ligne["telephone"] ?> </td>
                    <td><?php echo $ligne["ville_nom"] ?> </td>
                    <td><?php echo $ligne["date"] ?> </td>
                    <td><?php echo $ligne["description"] ?> </td>
                    <td><?php echo $ligne["prix_unitaire"] ?> </td>
                    <td><?php echo $ligne["quantite"] ?> </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
  </div>
</main>
    
    <?php
    $pdostmt->closeCursor();
    include_once("footer.php") ?>