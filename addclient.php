
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

<?php $client=true;
if (isset($_POST["retour"])) {
  header("Location:client.php");
}
include_once("header.php");
include_once("main.php");

$query2="select * from departement order by departement_nom asc ";
$pdostmt2=$pdo->prepare($query2);
$pdostmt2->execute();

if (!empty($_POST["nom"]) && !empty($_POST["inputville"]) && !empty($_POST["fone"])) {
    $query="insert into clients (nom,ville_id,telephone) values (:nom,:ville,:fone)";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute(["nom"=>$_POST["nom"],"ville"=>$_POST["inputville"],"fone"=>$_POST["fone"]]);
    $pdostmt->closeCursor();}
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
})

</script>


<main class="flex-shrink-0">
  <div class="container">
    <hr>
<h1 class="mt-5" >Ajouter un client</h1>
<form class="row g-3" method="POST" >
  <div class="col-md-6">
    <label for="nom" class="form-label"  >Nom</label>
    <input type="texte" class="form-control" id="inputEmail4"name="nom" >
  </div>

  <div class="col-md-6">
    <label for="fone" class="form-label"name="">Telephone</label>
    <input type="number" class="form-control" id="inputAddress" name="fone">
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


  <div class="col-12" style="    display: flex; justify-content: space-around;" >

 
  </div>
</form>
</div>
</main>
<?php
include_once("footer.php");
?>