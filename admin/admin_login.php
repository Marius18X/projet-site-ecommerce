<?php
    include('../components/connexion.php');
    
    session_start();

    if(isset($_POST['submit'])){
        $nom = $_POST['nom'];
        $nom = filter_var($nom, FILTER_SANITIZE_STRING);
        $password = sha1($_POST['password']);
        $password = filter_var($password, FILTER_SANITIZE_STRING);  

        // requête qui affiche l'administrateur recherché
        $select_admin = $pdo->prepare("SELECT * FROM admins WHERE nom = ? AND pass = ?");
        $select_admin->execute([$nom, $password]);

        if ($select_admin->rowCount() > 0) {
            $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
            $_SESSION['admin_id'] = $fetch_admin_id['id'];
            header('location:dashboard.php');
        }else{
            $message[] = 'identifiant ou mot de passe incorrect !';
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion</title>
    <!-- lien cdn font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- lien vers le fichier css personnalisé -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

    <?php
        if (isset($message)) {
            foreach($message as $message){
                echo '
                <div class="message">
                    <span>'.$message.'</span>
                    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                </div>
                ';
            }
        }
    ?>

    <!-- section formulaire de connexion admin début -->
    <section class="form-container">
        <form action="" method="POST">
            <h3>se connecter</h3>
            <p>
                Identifiant = <span>admin</span> et Mot de passe = <span>111</span> <br>
            </p>
            <input type="text"  name="nom" maxlength="20" required placeholder="Entrer votre identifiant" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password"  name="password" maxlength="20" required placeholder="Entrer votre mot de passe" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="se connecter" class="btn">
        </form>
    </section>
    <!-- section formulaire de connexion admin fin -->
</body>
</html>