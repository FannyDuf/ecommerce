
<div class="sidebar">
	<h4>Derniers articles</h4>

<?php

    $bdd = new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '');
	$select= $bdd->prepare("SELECT * FROM produits ORDER BY id DESC LIMIT 0,2");
	$select->execute();

	while ($s=$select->fetch(PDO::FETCH_OBJ)) {
        
	    $length=10;
	    $description= $s->description;
	    
	    ?>
<a href="?show=<?php echo $s->title; ?>"><img style="padding: 5px;" src="admin/img/<?php echo $s->title; ?>.jpg"></a>
<h2 style="color: white; text-decoration: underline; padding: 10px;"><?php echo $s->title;?></h2>
<h5 style="color: white; padding: 10px;"><?php echo substr($description, 0, $length)."...";?></h5>
<h4 style="color: red; padding: 10px;"><?php echo $s->price;?> Euros</h4>


<?php

}

?>
</div>