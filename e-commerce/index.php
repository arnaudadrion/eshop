<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Arnaud Adrion, développeur Web</title>
	<link rel="stylesheet" type="text/css" href="accueilstyle.css">
</head>
<body>
		
	<div class="header">
		<nav class="container clearfix">
			<div class="fl w50">
				<h1>Arnaud Adrion</h1>
				
			</div>
			<div class="fl w50">
				<ul class="clearfix">					
					<li><a href="#" id="contact">Contact</a></li>
					<li><a href="#" id="portfolio">Portfolio</a></li>
					<li><a href="#" id="profil">Profil</a></li>
				</ul>
			</div>
		</nav>
	</div>
	
	<div class="container">    
	    <div class="profil" id="divprofil">
	    	<h2>Profil</h2>
	    	<p>Développeur web basé sur le région parisienne, c'est mon grand intérêt pour internet et la programmation qui m'ont poussé, lors d'une reconversion, vers le domaine du web. Autodidacte, ce site a pour but de montrer mes compétences en programmation informatique sur les langages les plus courants.
	Je suis actuellement disponible pour toutes missions de développement, intégration ou maintenance.</p>
			<a class="red" href="CVADRION2016.pdf" >Télécharger mon cv</a>
	    </div>
		
		<div class="portfolio" id="divportfolio">
			<h2>Portfolio</h2>
			
			<p class="entete">E-commerce</p>
			
			<p class="paragraphe"> <b>Développement d'un site de e-commerce</b> -
Intégration HTML/LESS, interactions base de données Mysql, développement de l’ensemble des fonctionnalités en PHP natif avec l’architecture MVC : Présentation des produits et catégories, pagination, recherche de produit, authentification et session utilisateur, système de sauvegarde du panier et des formulaires, processus de commande sécurisé</p>

			<a class="green" href="e-commerce/">Visiter le site</a>

			<p class="entete">Blog</p>

			<p class="paragraphe"><b>Développement d’une structure de Blog</b> -
Intégration HTML/CSS, interactions base de données Mysql, développement de l’ensemble des fonctionnalités en PHP natif avec l’architecture MVC : Présentation des articles et catégories, gestion des tags multiples, authentification, gestion des commentaires, zone d’administration du contenu (articles et commentaires) et des utilisateurs</p>

		</div>

		<div class="contact" id="divcontact">
			<h2>Contact</h2>

			<a href="mailto:adrionarnaud.1@gmail.com">
                            <p class="left"></p>
                            <p class="right">adrionarnaud.1@gmail.com</p>
                        </a>
<!--
			<form action="" method="post">
				<input type="email" id="contact" name="contact" required placeholder="Email">
				<textarea name="content" id="content" cols="30" rows="10"></textarea>
				<input type="submit">
			</form>
<?php 
if(isset($_POST['content'])){
mail('adrionarnaud.1@gmail.com','email site perso',$_POST['content']);
}?>-->

		</div>
	</div>
	

	<script type="text/javascript" src="accueil.js"></script>
</body>	
</html>

