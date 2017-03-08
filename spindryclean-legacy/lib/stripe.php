<?php
  class StripeWSP extends BaseClass
  {
		public $customerId = null;
		public $customer =  null;
		public $card = array();

		function __construct()
		{
			parent::__construct();
			require_once(APPLICATIONREQUIREROOT.'stripe/init.php');
		}

		function retrieveCreateCustomer($snapCustId, $Card='')
		{

			//echo "<br/> =========== -1" ;
			//customer is created on Stripe first before defining id on local db
			if(Customer::getStripeId($snapCustId)){
				//echo "<br/> =========== 0" ;

				$this->customerId = 'spinmember_'. CurrentServer() .'_'. $snapCustId;
				$stripeCustomer = array( 
					"id" => $this->customerId,
					"description" => "SPIN " . $snapCustId,
			 		"card" => $Card
			    );

				//create Stripe customer
				try
	    		{
	    			$stripeCustomer = \Stripe\Customer::create($stripeCustomer);
	    		}
	    		catch (Exception $e) {
	    				//echo "<br/> =========== error" ;
				  // Something else happened, completely unrelated to Stripe
			 		header("Location: ".APPROOT.'credit-cards.php?'.$Encrypt->encrypt('Title=Stripe Error !&MessageStyle=bg-orange&Message=We apologize. ' . $err['message']));
					exit;
				}

				//echo "<br/> =========== 2" ;
	        	//store Stripe customer id
					$sqlUpdateCutomerId = 'UPDATE tblcustomer  SET `StripeId` = "'. $this->customerId 
	        		. '" WHERE id = '. $snapCustId ;
	        	parent::GetDALInstance()->SQLQuery($sqlUpdateCutomerId);
	        	
	        	return true;

        	}else{
        		//echo "<br/> =========== ----1" ;
        		$this->customerId = 'spinmember_'. CurrentServer() .'_'. $snapCustId;
        		$this->customer = \Stripe\Customer::retrieve($this->customerId);
        		$this->card = $Card;
        		$this->customer->card = $this->card;
        		return $this->customer->save();
        	}

        	

        	return true;
		}

		function setCard($card){
			if(!empty($card)){
				$this->card = $card;
			}
			$this->customer->card = $this->card;

			return $this->customer->save();
		}

		//make sure to setCard($card) first
		function applyCharge($Amount, $currency = 'cad'){
			global $DAL, $Encrypt;

			$chargeResult = false;

			$stripeCharge = array( 
	        	'customer' => $this->customer->id,
	            "amount" => ($Amount * 100), 
	            "currency" => $currency, 
	            "card" => $this->card,
	            "description" => 'New transaction charge for  ' . $this->customer->id
	        );

	        try
	    	{
				        //charge customer
				   		if( ($stripeCharge['amount'] > 0) && (!empty($this->card)) ){
				   			
				   			$chargeResult = \Stripe\Charge::create($stripeCharge);
				   		}
				   		
			}
			
		    
		 	catch (Exception $e) {
			  // Something else happened, completely unrelated to Stripe
		 		header("Location: ".APPROOT.'payment.php?'.$Encrypt->encrypt('Title=Error&MessageStyle=bg-orange&Message=We apologize. Sorry for the inconvenience. '));
				exit;
			}

	   		return true;
		}

		//negative account_balance is a "credit" for customer, positive number is owed and will be charged on next invoice
		function applyCredit($creditAmount)
		{
			$this->customer->account_balance -= $creditAmount;
			return $this->customer->save();
		}

		function retrieveCredit(){
			$wspCredit = 0;
			
			if($this->customer->account_balance != 0){
				//negative amount is considered a credit on Stripe, positive amount is credit on wsp
				//stripe values are in cents
				$wspCredit = $this->customer->account_balance / (-100);
			}
			return $wspCredit;
		}

		function retrieveCustomer($snapCustId)
		{
			//echo "<br/> =========== -1" ;
			//customer is created on Stripe first before defining id on local db
			if(Customer::getStripeId($snapCustId)){
				return false;
        	}else{
        		//echo "<br/> =========== ----1" ;
        		$this->customerId = 'spinmember_'. CurrentServer() .'_'. $snapCustId;
        		$this->customer = \Stripe\Customer::retrieve($this->customerId);
        		$this->customer->sources->retrieve($this->customer->sources->data[0]->id)->delete();
        		return $this->customer->save();
        	}
        	return true;
		}


  }
?>