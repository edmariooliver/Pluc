<?php
    //Starting session 

    session_start();

    //Error => false

    // ini_set('display_errors', 0 );
    // error_reporting(0);
    
    //loading archive whu we be will using the class "Link"

    require('src/ClassEncurt.php');
    use App\Link;
    
    //Verify if the URL current is an link

    if($_SERVER['REQUEST_URI'] == "/index.php" || $_SERVER['REQUEST_URI'] == "/" || $_SERVER['REQUEST_URI'] == "/index" ){

    }else{
        $link = $_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];
        if(Link::getLink($link)){
        $link = Link::getLink($link);
        header('Location: '.$link['link_orig']);
        }
    }

    //Verify if the URL current is an request of form

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $link = new Link($_POST['link']);
        $link_gene = $link->generate_link();
        $link->link_validation();

        if (!$link_gene['exist']){
            if($link->link_validation()){
                $link->save_link();
            }    
        }

        $_SESSION['link_encurt'] = $link_gene['link'];
        $_SESSION['link_orig'] = htmlspecialchars($_POST['link']);

        // header("location: encurtar?encurtado=".$link_encurt."&"."original=".$_POST['link']);
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/css.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
    <meta name="description" content="Pluc é um encurtador de links grátis e fácil de se usar, com uma interface intuitiva. Encurte suas urls sem limite de vezes porque é o Pluc Encurtador é grátis">
    <script src="assets/js/copy.js"></script>
    
    <title>Pluc - Encutador de links</title>
</head>
<body class="">
    <div class="section-1">
        <div class="main container">
            <div class="logo container">
                <div>
                    <div class='txt-logo'>
                        <h1 id="txt-pluc">Pluc</h1><h1 id="txt-enc">Encurtador</h1>
                    </div>
                    <br>
                    <h3>Cole a URL que você quer encurtar</h3>
                </div>
            </div>
            <div class=" div-flex-column box-url">
                <div class=" container">
                    <form action="" method="post" class="form">
                        <input type="text" required class="input-text" name="link" id="link" placeholder="Cole o link">
                        <input value="Encurtar" class="input-submit" type="submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
            <div class="">
                <?php
                    if($_SERVER['REQUEST_METHOD'] == "POST"){
                        if($link->link_validation()){
                            require("base/bloco_result.php");
                        }else{
                            require("base/error.php");
                        }
                    }
                ?>
            </div>   
        </div>
        <div class="section2">
            <div class="container">

            </div>
            <div class="container">
                <div class="card">
                    <div class="img-card">
                        <!-- <img src="assets/img/lock.svg" alt=""> -->
                    </div>
                    <div class="text-card">
                    </div>
                </div>
            </div>
        </div>
</body>
</html>
