
    
    <!-- Begin page content -->
<?php
$article=true;
include_once("header.php");
include_once("main.php"); 
$count=0;
$list=[];
$query="SELECT idarticle FROM article WHERE idarticle IN (SELECT idarticle FROM ligne_commande WHERE ligne_commande.idarticle=article.idarticle)";
$pdostmt=$pdo->prepare($query);
$pdostmt->execute();
foreach($pdostmt->fetchAll(PDO::FETCH_NUM) as $tabvalues){
    foreach($tabvalues as $tablements){
        $list[]=$tablements;
    }
}
?>

<script>
    $(document).ready(function(){
        $("#formarticle").submit(function(e){
            e.preventDefault();
            $.ajax({
                type:"post",
                url:"ajaxdata.php",
                dataType:"json",
                data:$("#formarticle").serialize(),
                success:function (response){
                    if (response.value==false) {
                        console.log(response.msg);
                    } else {
                        console.log(response.msg);
                        window.location="article.php";
                    }
                    
                }

            })
            
        })  
    })
</script>

    <main class="flex-shrink-0">
    <div class="container">
        <br>
        <h1 class="mt-5">Articles</h1>
        <button type="button" class="btn btn-primary" style="float:right;"  data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo" >
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
        </button>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter un article</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                    <form class="row g-3" method="POST" id="formarticle" >
                                <div class="col-md-6">
                                <label for="nom">Articles</label>
                                    <textarea name="nom" class="form-control" placeholder="Description de votre article" id="nom"></textarea>
                                    
                                </div>
                            <div class="col-md-6">
                                    <label for="ville" class="form-label"  >Prix unitaire</label>
                                    <input type="texte" class="form-control" id="inputPassword4"name="ville" >
                            </div>
                            <div class="col-12" style="display: flex; justify-content: space-around;" >

                        
                            </div>
                    
                        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="ajout" >Ajouter</button>
                    </form>
                    </div>
                    </div>
                </div>
            </div>

        <?php 
        $i=0;
        $query="select * from article";
        $pdostmt=$pdo->prepare($query);
        $pdostmt->execute();
        //var_dump($pdostmt->fetchAll(PDO::FETCH_ASSOC));
        ?>
        
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DESCRIPTION</th>
                    <th>PRIX_UNITAIRE</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody> 
            <?php while ($ligne=$pdostmt->fetch(PDO::FETCH_ASSOC)):

                $count++;
                ?>
                <tr>
                    <td><?php echo $ligne["idarticle"] ?> </td>
                    <td><?php echo $ligne["description"] ?> </td>
                    <td><?php echo $ligne["prix_unitaire"] ?> </td>
                    <td>
                        <a href="modifarticle.php?id=<?php echo $ligne["idarticle"]; ?>" class="btn btn-success"  >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/></svg>
                         </a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" <?php if(in_array($ligne["idarticle"],$list)) {echo"disabled";} ?> data-bs-target="#deleteModal<?php echo $count ?>" >
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
                                            voulez-vous vraiment supprimer cet article
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <a href="delete.php?idarticle=<?php echo $ligne["idarticle"] ;  ?>" type="button" class="btn btn-outline-danger">Supprimer</a>
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