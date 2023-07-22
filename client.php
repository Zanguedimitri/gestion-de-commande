<!-- Begin page content -->
<?php
$client=true;
if (isset($_POST["retour"])) {
    header("Location:client.php");
  }
include_once("header.php");
include_once("main.php"); 
$count=0;
$list=[];
$query="SELECT idclient FROM clients WHERE idclient IN (SELECT idclient FROM commande WHERE commande.idclient=clients.idclient)";
$pdostmt=$pdo->prepare($query);
$pdostmt->execute();
foreach($pdostmt->fetchAll(PDO::FETCH_NUM) as $tabvalues){
    foreach($tabvalues as $tablements){
        $list[]=$tablements;
    }
}
  
  $query2="select * from departement order by departement_nom asc ";
  $pdostmt2=$pdo->prepare($query2);
  $pdostmt2->execute();

?>

<script>
$(document).ready(function(){
    $("#inputdepart").on("change",function(){
      var depart_code=$("#inputdepart").val();
      if (depart_code) {
        $.ajax({ 
          type:'POST',
          url:'ajaxdata.php',
          data:'depart_code='+depart_code,
          success: function(response){
            $("#inputville").html(response);
          }
        });
      } else {
        $("#inputville").html("<option value=''>selectionner d'abord un departement</option>")
      }
    });
    $("#clientform").submit(function(e){
        e.preventDefault();
        $.ajax({
			type:"post",
			url:"ajaxdata.php",
			data:$("#clientform").serialize(),
			dataType:"json",
            success:function (reponse){
                if (reponse.value==false) {
                    console.log(reponse.msg);
                } else {
                    console.log(reponse.msg);
                    window.location="client.php";
                }
            }
        
        })
    })
})

</script>

    <main class="flex-shrink-0">
  <div class="container">
  <br>
        <h1 class="mt-5">Clients</h1>

        <button type="button" class="btn btn-primary" style="float:right;" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
            <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
            </svg>
        </button>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter un client</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="row g-3" method="post" id="clientform" >
        <div class="modal-body">
            <div class="col-md-6">
                <label for="nom" class="form-label"  >Nom</label>
                <input type="texte" class="form-control" id="inputEmail4"name="nom" >
            </div>

            <div class="col-md-6">
                <label for="fone" class="form-label"name="">Telephone</label>
                <input type="text" class="form-control" id="inputAddress" name="fone">
            </div>

            <div class="col-md-6">
                <label for="inputdepart" class="form-label"  >Departement</label>
                <select  type="texte" class="form-control" id="inputdepart"name="inputdepart" > 
                <option value="">selection un departement</option>
                <?php  
                while ($row=$pdostmt2->fetch(PDO::FETCH_ASSOC)):
                ?>
                <option value="<?php echo $row["departement_code"]?>"><?php echo $row["departement_nom"]?></option>
                <?php endwhile   ?>
                </select>
            </div>

            <div class="col-md-6">
                <label for="inputville" class="form-label"  >Ville</label>
                <select  type="texte" class="form-control" id="inputville"name="inputville" >
                <option value=''>selectionner d'abord un departement</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="ajout" >Ajouter</button>
        </div>
      </form>
    </div>
  </div>
</div>
        
        <?php 
        $i=0;
        $query="select * from clients as c , villes_france as v , departement as d where c.ville_id=v.ville_id and v.ville_departement=d.departement_code ";
        $pdostmt=$pdo->prepare($query);
        $pdostmt->execute();
        //var_dump($pdostmt->fetchAll(PDO::FETCH_ASSOC));
        ?>
        
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOM</th>
                    <th>DEPARTEMENT</th>
                    <th>VILLE</th>
                    <th>TELEPHONE</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody> 
            <?php while ($ligne=$pdostmt->fetch(PDO::FETCH_ASSOC)):

                $count++;
                ?>
                <tr>
                    <td><?php echo $ligne["idclient"] ?> </td>
                    <td><?php echo $ligne["nom"] ?> </td>
                    <td><?php echo $ligne["departement_nom"] ?> </td>
                    <td><?php echo $ligne["ville_nom"] ?> </td>
                    <td><?php echo $ligne["telephone"] ?> </td>
                    <td>
                        <a href="modifclient.php?id=<?php echo $ligne["idclient"]; ?>" class="btn btn-success"  >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/></svg>
                         </a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" <?php if(in_array($ligne["idclient"],$list)) {echo"disabled";} ?> data-bs-target="#deleteModal<?php echo $count ?>" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                            </svg>
                        </button>
                                <!-- Modal -->
                                <div class="modal fade" id="deleteModal<?php echo $count ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">SUPPRESSION</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            voulez-vous vraiment supprimer ce client
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <a href="delete.php?id=<?php echo $ligne["idclient"] ;  ?>" type="button" class="btn btn-outline-danger">Supprimer</a>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>
<?php
include_once("footer.php");
?>
</body>
</html>