<?php
class FormManager{
	public function __construct()
		{
			if(session_status() !== PHP_SESSION_ACTIVE)
			{
				session_start();
			}
			//session_regenerate_id();

			if(!isset($_SESSION['form']))
			{
				$_SESSION['form'] = [];
			}
		}

		public function saveErrors(array $formErrors, $form)
		{
			$_SESSION['form'][$form]['errors'] = $formErrors;
		}

		public function saveBilling(array $formBilling, $form){
			$_SESSION['form'][$form]['billingInfo']=$formBilling;
		}

		public function getAll($form){
			if(isset($_SESSION['form'][$form]['billingInfo']))
			{
				$formInformation['billingInfo'] = $_SESSION['form'][$form]['billingInfo'];
			}
			else
			{
				$formInformation['billingInfo'] = [];
			}

			if(isset($_SESSION['form'][$form]['errors']))
			{
				$formInformation['errors'] = $_SESSION['form'][$form]['errors'];
			}
			else
			{
				$formInformation['errors'] = [];
			}

			return $formInformation;
		}
}