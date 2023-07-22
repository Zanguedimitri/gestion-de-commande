<?php  
session_start();
include_once("main.php");
include_once("mailer.php"); 
 
if (!empty($_POST["nom"]) && !empty($_POST["inputville"]) && !empty($_POST["fone"])) {
    $query="insert into clients (nom,ville_id,telephone) values (:nom,:ville,:fone)";
    $pdostmt=$pdo->prepare($query);
    $resultat=$pdostmt->execute(["nom"=>$_POST["nom"],"ville"=>$_POST["inputville"],"fone"=>$_POST["fone"]]);
    if (!$resultat) {
        $msg="données non enregistrer";
        $reponse=[
            "value"=>false,
            "msg"=>$msg,
        ];
    } else {
        $msg="données enregistrer avec success";
        $reponse=[
            "value"=>true,
            "msg"=>$msg,
        ];
    }
    echo json_encode($reponse);
    $pdostmt->closeCursor();
}
if (!empty($_POST["nom"])&&!empty($_POST["ville"])){
    $query="insert into article (description, prix_unitaire) values (:nom,:ville)";
    $pdostmt=$pdo->prepare($query);
    $result=$pdostmt->execute(["nom"=>$_POST["nom"],"ville"=>$_POST["ville"]]);
    if (!$result) {
        $msg="l'ajout n'a pas réussir";
        $response=[
            "value"=>false,
            "msg"=>$result->errorInfo(),
        ]; 
    } else {
        $msg="ajout reussir";
        $response=[
            "value"=>true,
            "msg"=>$msg,
        ]; 
    }
    echo json_encode($response);
}

if (!empty($_POST["depart_code"])) {
    $query="SELECT * FROM villes_france WHERE ville_departement = :code_department ORDER BY ville_nom ASC";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->bindParam(":code_department",$_POST["depart_code"]);
    $pdostmt->execute();
    $reponse="";
    while ($row=$pdostmt->fetch(PDO::FETCH_ASSOC)):
        $reponse.= "<option value=".$row["ville_id"].">".$row["ville_nom"]."</option>";
    endwhile;
    echo $reponse;
    $pdostmt->closeCursor();
}

if (!empty($_POST["username_register"]) && !empty($_POST["email_register"]) && !empty($_POST["password_register"])){
    //verification du user
     
    $query="select username from user where username=:name";
    $pdostmt=$pdo->prepare($query);
    $pdostmt->execute(["name"=>$_POST["username_register"]]);
    $myresult1=$pdostmt->fetch(PDO::FETCH_ASSOC);

        if (!$myresult1) {

                    //verification du email

                    $query2="select email from user where email=:mail ";
                    $pdostmt2=$pdo->prepare($query2);
                    $pdostmt2->execute(["mail"=>$_POST["email_register"]]);
                    $myresult=$pdostmt2->fetch(PDO::FETCH_ASSOC);


                if (!$myresult ) {
                        $query="insert into user (username, email, password) values (:name,:mail,:pass) ";
                        $pdostmt=$pdo->prepare($query);
                        $result=$pdostmt->execute([ "name"=>$_POST["username_register"],"mail"=>$_POST["email_register"],"pass"=>password_hash($_POST["password_register"],PASSWORD_DEFAULT) ]);
                        $msg="email ajouter avec success!" ;
                            if ($result) {
                                $response=[
                                    "msg"=>$msg,
                                    "value"=>true
                                ];
                            }else {
                                $response=[ 
                                "msg"=>$pdostmt->errorInfo(),
                                "value"=>false
                                ];
                            }
                }else{
                        $msg="Cet Email existe déja !";
                        $response=["email"=>$msg];
                
                }
                
        }else{
                $msg="Cet utilisateur existe déja !";
                $response=["user"=>$msg];
            }
            echo json_encode($response);
 }

if (!empty($_POST["username_login"]) && !empty($_POST["password_login"])) {
    $query="select * from user where username=:name";
    $stmt=$pdo->prepare($query);
    $stmt->execute(["name"=>$_POST["username_login"]]);
    $result=$stmt->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        $msg="cet utilisateur n'existe pas";
        $reponse=["username"=>$msg];
    } else {
        $pass=password_verify($_POST["password_login"],$result["password"]);
        if (!$pass) {
            $msg="ce mot de pass est erroné";
            $reponse=[
            "value"=>false,  
                "msg"=>$msg,
            ];
        } else {
            $_SESSION["user"]=$result["username"];
            $reponse=[
                "value"=>true,  
                ];
        }
        
    }
    echo json_encode($reponse);

}
if (!empty($_POST["email_password-forget"])){
    $query="select * from user where email=:mail";
    $stmt=$pdo->prepare($query);
    $stmt->execute(["mail"=>$_POST["email_password-forget"]]);
    $user_data=$stmt->fetch(PDO::FETCH_ASSOC);
    $msg="cet email n'existe pas dans notre système";
    if (!$user_data) {
       $response=[
        "value"=>false,
        "msg"=> $msg,
       ];
    }else {
        $user_id=$user_data["id"];
        $user_email=$user_data["email"];
        $token=bin2hex(random_bytes(16));
        $query="insert into password_reset_request(user_id, data_request, token) value (:user, :date, :token)";
        $stmt=$pdo->prepare($query);
        $stmt->execute(["user"=>$user_id, "date"=>date("Y-m-d H:i:s"), "token"=>$token]);
        $statut=forgot_password_reset($user_email, $token, $user_id);
        $msg="un email vous à été envoyé";
        $response=[ 
            "value"=>true,
            "msg"=> $msg,
            "statut"=>$statut,
                ];
    }
    echo json_encode($response);
}
 
if (!empty($_POST["new-password"]) && !empty($_POST["confirm-password_register"]) ){
    $mail=$_POST['user_mail'];
    $token=$_POST["token"];
    $query="select * from user, password_reset_request where user.id= password_reset_request.user_id and user.email=:mail and  password_reset_request.token=:t ";
    $stmt=$pdo->prepare($query);
    $stmt->execute(["mail"=>$mail, "t"=>$token]);
    $user_info=$stmt->fetch(PDO::FETCH_ASSOC);
    if ($user_info) {
        $iduser=$user_info["user_id"];
        $myquery="update user set password=:psw where id=:iduser ";
        $pdostmt=$pdo->prepare($myquery);
        $pdostmt->execute(["psw"=>password_hash($_POST["new-password"],PASSWORD_DEFAULT),"iduser"=>$iduser]);
        $msg="update";
        $response=[
            "value"=>true,
            "msg"=>$msg,
        ];
    } else {
        $msg="ces informations ne correspondent à aucun nom d'utilisateur ";
        $response=[
            "value"=>false,
            "msg"=>$msg,
        ];
    }
    
    echo json_encode($response); 
}

?>
