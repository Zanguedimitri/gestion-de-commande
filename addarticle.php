<?php $article=true;
include_once("main.php"); 
if (isset($_POST["retour"])) {
  header("Location:article.php");
}
include_once("header.php");


?>
<main class="flex-shrink-0">
  <div class="container">
    <hr>
    <h1 class="mt-5" >Ajouter un article</h1>

</div>
</main>
<?php
include_once("footer.php");
?>