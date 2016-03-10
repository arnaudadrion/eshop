<?php
class UserManager extends Manager {
	
	public function getUser($id){
		$requete='SELECT * FROM Customers WHERE email=?';
		$resultset=$this->getDataBaseConnection()->prepare($requete);
		$resultset->execute($id);
		$user=$resultset->fetch();
		return $user;
	}

	public function setUser($mail,$password,$civility,$fName, $lName){
		$requete='INSERT INTO Customers(email, passwordHash, civility, firstName, lastName) VALUES(?,?,?,?,?)';
		$resultset=$this->getDataBaseConnection()->prepare($requete);
		$resultset->execute([$mail,$password,$civility,$fName, $lName]);
	}

	
}