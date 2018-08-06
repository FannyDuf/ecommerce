<?php

//creation panier
function createcart()
{
    if (! isset($_SESSION['shopcart'])) {
        
        $_SESSION['shopcart'] = array();
        $_SESSION['shopcart']['nameproduct'] = array();
        $_SESSION['shopcart']['amountproduct'] = array();
        $_SESSION['shopcart']['priceproduct'] = array();
        $_SESSION['shopcart']['isLock'] = false;
        
        
      
    }
    
    return true;
}
//ajouter un article
function addarticle($nameproduct, $amountproduct, $priceproduct)
{
    if (createcart() && ! isLock()) {
        
        $position_product = array_search($nameproduct, $_SESSION['shopcart']['nameproduct']);
        
        if ($position_product !== false) {
            
            $_SESSION['shopcart']['amountproduct'][$position_product] += $amountproduct;
        } else {
            
            array_push($_SESSION['shopcart']['nameproduct'], $nameproduct);
            array_push($_SESSION['shopcart']['amountproduct'], $amountproduct);
            array_push($_SESSION['shopcart']['priceproduct'], $priceproduct);
            
        }
    } else {
        
        echo "Erreur, veuillez contacter le vendeur.";
    }
}
//modifier un article
function modifyamountarticle($nameproduct, $amountproduct)
{
    if (createcart() && ! isLock()) {
        
        if ($amountproduct > 0) {
            
            $position_product = array_search($nameproduct, $_SESSION['shopcart']['nameproduct']);
            
            if ($position_product !== false) {
                
                $_SESSION['shopcart']['amountproduct'][$position_product] = $amountproduct;
            }
            
        } else {
           
            deletearticle($nameproduct);
        }
    } else {
        echo "Erreur, veuillez contacter le vendeur.";
    }
}
//delete article 
function deletearticle($nameproduct)
{
    if (createcart() && ! isLock()) {
        
        $tmp = array();
        $tmp['nameproduct'] = array();
        $tmp['amountproduct'] = array();
        $tmp['priceproduct'] = array();
        $tmp['isLock'] = $_SESSION['shopcart']['isLock'];
        
        for ($i = 0; $i < count($_SESSION['shopcart']['nameproduct']); $i ++) {
            
            if ($_SESSION['shopcart']['nameproduct'][$i] !== $nameproduct) {
                
                array_push( $tmp['nameproduct'],$_SESSION['shopcart']['nameproduct'][$i]);
                array_push( $tmp['amountproduct'],$_SESSION['shopcart']['amountproduct'][$i]);
                array_push( $tmp['priceproduct'],$_SESSION['shopcart']['priceproduct'][$i]);
            }
            
            
            $_SESSION['shopcart'] = $tmp;
            
            unset($tmp);
        }
    } else {
        
        echo "Erreur, veuillez contacter le vendeur.";
    }
}
//calcul prix
function pricetotal()
{
    $_SESSION['shopcart'] = array();
    $_SESSION['shopcart']['nameproduct'] = array();
    $_SESSION['shopcart']['amountproduct'] = array();
    $_SESSION['shopcart']['priceproduct'] = array();
    $_SESSION['shopcart']['isLock'] = false;
    $total = 0;
    for($i = 0; $i < count($_SESSION['shopcart']['nameproduct']); $i++)
    {
        $total += $_SESSION['shopcart']['amountproduct'][$i] * $_SESSION['shopcart']['priceproduct'][$i];
    }
    
    return $total;
}
//calcul prix avec tva
//  function pricetotaltva()
// {
//     $bdd = new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '');
//     $select = $bdd->query("SELECT tva FROM produits");
//     $data = $select->fetch(PDO::FETCH_OBJ);
//     $_SESSION['shopcart']['tva'] = $data->tva;
//     $_SESSION['shopcart'] = array();
//     $_SESSION['shopcart']['nameproduct'] = array();
//     $_SESSION['shopcart']['amountproduct'] = array();
//     $_SESSION['shopcart']['priceproduct'] = array();
//     $_SESSION['shopcart']['isLock'] = false;
//     $total = 0;
//     for($i = 0; $i < count($_SESSION['shopcart']['nameproduct']); $i++)
//         {
//             $total += $_SESSION['shopcart']['amountproduct'][$i] * $_SESSION['shopcart']['priceproduct'][$i];
//         }
//     $bdd = new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '');
//         $select = $bdd->query("SELECT tva FROM produits");
//         $data = $select->fetch(PDO::FETCH_OBJ);
//         $_SESSION['shopcart']['tva'] = $data->tva;
//        return $total + $total * $_SESSION['shopcart']['tva'] / 100;
//  }
//     $total = 0;

//     for ($i = 0; $i < count($_SESSION['shopcart']['nameproduct']); $i ++) {

//         $total += $_SESSION['shopcart']['amountproduct'] * $_SESSION['shopcart']['priceproduct'][$i];
//     }
//     $bdd = new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '');
//     $select = $bdd->query("SELECT tva FROM produits");
//     $data = $select->fetch(PDO::FETCH_OBJ);
//     $_SESSION['shopcart']['tva'] = $data->tva;
//     return $total + $total * $_SESSION['shopcart']['tva'] / 100;


//supprimer panier
function deleteshopcart()
{
    if (isset($_SESSION['shopcart'])) {
        
        unset($_SESSION['shopcart']);
    }
}
//verouiller
function isLock()

{
    
    
    if (isset($_SESSION['shopcart']) && $_SESSION['shopcart']['isLock']) {
        
        return true;
    } else {
        
        return false;
    }
}
//compteur d'article
function counterarticle()
{
    if (isset($_SESSION['shopcart'])) {
        
        return count($_SESSION['shopcart']['nameproduct']);
    } else {
        return 0;
    }
}
?>