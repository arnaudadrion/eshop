<?php 
class AfficherController extends Controller {
	private $categories;

	const NUMBER_PER_PAGE=2;

	public function __construct(){
		$categoryManager=new CategoryManager;
		$this->categories=$categoryManager->getCategories();
	}

	public function allAction(){

		$productManager=new ProductManager();

		$number=$productManager->getAllCount();

		$pagination =
			[
				'requestedPage' => (array_key_exists('page', $_GET) ? $_GET['page'] : 1),
				'lastPage' => ceil($number['numbers']/self::NUMBER_PER_PAGE)
			];

		$products=$productManager->getAllProducts($pagination['requestedPage']);
		
		$categories=$this->categories;
		
		$panierManager= new PanierManager();

		if (array_key_exists('panier', $_SESSION) && !empty($_SESSION['panier'])){	
			$ids=$panierManager->getIds();
		}
		else {
			$ids=[];
		}

		if (array_key_exists('user', $_SESSION)){
			$user=$_SESSION['user'];
		}
		else{
			$user=[];
		}

		$data=compact('products','categories','pagination','ids', 'user');

		var_dump($_SESSION);

		new View('afficher', $data);
	}

	public function oneCategoryAction(){
		$productManager=new ProductManager();

		$number=$productManager->getByCategoryCount([$_GET['id']]);

		$pagination =
			[
				'requestedPage' => (array_key_exists('page', $_GET) ? $_GET['page'] : 1),
				'lastPage' => ceil($number['numbers']/self::NUMBER_PER_PAGE)
			];

		$products=$productManager->getProductsByCategory($_GET['id'], $pagination['requestedPage']);

		$categories=$this->categories;

		$panierManager= new PanierManager();

		if (array_key_exists('panier', $_SESSION) && !empty($_SESSION['panier'])){	
			$ids=$panierManager->getIds();
		}
		else {
			$ids=[];
		}

		if (array_key_exists('user', $_SESSION)){
			$user=$_SESSION['user'];
		}
		else{
			$user=[];
		}

		$data=compact('products','categories','pagination','ids', 'user');

		new View('afficher', $data);
	}

	public function oneAction(){
		$productManager=new ProductManager();

		$product=$productManager->getOneProduct([$_GET['id']]);

		$categories=$this->categories;

		$panierManager= new PanierManager();

		if (array_key_exists('panier', $_SESSION) && !empty($_SESSION['panier'])){	
			$ids=$panierManager->getIds();
		}
		else {
			$ids=[];
		}

		if (array_key_exists('user', $_SESSION)){
			$user=$_SESSION['user'];
		}
		else{
			$user=[];
		}

		$data=compact('product','categories', 'ids', 'user');

		new View('afficherUn', $data);
	}

	public function rechercheAction(){
		$productManager=new ProductManager();

		$number=$productManager->getResearchCount($_GET['recherche']);

		$pagination =
			[
				'requestedPage' => (array_key_exists('page', $_GET) ? $_GET['page'] : 1),
				'lastPage' => ceil($number['numbers']/self::NUMBER_PER_PAGE)
			];

		$products=$productManager->getResearch($_GET['recherche'], $pagination['requestedPage']);

		
		$categories=$this->categories;	

		$panierManager= new PanierManager();

		if (array_key_exists('panier', $_SESSION) && !empty($_SESSION['panier'])){	
			$ids=$panierManager->getIds();
		}
		else {
			$ids=[];
		}

		if (array_key_exists('user', $_SESSION)){
			$user=$_SESSION['user'];
		}
		else{
			$user=[];
		}	
		
		$data=compact('products','categories','pagination', 'ids', 'user');
		
		new View('afficher', $data);
	}
}