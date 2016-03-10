<?php
class CompteController extends Controller {
	private $categories;

	public function __construct(){
		$categoryManager=new CategoryManager;
		$this->categories=$categoryManager->getCategories();
	}

	public function identificationAction(){
		$userManager= new UserManager();
		$user=$userManager->getUser([htmlspecialchars(trim($_POST['email']))]);
		//var_dump($user,$_POST);
			
		if(password_verify(trim($_POST['password']),$user['passwordHash'])){
				//session_start();
				//session_regenerate_id();//permet de changer le PHPSESSID a chaque changement de page + de securite
				$panierManager=new PanierManager();
					
				$panierManager->setUser($user);
					
				//var_dump($_SESSION, $panierManager);
				header('Location:../../afficher/all/');
				exit();
		}
		
		else {
			header('Location:../../afficher/all/');
					exit();
			echo 'Compte inexistant ou mauvaise combinaison identifiant/mot de passe';
		}
	}

	public function creationAction(){
		
		$categories=$this->categories;

		$ids=[];

		$data=compact('user','categories','ids');

		new View ('creation',$data);

		if($_SERVER['REQUEST_METHOD']=='POST') {
			try{
				$userManager=new UserManager();
			
				$userManager->setUser(htmlspecialchars(trim($_POST['email'])), password_hash(htmlspecialchars(trim($_POST['password'])), PASSWORD_BCRYPT), $_POST['civility'], htmlspecialchars(trim($_POST['firstName'])), htmlspecialchars(trim($_POST['lastName'])));
				
				header('Location:../../afficher/all/');
				exit();
				}
			catch(PDOException $e){
				echo 'Client/email déjà existant';
			}

		}
	}

	public function authentificationAction(){
		$panierManager=new PanierManager();
		
		if (array_key_exists('user', $_SESSION)){
			header('Location:../../order/billing/');
			exit();
		}
		else{
			$panierManager= new PanierManager();

			$categories=$this->categories;

			$ids=$panierManager->getIds();

			$data=compact('categories', 'ids');

			new View('authentification',$data);

			if($_SERVER['REQUEST_METHOD']=='POST') {
				if(array_key_exists('email', $_POST)){
					try{
						$userManager=new UserManager();
						
						$userManager->setUser(htmlspecialchars(trim($_POST['email'])), password_hash(htmlspecialchars(trim($_POST['password'])), PASSWORD_BCRYPT), $_POST['civility'], htmlspecialchars(trim($_POST['firstName'])), htmlspecialchars(trim($_POST['lastName'])));

						$panierManager->setUser($userManager->getUser([$_POST['email']]));
						//$_SESSION['user']=$userManager->getUser([$_POST['email']]);
						
						header('Location:../../order/billing/');
						exit();
						}
					catch(PDOException $e){
						echo 'Client/email déjà existant';
					}
				}
				else {
					$userManager= new UserManager();
					
					$user=$userManager->getUser([htmlspecialchars(trim($_POST['emailverif']))]);
					
					if(password_verify(trim($_POST['passwordverif']),$user['passwordHash']))
					{								
						$panierManager->setUser($user);

						header('Location:../../order/billing/');
						exit();
					}
				}
			}
		}
	}

	
}