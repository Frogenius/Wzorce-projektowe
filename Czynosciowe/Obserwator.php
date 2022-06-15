<?php



interface Observer
{
    
    public function change(Observed $bbserved);
}

/**
 * 
 * Interface Observer
 */
interface Observed
{
    // Zarejestruj obserwatora
    public function attach(Observer $observer);
    // usuń obserwatora
    public function detach(Observer $observer);
    // wyzwolić powiadomienie
    public function notify();
    // uzyskać cenę
    public function getSale();
}



/**
 * Obserwowana klasa
 * Class Observer
 */
class Server implements Observed
{
    // istniejące pieniądze
    private $sale;
    // Mapa obserwatora
    private $observer = [];

    /**
     * zarejestruj obserwatora
     * @param Observer $observer
     */
    public function attach(Observer $observer)
    {
        // Jeśli nie jest zarejestrowany,zarejestruj sie
        if (false === array_search($observer, $this->observer))
        {
            $this->observer[] = $observer;
        }
    }

    /**
     * usuń obserwatora
     * @param Observer $observer
     */
    public function detach(Observer $observer)
    {
        // Jeśli zostanie znaleziony, usuń go
        $key = array_search($observer, $this->observer);
        if (false !== $key)
        {
            unset($this->observer[$key]);
        }
    }

    /**
     * wyzwolić powiadomienie
     */
    public function notify()
    {
        // Iteruj przez obserwatorów powiadomień
        foreach ($this->observer as $observer)
        {
            $observer->change($this);
        }
    }


    public function setSale($sale)
    {
        $this->sale = $sale;

        // Powiadom obserwatorów
        $this->notify();
    }

    public function getSale()
    {
        return $this->sale;
    }
}

/**
 * 
 * Class Mail
 */
class Mail implements Observer
{
    public function change(Observed $observed)
    {
        /**
         * Brak pieniędzy, wyślij e-mail, bo e-mail jest bezpłatny
         */
        if ($observed->getSale() < 10000)
        {
            echo '</br> Nadal mogę żyć, wysyłając e-maile';
        }

    }
}

/**
 * 
 * Class SMS
 */
Class SMS implements Observer
{
    public function change(Observed $observed)
    {
        /**
         * Jeśli pensja jest większa niż 1w, wyślij sms
         */
        if ($observed->getSale() > 10000 && $observed->getSale() < 100000)
        {
            echo '</br> pieniądze na wysłanie krótkich odsetek';
        }


    }
}

/**
 * 
 * Class MMS
 */
class MMS  implements Observer
{
    public function change(Observed $observed)
    {
        /**
         * Za dużo pieniędzy, kapryśność, MMS
         */
        if ($observed->getSale() > 100000)
        {
            echo '</br> Za dużo pieniędzy, wyślij MMS-a ';
        }

    }
}

// Zauważony
$server = new Server();

// Zarejestruj obserwatora
$server->attach(new Mail());
$server->attach(new SMS());
$server->attach(new MMS());

// Zmień status -> Powiadomienie
$server->setSale(1000000);

// Zmień status -> Powiadomienie
$server->setSale(99999);

// Zmień status -> Powiadomienie
$server->setSale(9);

