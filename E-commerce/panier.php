<?php
session_start();
require_once ('includes/header.php');
require_once ('includes/sidebar.php');
require_once ('includes/functions_shopcart.php');

$erreur = false;

$action = (isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : null));

if ($action !== null) {
    
    if (! in_array($action, array(
        'add',
        'delete',
        'refresh'
    )))
        
        $erreur = true;
        
        //$l = name; $q = quantity; $p = weight;
        $l = (isset($_POST['l']) ? $_POST['l'] : (isset($_GET['l']) ? $_GET['l'] : null));
        $q = (isset($_POST['q']) ? $_POST['q'] : (isset($_GET['q']) ? $_GET['q'] : null));
        $p = (isset($_POST['p']) ? $_POST['p'] : (isset($_GET['p']) ? $_GET['p'] : null));
        //retrait des espaces
        $l = preg_replace('#\v#', '', $l);
        //verif float
        $p = floatval($p);
        //soit tableau soit entier
        if (is_array($q)) {
            
            $amountarticle = array();
            
            $i = 0;
            
            foreach ($q as $contenu){
                
                $amountarticle[$i ++] = intval($contenu, 10);
            }
        } else 
            
            
            $q = intval($q);
        }


if (! $erreur) {
    
    switch ($action) {
        //add article
        Case "add":
            $l = (isset($_POST['l']) ? $_POST['l'] : (isset($_GET['l']) ? $_GET['l'] : null));
            $q = (isset($_POST['q']) ? $_POST['q'] : (isset($_GET['q']) ? $_GET['q'] : null));
            $p = (isset($_POST['p']) ? $_POST['p'] : (isset($_GET['p']) ? $_GET['p'] : null));
            
            
            addarticle($l, $q, $p);
            
            break;
            //delete article
        Case "delete":
            
            deletearticle($l);
            
            break;
            //modify
        Case "refresh":
            
            for ($i = 0; $i < count($amountarticle); $i ++){
                
                modifyamountarticle(!empty($_SESSION['shopcart']['nameproduct'][$i]), round($amountarticle[$i]));
            }
            
            break;
            
        default:
            
            break;
    }
}


?>

<form action="panier.php" method="POST">
    <table>
        <tr>
            <td colspan="4"><h2>Votre panier</h2></td>
        </tr>
        <tr>
            <td>Nom du produit :</td>
            <td>Prix unitaire :</td>
            <td>Quantit&eacute; :</td>
            <td>TVA :</td>
            <td>Action</td>
        </tr>
        <?php
//delete panier
if (isset($_GET['deleteshopcart']) && $_GET['deleteshopcart'] == true) {

    deleteshopcart();

    
}

if (createcart()) {
    
    $nbproducts = count($_SESSION['shopcart']['nameproduct']);

    if ($nbproducts <= 0) {

        echo '<br><p style= "color:red;">Oups, votre est panier vide !"</p>';
    
} else {

   

    for ($i = 0; $i < $nbproducts; $i ++) {
        
        ?>
               
         <tr>
            <td><br><?php echo $_SESSION['shopcart']['nameproduct'][$i]; ?></td>
            <td><br><?php echo $_SESSION['shopcart']['priceproduct'][$i]; ?></td>
            <td><br><input name="q[]" value="<?= $_SESSION['shopcart']['amountproduct'][$i]; ?>" size="5"></td>
            <td><br><?php  
                         $bdd = new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '');
                         $select = $bdd->query("SELECT tva FROM produits");
                         $data = $select->fetch(PDO::FETCH_OBJ);
                         $_SESSION['shopcart']['tva'] = $data->tva;
                         echo $_SESSION['shopcart']['tva']."%"; 
                         ?></td>
            <td><br><a href="panier.php?action=delete&amp;l=<?php echo rawurlencode($_SESSION['shopcart']['nameproduct'][$i]); ?>">X</a>
        
        </tr>
  <?php } ?> 
        <tr>

            <td colspan="2">
            <br><p>Total : <?php echo pricetotal();?></p><br>
                
        
        </tr>

        <tr>

            <td colspan="4">
                <input type="submit" value="Rafraichir"> 
                <input type="hidden" name="action" value="refresh"> 
                <a href="?deleteshopcart=true">Supprimer le panier</a>
        
        </tr>
                  
                  
                  <?php
}
}

?>
    </table>

</form>












<?php

require_once ('includes/footer.php');

?>