<div class="qrcode">
    <p>QR Code</p>
    <img src="<?php echo $link_gene['QRcode']?>" alt="">
</div>
<div class="">
    <div class="bloco-link div-flex">
        <p class="div-flex desc-link">Gerado </p><button id="btn-cp-en" onmouseout="onDown()" onclick="copy_encurt()"class="button-copy">Copiar</button></p> <p class="link" id="encurt-link"><?php echo $link_gene['link'] ?></p>
        <p>
    </div>
</div>

<div>
    <div class="bloco-link div-flex">
    <p class="div-flex desc-link">Sua Url</p>
    <button class="button-copy" onmouseout="onDown()" id="btn-cp-or" onclick="copy_origi()">Copiar</button>    
    <p class="link"><?php 
        
        echo strlen($_POST['link']);
        if(strlen($_POST['link']) > 20){
            echo mb_strimwidth(htmlspecialchars($_POST['link']),0, 20, "...");
        }else{
            echo mb_strimwidth(htmlspecialchars($_POST['link']),0, 20);
        }
        ?>
    </p>
    </div>
    <p class="link-completo" id="complete-link" style="display:none"><?php echo $_POST["link"];?></p>
</div>
