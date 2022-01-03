<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Stripe\ApiResource;
use Stripe\BalanceTransaction;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Source;
use Stripe\Stripe;

/**
 * Developed by Digital Waves
 * Skype: ahsan.mughal2
 * Phone: +93-342-7047-934
 */
trait StripeTrait
{
	protected $api_key = "sk_test_gSSTrK7fN0ukaokExHJzsw67"; //TEST KEY
//    protected $api_key = "sk_live_NYPOXQdwvr0MNVeA8ucCrwc0"; //LIVE KEY

	/**
	 * Balance & History Related APIs
	*/
	public function balance()
	{

		try {
			Stripe::setApiKey($this->api_key);
			$balance = \Stripe\Balance::retrieve();
			return collect([
				'status' => 'success',
				'data' => $balance
			]);
		} catch (\Exception $e) {
			return collect([
				'status' => 'error',
				'message' => $e->getMessage()
			]);
		}
	}

	public function transactionDetail($txnId)
	{
		try {
			Stripe::setApiKey($this->api_key);
			$record = BalanceTransaction::retrieve($txnId);
			return collect([
				'status' => 'success',
				'data' => $record
			]);
		}catch (\Exception $e){
			return collect([
				'status' => 'error',
				'message' => $e->getMessage()
			]);
		}
	}

	public function history()
	{
		try {
			Stripe::setApiKey($this->api_key);
			$record = BalanceTransaction::all(["limit" => 3]);
			return collect([
				'status' => 'success',
				'data' => $record
			]);
		} catch (\Exception $e) {
			return collect([
				'status' => 'error',
				'message' => $e->getMessage()
			]);
		}
	}

	/**
	 * get Related APIs
	 */
	public function getCustomer($id)
	{
		Stripe::setApiKey($this->api_key);
		return Customer::retrieve($id);
	}

	/**
	 * Customer Related APIs
	 */
	public function createCustomer($customer)
	{
		Stripe::setApiKey($this->api_key);
		return Customer::create([
			"description" => "Customer for Gift Cards",
			"email" =>$customer->email, // obtained with Stripe.js
		]);
	}

	/**
	 * Customer Related APIs
	 */
	public function updateCustomer($customerId, $sourceId)
	{
		Stripe::setApiKey($this->api_key);
		return Customer::update(
			$customerId,
			[
				'source' => $sourceId,
			]
		);
	}


	/**
	 * Charge Related APIs
	 */
	public function charge($order, $token)
	{
		try {
			Stripe::setApiKey($this->api_key);
			$amount = $order['amount'];
			$charge = Charge::create([
				"amount" => $amount,
				"currency" => "usd",
				"source" => $token, // obtained with Stripe.js
				"description" => "Charge for Order Id " . 1
			]);
			return collect([
				'status' => 'success',
				'data' => $charge
			]);
		} catch (\Exception $e) {
			return collect([
				'status' => 'error',
				'message' => $e->getMessage()
			]);
		}
	}

	/**
	 * Charge Related APIs
	 */
	public function chargeViaCustomer($order, $customer)
	{
		try {
			Stripe::setApiKey($this->api_key);
			$amount = $order['amount'];
			$charge = Charge::create([
				"amount" => $amount,
				"currency" => "usd",
				"customer" => $customer, // obtained with Stripe.js
				"description" => "Charge for Order Id "
			]);
			return collect([
				'status' => 'success',
				'data' => $charge
			]);
		} catch (\Exception $e) {
			return collect([
				'status' => 'error',
				'message' => $e->getMessage()
			]);
		}
	}

    /**
     * Create Card Source
     * @param $customerId
     * @param $user
     * @return ApiResource
     * @throws ApiErrorException
     */
	public function createSource($customerId, $user)
	{
		Stripe::setApiKey($this->api_key);
		$card = Customer::createSource(
			$customerId, [
				'source' => [
					'object' => 'card',
					'number' => $user['card_number'],
					'exp_month' => $user['expiry_month'],
					'exp_year' => $user['expiry_year'],
					'cvc' => $user['cvv'],
					'currency' => 'usd',
					'default_for_currency' => true
				]
			]
		);
		return $card;
	}

	public function retrieveCard($customerId, $cardId)
	{
		$customer = Customer::retrieve($customerId);
		return $customer->retrieveSource($customerId, $cardId);
	}
}
