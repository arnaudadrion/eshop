<?php
class PanierController extends Controller {
	private $categories;
	
	public function __construct(){
		$categoryManager=new CategoryManager;
		$this->categories=$categoryManager->getCategories();
	}


	public function ajouterAction(){
		
		(new PanierManager())->ajouter($_GET['id'],$_POST['quantite']);

		header('Location:../../');
	}

	public function detailAction(){
		$panierManager= new PanierManager();
		//$this->actualize();
		if (array_key_exists('panier', $_SESSION) && !empty($_SESSION['panier'])){	
			$categories=$this->categories;

			$ids=$panierManager->getIds();				

			$quantity=$panierManager->getQuantity();

			$productManager= new ProductManager();
		
			$detail=$productManager->getDetail($ids);

			$total=null;
			foreach ($detail as $key => $value) {
				$total+=$value['priceTTC']*$quantity[$key];
			}

			if (array_key_exists('user', $_SESSION)){
				$user=$panierManager->getUser();
			}
			else{
				$user=[];
			}
//var_dump($detail,$_SESSION, $ids, $quantity, $user);

			$data=compact('detail','ids','quantity', 'total', 'user', 'categories');
				
			new View('detail', $data);
			
		}
		else {
			if (array_key_exists('user', $_SESSION)){
				$user=$panierManager->getUser();
			}
			else{
				$user=[];
			}
			$categories=$this->categories;

			$ids=[];

			$data=compact('user','categories','ids');

			new View('detail', $data);
		}
	}

	public function supprimerAction(){
		$panierManager= new PanierManager();

		$panierManager->remove($_GET['id']);

		header('Location:'.CLIENT_ROOT.'/panier/detail/');
		exit();
	}

	public function modifierAction(){
		
		$panierManager= new PanierManager();

		$panierManager->modify($_POST);

		header('Location:'.CLIENT_ROOT.'/panier/detail/');
		exit();
	}

	public function deconnexionAction(){
		$panierManager= new PanierManager();
		
		if (array_key_exists('user', $_SESSION)){
			unset($_SESSION['user']);
			header('Location:../../afficher/all/');
		}
	}

}