<?php
class OrderManager extends Manager {
	public function addOrder(array $billing, array $delivery, $id, $products){
		$requete='INSERT INTO Orders(purchaseDate, billingCivility, billingFirstName, billingLastName, billingAdress, billingZipCode, billingCity, billingCountry, billingPhoneNumber, deliveryCivility, deliveryFirstName, deliveryLastName, deliveryAdress, deliveryZipCode, deliveryCity, deliveryCountry, deliveryPhoneNumber, idCustomer) VALUES(NOW(),?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';

		$resultset=$this->getDataBaseConnection()->prepare($requete);
/*
		foreach ($billing as $key => $value) {
			$resultset->bindValue($key+1, $value, PDO::PARAM_STR);
		}

		foreach ($delivery as $key => $value) {
			$resultset->bindValue($key+9, $value, PDO::PARAM_STR);
		}
*/
		$resultset->bindValue(1, $billing['Civility'], PDO::PARAM_STR);
		$resultset->bindValue(2, $billing['FirstName'], PDO::PARAM_STR);
		$resultset->bindValue(3, $billing['LastName'], PDO::PARAM_STR);
		$resultset->bindValue(4, $billing['Adress'], PDO::PARAM_STR);
		$resultset->bindValue(5, $billing['ZipCode'], PDO::PARAM_STR);
		$resultset->bindValue(6, $billing['City'], PDO::PARAM_STR);
		$resultset->bindValue(7, $billing['Country'], PDO::PARAM_STR);
		if (!isset($billing['billingPhoneNumber'])){
			$resultset->bindValue(8, null, PDO::PARAM_NULL);
		}
		else{
			$resultset->bindValue(8, $billing['PhoneNumber'], PDO::PARAM_INT);
		}
		$resultset->bindValue(9, $billing['Civility'], PDO::PARAM_STR);
		$resultset->bindValue(10, $billing['FirstName'], PDO::PARAM_STR);
		$resultset->bindValue(11, $billing['LastName'], PDO::PARAM_STR);
		$resultset->bindValue(12, $billing['Adress'], PDO::PARAM_STR);
		$resultset->bindValue(13, $billing['ZipCode'], PDO::PARAM_STR);
		$resultset->bindValue(14, $billing['City'], PDO::PARAM_STR);
		$resultset->bindValue(15, $billing['Country'], PDO::PARAM_STR);
		if (!isset($billing['billingPhoneNumber'])){
			$resultset->bindValue(16, null, PDO::PARAM_NULL);
		}
		else{
			$resultset->bindValue(16, $billing['PhoneNumber'], PDO::PARAM_INT);
		}
		$resultset->bindValue(17, $id, PDO::PARAM_INT);

		$resultset->execute();

		$idOrder=$this->getDataBaseConnection()->lastInsertId();
/*
		foreach ($products as $key => $value) {
			$this->addOrderLines($value, $idOrder);
		}
*/
		$this->addOrderLines($products, $idOrder);
	}
/*
	public function addOrderLines($orderline,$id){
		$requete='INSERT INTO OrderLines(id_order, id_product, quantity, name_product, priceHT, VATRate) VALUES (?,?,?,?,?,?)';

		$resultset=$this->getDataBaseConnection()->prepare($requete);

		$resultset->bindValue(1, $id, PDO::PARAM_INT);

		$resultset->bindValue(2, $orderline['id'], PDO::PARAM_INT);

		$resultset->bindValue(3, $orderline['quantity'], PDO::PARAM_INT);

		$resultset->bindValue(4, $orderline['name'], PDO::PARAM_STR);

		$resultset->bindValue(5, $orderline['priceHT'], PDO::PARAM_INT);

		$resultset->bindValue(6, $orderline['VATRate'], PDO::PARAM_INT);		

		$resultset->execute();		
	}
*/
	public function getProductsOrder(array $id){
		$requete='SELECT id, name,priceHT, VATRate  FROM Products WHERE id IN ('.implode(',',array_fill(0, count($id), '?')).')';

		$resultset=$this->getDataBaseConnection()->prepare($requete);
		
		foreach ($id as $key => $value) {
			$resultset->bindValue($key+1, $value, PDO::PARAM_INT);
		}

		$resultset->execute();
		
		$products=$resultset->fetchAll();
		return $products;
	}

	public function getLastEntry($id){
		$requete='SELECT MAX(id) as idOrder FROM Orders WHERE idCustomer=?';

		$resultset=$this->getDataBaseConnection()->prepare($requete);

		$resultset->execute($id);

		$id=$resultset->fetch();

		return $id;
	}

	public function addOrderLines(array $orderline, $id){
		$requete='INSERT INTO OrderLines(idOrder, idProduct, quantity, nameProduct, priceHT, VATRate) VALUES '.implode(',', array_fill(0, count($orderline), '(?,?,?,?,?,?)'));

		$resultset=$this->getDataBaseConnection()->prepare($requete);

		$compteur=0;

		foreach ($orderline as $key => $value) {

			$resultset->bindValue(1+$compteur, $id, PDO::PARAM_INT);

			$resultset->bindValue(2+$compteur, $value['id'], PDO::PARAM_INT);

			$resultset->bindValue(3+$compteur, $value['quantity'], PDO::PARAM_INT);

			$resultset->bindValue(4+$compteur, $value['name'], PDO::PARAM_STR);

			$resultset->bindValue(5+$compteur, $value['priceHT'], PDO::PARAM_INT);

			$resultset->bindValue(6+$compteur, $value['VATRate'], PDO::PARAM_INT);

			$compteur+=6;
		}	

		$resultset->execute();		
	}
}