<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="../style/bootstrap.css">
<h1>Bienvenue, <?php echo $_SESSION['Username']; ?></h1>

<br>

<a href="?action=add">Ajouter un produit</a>
<a href="?action=modifyanddelete">Modifier ou supprimer un produit</a>
<br>
<br>
<a href="?action=addcat">Ajouter une catégorie</a>
<a href="?action=modifyanddeletecat">Modifier ou supprimer une
	catégorie</a><br><br>
<a href="?action=options">Options :</a>

<br>
<br>

<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {

    die('Une erreur est survenue.');
}
if (isset($_SESSION['Username'])) {

    if (isset($_GET['action'])) {

        if ($_GET['action'] == 'add') {

            if (isset($_POST['submit'])) {
                
                $stock = $_POST['stock'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];

                $img = $_FILES['img']['name'];

                $img_tmp = $_FILES['img']['tmp_name'];
                $category = $_POST['category'];

                if (! empty($img_tmp)) {

                    $image = explode('.', $img);

                    $image_ext = end($image);

                    print_r($image_ext);

                    if (in_array(strtolower($image_ext), array(
                        'png',
                        'jpg',
                        'jpeg'
                    )) === false) {

                        echo "Veuillez rentrer une image au format: png,jpg ou jpeg. ";
                    } else {

                        $image_size = getimagesize($img_tmp);

                        if ($image_size['mime'] == 'image/jpeg') {

                            $image_src = imagecreatefromjpeg($img_tmp);
                        } else if ($image_size['mime'] == 'image/png') {

                            $image_src = imagecreatefrompng($img_tmp);
                        } else {

                            $image_src = false;
                            echo "Veuillez rentrer une image valide.";
                        }

                        if ($image_src !== false) {

                            $image_width = 200;

                            if ($image_size == $image_width) {

                                $image_finale = $image_src;
                            } else {
                                

                                $new_width = $image_width;

                                $new_height = 200;

                                $image_finale = imagecreatetruecolor($new_width, $new_height);

                                imagecopyresampled($image_finale, $image_src, 0, 0, 0, 0, $new_width, $new_height, $image_size[0], $image_size[1]);
                            }

                            imagejpeg($image_finale, 'img/' . $title . '.jpg');
                        }
                    }
                } else {

                    echo "Veuillez rentrer une image.";
                }

                if ($title && $description && $price && $stock) {
                    
                    $bdd = new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '');
                    
                    $category = $_POST['category'];
                    
                    $weight = $_POST['weight'];
                   
                    $select = $bdd->query("SELECT price FROM weights WHERE name='$weight'");
                    
                    $s=$select->fetch(PDO::FETCH_OBJ);
                    
                    $shipping = $s->price;
                    
                    $old_price = $price;
                    
                    $amountprice = $old_price + $shipping;
                    
                    $select= $bdd->query("SELECT tva FROM produits");
                    
                    $s1= $select->fetch(PDO::FETCH_OBJ);
                    
                    $tva = $s1->tva;
                    
                    $final_price = $amountprice+($amountprice* $tva/100);
                    
                    $insert = $bdd->query("INSERT INTO produits VALUES(NULL, '$title', '$description', '$price', '$category', '$weight', '$shipping', '$tva', '$final_price', '$stock')");
                    //$insert->execute();
                    // header('Location: ../admin/admin.php');
                } else {
                    
                    echo "Veuillez remplir tous les champs.";
                }
            }

            ?>

<form action="" method="POST" enctype="multipart/form-data">
	<h3>Titre du produit :</h3>
	<input type="text" name="title">
	<h3>Description du produit :</h3>
	<textarea name="description"></textarea>
	<h3>Prix :</h3>
	<input type="text" name="price"><br>
	<br>
	<h3>Image :</h3>
	<input type="file" name="img"><br>
	<br>
	<h3>Catégorie :</h3>
	<select name="category">
			<?php

            $select = $bdd->query("SELECT * FROM category");

            while ($s = $select->fetch(PDO::FETCH_OBJ)) {

                ?>

					<option><?php echo $s->name; ?></option>

					<?php
            }

            ?>
	</select><br>
	<h3>Poids : plus de :</h3>
	<select name="weight"> 
	
	<?php

            $select = $bdd->query("SELECT * FROM weights");

            while ($s = $select->fetch(PDO::FETCH_OBJ)) {

                ?>

					<option><?php echo $s->name; ?></option>

					<?php
            }
	?>
	</select><br><br>
	<h3>Stock : </h3><input type="text" name="stock"><br><br>
	<br><input type="submit" name="submit">
</form>

<?php
        } else if ($_GET['action'] == 'modifyanddelete') {

            $select = $bdd->prepare("SELECT * FROM produits");
            $select->execute();

            while ($s = $select->fetch(PDO::FETCH_OBJ)) {

                echo $s->title;

                ?>
<a href="?action=modify&amp; id=<?php echo $s->id; ?>">Modifier</a>
<a href="?action=delete&amp; id=<?php echo $s->id; ?>">x</a>
<br>
<?php
            }
        } else if ($_GET['action'] == 'modify') {

            $id = $_GET['id'];

            $select = $bdd->prepare("SELECT * FROM produits WHERE id=$id");
            $select->execute();

            $data = $select->fetch(PDO::FETCH_OBJ);

            ?>

<form action="" method="POST">
	<h3>Titre du produit :</h3>
	<input value="<?php echo $data->title; ?>" type="text" name="title">
	<h3>Description du produit :</h3>
	<textarea name="description"><?php echo $data->description; ?></textarea>
	<h3>Prix :</h3>
	<input value="<?php echo $data->price; ?>" type="text" name="price"><br>
	<h3>Stock : </h3><input type="text" name="stock" value="<?php echo $data->stock?>"><br><br>
	<br> <input type="submit" name="submit" value="Modifier">
</form>

<?php

            if (isset($_POST['submit'])) {

                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $stock = $_POST['stock'];

                $update = $bdd->prepare("UPDATE produits SET title='$title',description='$description',price='$price',stock='$stock' WHERE id=$id");
                $update->execute();

                header('Location: admin.php?action=modifyanddelete');
            }
        } else if ($_GET['action'] == 'delete') {

            $id = $_GET['id'];
            $delete = $bdd->prepare("DELETE FROM produits WHERE id=$id");
            $delete->execute();
        } else if ($_GET['action'] == 'addcat') {

            if (isset($_POST{'submit'})) {

                $name = $_POST['name'];

                if ($name) {

                    $insert = $bdd->prepare("INSERT INTO category VALUES(NULL, '$name')");
                    $insert->execute();
                } else {

                    echo "Veuillez remplir le champs.";
                }
            }

            ?>

<form action="" method="POST">
	<h3>Nom de la catégorie :</h3>
	<input type="text" name="name"><br>
	<br> <input type="submit" name="submit" value="Ajouter">
</form>

<?php
        } else if ($_GET['action'] == 'modifyanddeletecat') {
            
            $select = $bdd->prepare("SELECT * FROM category");
            $select->execute();

            while ($s = $select->fetch(PDO::FETCH_OBJ)) {

                echo $s->name;

                ?>
<a href="?action=modify_cat&amp; id=<?php echo $s->id; ?>">Modifier</a>
<a href="?action=deletecat&amp; id=<?php echo $s->id; ?>">x</a>
<br>
<?php
            }
        } else if ($_GET['action'] == 'modify_cat') {

            $id = $_GET['id'];
            $bdd = new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '');

            $select = $bdd->prepare("SELECT * FROM category WHERE id='$id");
            $select->execute();

            $data = $select->fetch(PDO::FETCH_OBJ);

            ?>

<form action="" method="POST">
	<h3>Nom de la catégorie :</h3>
	<input value="<?php echo $data='title'; ?>" type="text" name="title"> <input
		type="submit" name="submit" value="Modifier">
</form>

<?php

            if (isset($_POST['submit'])) {

                $title = $_POST['title'];

                $update = $bdd->prepare("UPDATE category SET name='$title' WHERE id=$id");
                $update->execute();

                header('Location: admin.php?action=modifycat');
            }
        } else if ($_GET['action'] == 'deletecat') {

            $id = $_GET['id'];
            $delete = $bdd->prepare("DELETE FROM category WHERE id=$id");
            $delete->execute();

            header('Location: admin.php?action=modifyanddeletecat');
        
    }else if($_GET['action']=='options'){
         ?>
         
         <h2>Frais de ports :</h2><br>
         <h3>Options de poids</h3>
         
         
         
         <?php 
           $bdd = new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '');
           $select= $bdd->query("SELECT * FROM weights");
           
           while($s= $select->fetch(PDO::FETCH_OBJ)){
               
           ?>
           
           	<form action="" method="POST">
           	<input type="text" name="weight" value="<?php echo $s->name; ?>"><a href="?action=modifyweight&amp;name=<?php echo $s->name; ?>"> Modifier</a>    
            </form> 
            
               <?php 
           }
                
                $select=$bdd->query("SELECT tva FROM produits");
                $s=$select->fetch(PDO::FETCH_OBJ);
                
                if(isset($_POST['submit2'])){
                    
                    $tva=$_POST['tva'];
                    
                    if($tva){
                        
                        $update = $bdd->query("UPDATE produits SET tva=$tva");
                    }
                }
           ?>
    
    <h3>TVA : </h3>
    
    <form action="" method="POST">
    <input type="text" name="tva" value="<?php echo $s->tva; ?>">
    <input type="submit" name="submit2" value="Modifier">
    </form>
    
    <?php 
    
    
    }else if($_GET['action']== 'modifyweight'){
        
        if(isset($_POST['submit'])){
            
            $oldweight = $_GET['name'];
            $weight=$_POST['weight'];
            
            if ($weight){
                
                $update = $bdd->query("UPDATE weights SET name='$weight' WHERE name='$oldweight'");
                
            }
            
        }
   
        ?>
        	<h2>Frais de ports :</h2><br>
        	<h3>Options :</h3>
        	
        	<form action="" method="POST">
        		<input type="text" name="weight" value="<?php echo $_GET['name']; ?>"><br><br>
        		<input type="submit" name="submit" value="Modifier">
        	</form>
        <?php
    
    }else{
        die("Une erreur s'est produite.");
    }
    
    }else {
    //header('Location: ../index.php');

    }
}
?>