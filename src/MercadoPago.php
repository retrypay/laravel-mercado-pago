<?php

namespace OscarRey\MercadoPago;

use MercadoPago\{
  SDK,
  Payment,
  SearchResultsArray,
  Payer,
  Customer,
  Preference,
  Item,
  Chargeback,
  Entity,
  Refund,
  POS,
  InstoreOrder
};

use OscarRey\MercadoPago\Entity\{
  Preapproval,
  Plan,
  PaymentMethod,
  OAuth,
  Card,
  IdentificationType,
  MerchantOrder,
  InstoreOrderV2,
  Store,
  InstoreOrderQr,
  AuthorizedPayment
};

class MercadoPago  extends MercadoPagoConfig
{

  public function __construct()
  {
    $this->initSdk();
  }

  /**
   * función para comprobar el uso del facade a esta clase
   */
  public function hello()
  {

    return 'hello';
  }

  /**
   * Instancia de Payment
   * @return Payment
   */
  public function payment()
  {

    return new Payment();
  }

  /**
   * Instancia de Store
   * @return Store
   */
  public function store()
  {

    return new Store();
  }

  /**
   * Instancia de  AuthorizedPayment
   * @return  AuthorizedPayment
   */
  public function authorizedPayment()
  {

    return new AuthorizedPayment();
  }

  /**
   * Instancia de InstoreOrder
   * @return InstoreOrder
   * @link https://github.com/mercadopago/sdk-php/blob/9ca999e06cc8a875a11f0fcf4dccc75b41d020d5/src/MercadoPago/Entities/InstoreOrder.php
   */
  public function instoreOrder()
  {

    return new InstoreOrder();
  }

  /**
   * Instancia de InstoreOrderQr
   * @return InstoreOrderQr
   * @link https://www.mercadopago.com.co/developers/es/reference/qr-dynamic/_instore_orders_qr_seller_collectors_user_id_pos_external_pos_id_qrs/post
   */
  public function instoreOrderQr()
  {

    return new InstoreOrderQr();
  }

  /**
   * Instancia de InstoreOrderV2
   * @return InstoreOrderV2
   */
  public function instoreOrderV2()
  {

    return new InstoreOrderV2();
  }


  /**
   * Instancia de MerchantOrder
   * @return MerchantOrder
   */
  public function merchantOrder()
  {

    return new MerchantOrder();
  }

  /**
   * Instancia de PaymentMethod
   * @return PaymentMethod
   */
  public function paymentMethod()
  {

    return new PaymentMethod();
  }

  /**
   * Instancia de POS
   * @return POS
   */
  public function pos()
  {

    return new POS();
  }

  /**
   * Instancia de IdentificationType
   * @return IdentificationType
   */
  public function identificationType()
  {

    return new IdentificationType();
  }

  /**
   * Instancia de Payer
   * @return Payer
   */
  public function payer()
  {
    return new Payer();
  }

  /**
   * Instancia de Refund
   * @return Refund
   */
  public function refund()
  {
    return new Refund();
  }

  /**
   * Instancia de Customer
   * @return Customer
   */
  public function customer()
  {
    return new Customer();
  }

  /**
   * Instancia de Card
   * @return Card
   */
  public function card()
  {
    return new Card();
  }


  /**
   * Instancia de Plan
   * @return Plan
   */
  public function plan()
  {
    return new Plan();
  }

  /**
   * Instancia de OAuth
   * @return OAuth
   */
  public function oauth()
  {
    return new OAuth();
  }


  /**
   * Instancia de Preapproval
   * @return Preapproval
   * @link https://github.com/mercadopago/sdk-php/blob/9ca999e06cc8a875a11f0fcf4dccc75b41d020d5/src/MercadoPago/Entities/Preapproval.php
   */
  public function preapproval()
  {
    return new Preapproval();
  }

  /**
   * Instancia de Preference
   * @return Preference
   */
  public function preference()
  {
    return new Preference();
  }

  /**
   * Instancia de Item
   * @return Item
   */
  public function item()
  {
    return new Item();
  }

  /**
   * Instancia de Chargeback 
   * @return Chargeback
   */
  public function chargeback()
  {
    return new Chargeback();
  }

  /**
   * País de localidad de cuenta de mercado pago
   * @return string
   */
  public function getCountryId()
  {
    return SDK::getCountryId();
  }


  /**
   * Eliminar targeta de credito
   * @param string $customer_id
   * @return Card|null
   * @link https://www.mercadopago.com.co/developers/es/reference/cards/_customers_customer_id_cards/get
   */
  public function deleteCard($card_id, $customer_id)
  {
    $card = $this->card()->findById($customer_id);

    if ($card) {
      $card->customer_id = $customer_id;
      $card->id = $card_id;

      $card->delete();
    }

    return $card;
  }

  /**
   * Crear cliente con solo el email
   * @param string $email email del cliente a registrar
   * @return Customer
   * @link https://www.mercadopago.com.co/developers/es/reference/customers/_customers/post
   */
  public function createCustomerEmail($email)
  {
    $customer = $this->customerFindByEmail($email);

    if (!$customer) {

      $customer = $this->customer();

      $customer->email = $email;

      $customer->save();
    }

    return $customer;
  }

  /**
   * Consultar clientes
   * @param array $filter filtros de clientes
   * @return SearchResultsArray
   * @link https://www.mercadopago.com.co/developers/es/reference/customers/_customers_search/get
   */
  public function findCustomer($filter = [])
  {
    $customer = $this->searchHandler($this->customer(), $filter);

    return $customer;
  }


  /**
   * Consultar cajas 
   * @param array $filter filtros de pos
   * @return SearchResultsArray
   * @link https://www.mercadopago.com.co/developers/es/reference/pos/_pos/get
   */
  public function findPos($filter = [])
  {
    $pos = $this->searchHandler($this->pos(), $filter);

    return $pos;
  }

  /**
   * Buscar caja por id
   * @param string $id
   * @return POS|null
   * @link https://www.mercadopago.com.co/developers/es/reference/pos/_pos_id/get
   */
  public function posFindById($id)
  {
    $pos = $this->FindByIdHandler($this->pos(), $id);

    return $pos;
  }

  /**
   * Eliminar caja
   * @param string $id
   * @return POS|null
   * @link https://www.mercadopago.com.co/developers/es/reference/pos/_pos_id/delete
   */
  public function deletePos($id)
  {
    $pos = $this->posFindById($id);

    if ($pos) {

      $pos->delete();
    }

    return $pos;
  }

  /**
   * Buscar cliente por id
   * @param string $email
   * @return Customer|null
   * @link https://www.mercadopago.com.co/developers/es/reference/customers/_customers_id/get
   */
  public function customerFindByEmail($email)
  {
    $customer = $this->findCustomer(['email' => $email]);

    return $customer[0] ?? null;
  }

  /**
   * Buscar cliente por id
   * @param string $id
   * @return Customer|null
   * @link https://www.mercadopago.com.co/developers/es/reference/customers/_customers_id/get
   */
  public function customerFindById($id)
  {
    $customer = $this->FindByIdHandler($this->customer(), $id);

    return $customer;
  }


  /**
   * Reembolsar un pago
   * 
   * @param string $id
   * @return Payment
   * @link https://www.mercadopago.com.co/developers/es/docs/checkout-api/additional-content/cancellations-and-refunds
   */
  public function refundPament($id, $amount = 0)
  {
    $payment = $this->paymentFindById($id);

    $payment->refund($amount);

    return $payment;
  }

  /**
   * Cancelar un pago
   * 
   * @param string $id
   * @return Payment
   * @link https://www.mercadopago.com.co/developers/es/docs/checkout-api/additional-content/cancellations-and-refunds
   */
  public function cancelPayment($id)
  {
    $payment = $this->paymentFindById($id);

    $payment->status = 'cancelled';

    $payment->update();

    return  $payment;
  }

  /**
   * Buscar pago por id
   * @param string $id
   * @return Payment
   * @link https://www.mercadopago.com.co/developers/es/docs/checkout-api/additional-content/retrieving-payments
   */
  public function paymentFindById($id)
  {
    $payment = $this->FindByIdHandler($this->payment(), $id);

    return $payment;
  }

  /**
   *  Crear suscripción
   * @param string|null $back_url url de redirección despues del pago
   * @param string $reason descripción de la suscripción
   * @return Preapproval
   */
  public function createPreapproval($reason, $back_url = null)
  {
    $preapproval = $this->preapproval();
    $preapproval->back_url = $back_url ?? $this->getCallbackUrl();
    $preapproval->reason = $reason;

    return $preapproval;
  }

  /**
   *  Crear plan
   * @param string $back_url url de redirección una vez terminado el pago
   * @param string $description descripcion del plan (reason)
   * @return Plan
   * @link https://www.mercadopago.com.co/developers/es/reference/subscriptions/_preapproval_plan/post
   */
  public function createPlan($description, $back_url = null)
  {
    $plan = $this->plan();

    $plan->reason = $description;

    $plan->back_url = $back_url ?? $this->getCallbackUrl();

    return $plan;
  }

  /**
   * Consultar reembolso de un pago por el payment_id
   * @param string $payment_id
   * @return Refund|null
   * @link https://www.mercadopago.com.co/developers/es/reference/chargebacks/_payments_id_refunds/get
   */
  public function refundFindBydId($payment_id)
  {
    $refund = $this->findByIdHandler($this->refund(), $payment_id);

    return $refund;
  }

  /**
   * find by id
   * @param Entity $class
   * @param string $id
   * @return Entity
   */
  public function FindByIdHandler(Entity $class, $id)
  {
    $response = get_class($class);

    $response = $response::find_by_id($id);

    return $response;
  }

  /**
   * Consultar pagos
   * @param array $filter filtros para los pagos
   * @return SearchResultsArray
   * @link https://www.mercadopago.com.co/developers/es/docs/checkout-api/additional-content/retrieving-payments
   */
  public function findPayment($filter = [])
  {
    $payment = $this->searchHandler($this->payment(), $filter);

    return $payment;
  }


  /**
   * Consultar con filtro
   * @param Entity $class
   * @param array $filter filtros para los recursos
   * @return SearchResultsArray
   */
  public function searchHandler(Entity $class, $filter)
  {

    $class = get_class($class);

    $response = $class::search($filter);

    return $response;
  }


  /**
   * Crear un pago por efecty
   * @param int $amount
   * @param string|null $url_callback
   * @param string|null $notification_url
   * @return Payment
   * @link https://www.mercadopago.com.co/developers/es/docs/checkout-api/payment-methods/other-payment-methods
   */
  public function efecty($amount, $notification_url = null,  $url_callback = null)
  {
    return  $this->paymentHandler('efecty', $amount, $notification_url, $url_callback);
  }

  /**
   * Crear un pago por walletPurchase
   * @return Preference
   */
  public function walletPurchase()
  {
    $preference = $this->preference();
    $preference->purpose = 'wallet_purchase';

    return $preference;
  }

  /**
   * Crear un pago por efecty
   * @param int $amount
   * @param string|null $url_callback
   * @param string|null $notification_url
   * @return Payment
   * @link https://www.mercadopago.com.co/developers/es/docs/checkout-api/payment-methods/other-payment-methods
   */
  public function pse($amount, $notification_url = null, $url_callback = null)
  {
    return  $this->paymentHandler('pse', $amount, $notification_url, $url_callback);
  }

  /**
   * Manejador de payment
   * @param int $amount
   * @param string|null $url_callback
   * @param string $payment_type
   * @param string|null $notification_url
   * @return Payment
   * @link https://www.mercadopago.com.co/developers/es/docs/checkout-api/payment-methods/other-payment-methods
   */
  public function paymentHandler($payment_type, $amount, $notification_url = null, $url_callback = null)
  {
    $payment = $this->payment();
    $payment->payment_method_id = $payment_type;
    $payment->transaction_amount = $amount;
    $payment->notification_url = $notification_url;
    $payment->callback_url = $url_callback ?? $this->getCallbackUrl();
    return $payment;
  }

  /**
   * Inicializa el sdk de mercado pago
   * @link https://github.com/mercadopago/sdk-php
   */
  public function initSdk()
  {
    SDK::setAccessToken($this->getAccesToken());
  }


  /**
   * crear usuarios para hacer test
   * @link https://www.mercadopago.com.co/developers/es/reference/test_user/_users_test_user/post
   * @param string $site_id id del sitio donde se creará el usuario de prueba.
   */
  public function createTestUser($site_id = 'MCO')
  {
    $response = SDK::post('/users/test_user', $this->bodyHttp(
      [
        'site_id' => $site_id
      ]
    ));

    return $response;
  }

  /**
   * Convierte un array a json
   * @param array $data
   * @return string
   */
  private function json($data)
  {

    return json_encode($data);
  }

  /**
   * Returna la url de authorización de cuenta mercado pago
   * @param string|null $redirect_uri
   * @return string
   */
  public function authorizationURL($redirect_uri = null, $random_id = null)
  {
    return $this->oauth()->customGetAuthorizationURL(
      $this->getAppId(),
      $random_id,
      $redirect_uri ?? $this->getRedirectUri()
    );
  }

  /**
   * body para las peticiones del sdk mecado pago
   * @param array $data
   * @return string
   */
  private function bodyHttp($data)
  {
    return [
      'json_data' => $this->json($data)
    ];
  }
}
