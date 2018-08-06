<?php
require_once ('includes/header.php');
require_once ('includes/sidebar.php');

if (isset($_GET['show'])) {

    $product = $_GET['show'];

    $bdd = new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '');

    $select = $bdd->query("SELECT * FROM produits WHERE title='$product'");

    $s = $select->fetch(PDO::FETCH_OBJ);

    ?>

<br>
<div style="text-align: center;">
	<img src="admin/img/<?php echo $s->title; ?>.jpg">
	<h2><?php echo $s->title; ?></h2>
	<h5><?php echo $s->description; ?></h5>
	<h4><?php echo $s->price; ?> Euros</h4>
	<h5>Stock : <?php echo $s->stock; ?></h5>
	<?php if ($s->stock!=0){ ?><a
		href="panier.php?action=add&amp;l=<?php echo $s->title; ?>&amp;q=1; &amp;p=<?php echo $s->price; ?>">Ajouter
		au panier</a><?php }else{ echo '<h5 style="color:red;">Stock &eacute;puis&eacute; !<h5>';} ?>
	<br>
	<br>
</div>
<br>
<br>
<?php
} else {

    if (isset($_GET['category'])) {

        $category = $_GET['category'];

        $bdd = new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '');
        $select = $bdd->query("SELECT * FROM produits WHERE category='$category'");

        while ($s = $select->fetch(PDO::FETCH_OBJ)) {

            $length = 10;

            $description = $s->description;

            ?>


<a href="?show=<?php echo $s->title; ?>"><img
	src="admin/img/<?php echo $s->title; ?>.jpg"></a>
<h2>
	<a href="?show=<?php echo $s->title; ?>"><?php echo $s->title; ?></a>
</h2>
<h5><?php echo substr($description, 0, $length)."..."; ?></h5>
<h4><?php echo $s->price; ?> Euros</h4>
<!-- 	<a href="">Ajouter au panier</a> -->
<h5>Stock : <?php echo $s->stock; ?></h5>
<?php if ($s->stock!=0){ ?><a
	href="panier.php?action=add&amp;l=<?php echo $s->title; ?>&amp;p=<?php echo $s->price; ?>">Ajouter
	au panier</a><?php }else{ echo '<h5 style="color:red;">Stock &eacute;puis&eacute; !<h5>';} ?>
<br>
<br>


<?php
        }
    } else {
        $bdd = new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '');
        $select = $bdd->query("SELECT * FROM category");

        while ($s = $select->fetch(PDO::FETCH_OBJ)) {

            ?>

<h3>
	<a href="?category=<?php echo $s->name; ?>"><?php echo $s->name ?></a>
</h3>

<?php
        }
    }
}

require_once ('includes/footer.php');

?>