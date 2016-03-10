<?php
class OrderController extends Controller {
	private $categories;

	public function __construct(){

		$categoryManager=new CategoryManager;

		$this->categories=$categoryManager->getCategories();
	}

	public function billingAction(){

		$panierManager= new PanierManager();
		
		$user=$panierManager->getUser();

		if(empty($user)){
			header('Location:../../');
			exit();
		}

		$errorMessages=[
			'Civility'=>'Arrête de bidouiller',
			'FirstName'=>'Veuillez entrer un prénom',
			'LastName'=>'Veuillez entrer un nom',
			'Adress'=>'Veuillez entrer une adresse',
			'ZipCode'=>'Veuillez entrer un code postal',
			'City'=>'Veuillez entrer une ville',
			'Country'=>'Va te faire ......',
			'PhoneNumber'=>'Veuillez entrer un numéro de téléphone valide' 
		];

		$formManager=new FormManager();

		$billingInfo=$formManager->getAll('billing');

		$formManager->saveErrors([], 'billing');

		$billingInfo['errors']=array_intersect_key($errorMessages, $billingInfo['errors']);

		$categories=$this->categories;

		$ids=$panierManager->getIds();

		$user=$panierManager->getUser();

		$data=compact('billingInfo','categories','ids','user');
		
		new View('billing',$data);
	}

	public function saveBillingAction(){
		$billingInfo=array_map('trim', $_POST['billing']);
	
		if(empty($billingInfo['Civility']) || !in_array($billingInfo['Civility'], array('M.', 'Mme', 'Mlle'))){
			$errors['Civility']=true;
			unset($billingInfo['Civility']);
		}

		if(empty($billingInfo['FirstName'])){
			$errors['FirstName']=true;
			unset($billingInfo['FirstName']);
		}

		if(empty($billingInfo['LastName'])){
			$errors['LastName']=true;
			unset($billingInfo['LastName']);
		}

		if(empty($billingInfo['Adress'])){
			$errors['Adress']=true;
			unset($billingInfo['Adress']);
		}

		if(empty($billingInfo['ZipCode'])){
			$errors['ZipCode']=true;
			unset($billingInfo['ZipCode']);
		}

		if(empty($billingInfo['City'])){
			$errors['City']=true;
			unset($billingInfo['City']);
		}

		if(empty($billingInfo['Country']) || !in_array($billingInfo['Country'],['France'])){
			$errors['Country']=true;
			unset($billingInfo['Country']);
		}

		if(empty($billingInfo['PhoneNumber'])){
			unset($billingInfo['PhoneNumber']);
		}
		elseif(!ctype_digit($billingInfo['PhoneNumber'])){
			$errors['PhoneNumber']=true;
			unset($billingInfo['PhoneNumber']);
		}


		$formManager= new FormManager();

		if(count($billingInfo)>0){
			$formManager->saveBilling($billingInfo, 'billing');
		}

		if(isset($errors)){
			$formManager->saveErrors($errors, 'billing');
			header('Location:'.CLIENT_ROOT.'/order/billing/');
			exit();
		}
		else{
			header('Location:'.CLIENT_ROOT.'/order/saveOne/');
			exit();
		}
	}

	public function saveOneAction(){
		$panierManager=new PanierManager();
		$orderManager= new OrderManager();
		$formManager=new FormManager();

		$user=$panierManager->getUser();

		$billingInfo=$formManager->getAll('billing');

		$ids=$panierManager->getIds();

		$quantities=$panierManager->getQuantity();

		$products=$orderManager->getProductsOrder($ids);

		foreach ($products as $key => $value) {
			$products[$key]['quantity']=$quantities[$key];
		}

		$idOrder=$orderManager->getLastEntry([$user['id']]);

		$orderManager->addOrder($billingInfo['billingInfo'], $billingInfo['billingInfo'], $user['id'], $products);

		$categories=$this->categories;

		$panierManager->delete();

		$ids=[];

		$data=compact('user','categories','ids');

		new View('success',$data);
/*
		foreach($ids as $key=>$value){
			$requete[]=[$idOrder['idOrder'], $value, $quantities[$key], $products[$key]['name'], $products[$key]['priceHT'], $products[$key]['VATRate']];
		}
		foreach ($requete as $key => $value) {
			foreach ($value as $key1 => $value2) {
				var_dump($value2);
			}		
		}
*/
		

		//$orderManager->addOrderLines($requete);
	}

}