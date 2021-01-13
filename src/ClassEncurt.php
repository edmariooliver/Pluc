<?php

namespace App;

include("vendor/autoload.php");

class Database
{
    public $db;

    static function connect()
    {
        try{
            $db = new \PDO("");
            return $db;
        }catch(PDOException $erro){

            return "Não foi possivel conectar-se com o banco de dados: ".$erro->getMessage();
        }       
    }
}

class Link
{
    public $link_encurt;
    public $link_orig;

    public function __construct($link_orig)
    {
        $this->link_orig = $link_orig;
        $this->link_encurt;
    }

    static function  getLink($link)
    {
        $sql    = 'SELECT * FROM links WHERE link_encurt = "'.$link.'"';
        $stmt   = Database::connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function link_validation()
    {
        //Função para verificar se o link é válido
        $test = get_headers($this->link_orig);

        if(!$test){

            return false;
        }else{
            
            return true;
        }
    }
    
    public function generate_link()
    {
        /*
        Função que gera e retorna um link encurtado, que será associado ao link inserido pelo usuario
        
        1- Essa função verifica se o link inserido já está cadastrado, se tiver, o sistema pega o link => 
        encurtado associado ao link inserido e o retorna. 
        Caso não exista, ele gera um novo link encurtado e retorna para o usuário. => 
        */

        $sql    = 'SELECT * FROM links WHERE link_orig = "'.$this->link_orig . '"';
        $stmt   = Database::connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if($stmt->rowCount() > 0){
            $link              = $result["link_encurt"];
            $qrcode            = (new \chillerlan\QRCode\QRCode())->render($link);
            $this->link_encurt = array("exist"=>true, "link"=>$link, "QRcode"=> $qrcode );
        }
        else{
            do {
                for($i=0; $i<7; $i++){ 
                    $chars_random       = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r",
                                                "s","t","u","v","w","x","y","z","A","B","C","D","E"."F","G","H","I","J",
                                                "K","L","M","N","O","P","Q","R","S","T","U","T","V","W","X","Y","Z");
                    
                    $indice_char_random = array_rand($chars_random);                              //Pega um indice aleatório dentro do array
                    $this->link_encurt  = $this->link_encurt . $chars_random[$indice_char_random]; //Concatena todos os carateres aleatórios escolhidos dentro da variável do link
                }

                $qrcode            = (new \chillerlan\QRCode\QRCode())->render($this->link_encurt);
                $this->link_encurt = array("exist"=>false ,"link"=>$_SERVER['HTTP_HOST']."/".$this->link_encurt, "QRcode"=> $qrcode );//Link gerado
                $sql_link          = 'SELECT * FROM links WHERE link_encurt = "' . $this->link_encurt['link'] . '"';
                $stmt_link         = Database::connect()->prepare($sql_link);
                $stmt_link->execute();
                $result            = $stmt_link->fetch(\PDO::FETCH_ASSOC);

            } while ($stmt_link->rowCount() > 0);
        }

        //Retorna o link
        return $this->link_encurt; 
    }

    public function save_link()
    {
        $sql = "INSERT INTO links(link_encurt, link_orig) VALUES (?, ?)";
        
        if(!preg_match("/(http)/", $this->link_orig)){
            $this->link_orig = "http://".$this->link_orig;
        }
        
        $stmt = Database::connect()->prepare($sql);
        $stmt->bindValue(1, $this->link_encurt["link"]);
        $stmt->bindValue(2, $this->link_orig);
        $stmt->execute();
    }
    
}
