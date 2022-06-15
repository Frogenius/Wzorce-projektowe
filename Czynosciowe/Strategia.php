<?php

class OrderController
{
   
    public function post(string $url, array $data)
    {
        echo "Kontroler: żądanie POST do $url z " . json_encode($data) . "</br>";

        $path = parse_url($url, PHP_URL_PATH);

        if (preg_match('#^/orders?$#', $path, $matches)) {
            $this->postNewOrder($data);
        } else {
            echo "Kontroler: 404 page </br>";
        }
    }

    public function get(string $url): void
    {
        echo "Kontroler: GET żądanie do $url </br>";

        $path = parse_url($url, PHP_URL_PATH);
        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $data);

        if (preg_match('#^/orders?$#', $path, $matches)) {
            $this->getAllOrders();
        } elseif (preg_match('#^/order/([0-9]+?)/payment/([a-z]+?)(/return)?$#', $path, $matches)) {
            $order = Order::get($matches[1]);

            
            $paymentMethod = PaymentFactory::getPaymentMethod($matches[2]);

            if (!isset($matches[3])) {
                $this->getPayment($paymentMethod, $order, $data);
            } else {
                $this->getPaymentReturn($paymentMethod, $order, $data);
            }
        } else {
            echo "Kontroler: 404 page </br>";
        }
    }

    
    public function postNewOrder(array $data): void
    {
        $order = new Order($data);
        echo "Kontroler: Utworzono zamówienie #{$order->id}. </br>";
    }

   
    public function getAllOrders(): void
    {
        echo "Kontroler: Oto wszystkie zamówienia: </br>";
        foreach (Order::get() as $order) {
            echo json_encode($order, JSON_PRETTY_PRINT) . "</br>";
        }
    }

   
    public function getPayment(PaymentMethod $method, Order $order, array $data): void
    {
        
        $form = $method->getPaymentForm($order);
        echo "Kontroler: oto formularz płatności: </br>";
        echo $form . "</br>";
    }

    
    public function getPaymentReturn(PaymentMethod $method, Order $order, array $data): void
    {
        try {
            
            if ($method->validateReturn($order, $data)) {
                echo "Kontroler: Dziękujemy za zamówienie! </br>";
                $order->complete();
            }
        } catch (\Exception $e) {
            echo "Kontroler: mam wyjątek (" . $e->getMessage() . ") </br>";
        }
    }
}


class Order
{
    
    private static $orders = [];

  
    public static function get(int $orderId = null)
    {
        if ($orderId === null) {
            return static::$orders;
        } else {
            return static::$orders[$orderId];
        }
    }

    
    public function __construct(array $attributes)
    {
        $this->id = count(static::$orders);
        $this->status = "new";
        foreach ($attributes as $key => $value) {
            $this->{$key} = $value;
        }
        static::$orders[$this->id] = $this;
    }

    public function complete(): void
    {
        $this->status = "zakończony";
        echo "Zamówienie: #{$this->id} jest teraz {$this->status}.";
    }
}


class PaymentFactory
{
  
    public static function getPaymentMethod(string $id): PaymentMethod
    {
        switch ($id) {
            case "cc":
                return new CreditCardPayment;
            case "paypal":
                return new PayPalPayment;
            default:
                throw new \Exception("Nieznana metoda płatności");
        }
    }
}


interface PaymentMethod
{
    public function getPaymentForm(Order $order): string;

    public function validateReturn(Order $order, array $data): bool;
}


class CreditCardPayment implements PaymentMethod
{
    static private $store_secret_key = "swordfish";

    public function getPaymentForm(Order $order): string
    {
        $returnURL = "https://our-website.com/" .
            "order/{$order->id}/payment/cc/return";

        return <<<FORM
<form action="https://my-credit-card-processor.com/charge" method="POST">
    <input type="hidden" id="email" value="{$order->email}">
    <input type="hidden" id="total" value="{$order->total}">
    <input type="hidden" id="returnURL" value="$returnURL">
    <input type="text" id="cardholder-name">
    <input type="text" id="credit-card">
    <input type="text" id="expiration-date">
    <input type="text" id="ccv-number">
    <input type="submit" value="Pay">
</form>
FORM;
    }

    public function validateReturn(Order $order, array $data): bool
    {
        echo "CreditCardPayment: ...walidacja... ";

        if ($data['klucz'] != md5($order->id . static::$store_secret_key)) {
            throw new \Exception("Klucz płatności jest nieprawidłowy.");
        }

        if (!isset($data['powodzenie']) || !$data['success'] || $data['success'] == 'false') {
            throw new \Exception("Płatność nie powiodła się.");
        }

        if (floatval($data['total']) < $order->total) {
            throw new \Exception("Kwota płatności jest nieprawidłowa.");
        }

        echo "Gotowe! </br>";

        return true;
    }
}


class PayPalPayment implements PaymentMethod
{
    public function getPaymentForm(Order $order): string
    {
        $returnURL = "https://our-website.com/" .
            "order/{$order->id}/payment/paypal/return";

        return <<<FORM
<form action="https://paypal.com/payment" method="POST">
    <input type="hidden" id="email" value="{$order->email}">
    <input type="hidden" id="total" value="{$order->total}">
    <input type="hidden" id="returnURL" value="$returnURL">
    <input type="submit" value="Pay on PayPal">
</form>
FORM;
    }

    public function validateReturn(Order $order, array $data): bool
    {
        echo "PayPalPayment: ...walidacja... ";

        // ...

        echo "Gotowe! </br>";

        return true;
    }
}



$controller = new OrderController;

echo "Klient: Stwórzmy kilka zamówień </br>";

$controller->post("/orders", [
    "email" => "fr@gmail.com",
    "produkt" => "ABC Cat food (XL)",
    "calkowity" => 9.95,
]);

$controller->post("/orders", [
    "email" => "fr@gmail.com",
    "produkt" => "XYZ żwirek dla kota (XXL)",
    "calkowity" => 19.95,
]);

echo "</br> Klient: Wymień moje zamówienia, proszę </br>";

$controller->get("/orders");

echo "</br> Klient: Chciałbym zapłacić za drugi, pokaż formularz płatności </br>";

$controller->get("/order/1/payment/paypal");

echo "</br> Klient: ...naciska przycisk Zapłać...</br>";
echo "</br> Klient: Oh, zostałem przekierowany do  PayPal. </br>";
echo "</br> Klient: ...płaci na PayPal... </br>";
echo "</br> Klient: W porządku, wrócę z wami, chłopaki. </br>";

$controller->get("/order/1/payment/paypal/return" .
    "?key=c55a3964833a4b0fa4469ea94a057152&success=true&total=19.95");