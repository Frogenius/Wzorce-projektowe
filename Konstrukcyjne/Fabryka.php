<?php

abstract class SocialNetworkPoster
{    
    abstract public function getSocialNetwork(): SocialNetworkConnector;
  
    public function post($content): void
    {
       
        $network = $this->getSocialNetwork();
        $network->logIn();
        $network->createPost($content);
        $network->logout();
    }
}


class FacebookPoster extends SocialNetworkPoster
{
    private $login, $password;

    public function __construct(string $login, string $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    public function getSocialNetwork(): SocialNetworkConnector
    {
        return new FacebookConnector($this->login, $this->password);
    }
}


class LinkedInPoster extends SocialNetworkPoster
{
    private $email, $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getSocialNetwork(): SocialNetworkConnector
    {
        return new LinkedInConnector($this->email, $this->password);
    }
}


interface SocialNetworkConnector
{
    public function logIn(): void;

    public function logOut(): void;

    public function createPost($content): void;
}

class FacebookConnector implements SocialNetworkConnector
{
    private $login, $password;

    public function __construct(string $login, string $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    public function logIn(): void
    {
        echo "Wyślij żądanie HTTP API, aby zalogować się użytkownika $this->login z " .
            "haslem $this->password\n";
    }

    public function logOut(): void
    {
        echo "Wyslij zadanie HTTP API, aby wylogowac uzytkownika $this->login </br>";
    }

    public function createPost($content): void
    {
        echo "</br> zakonczenie zadan HTTP API w celu utworzenia \"$content\" post na osi czasu na Facebooku. </br>";
    }
}

class LinkedInConnector implements SocialNetworkConnector
{
    private $email, $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function logIn(): void
    {
        echo "Szakończenie żądania HTTP API w celu zalogowania użytkownika $this->email z " .
            "haslem $this->password </br>";
    }

    public function logOut(): void
    {
        echo "Wyślij żądanie HTTP API, aby wylogować użytkownika $this->email\n";
    }

    public function createPost($content): void
    {
        echo "Wysyłaj żądania HTTP API, aby utworzyć post na osi czasu LinkedIn. </br>";
    }
}

function clientCode(SocialNetworkPoster $creator)
{
    // ...
    $creator->post("arkusza 1");
    $creator->post("akrusza 2");
    // ...
}


echo "Testing ConcreteCreator1: </br>";
clientCode(new FacebookPoster("frogennius", "******"));
echo "</br></br>";

echo "Testing ConcreteCreator2:</br>";
clientCode(new LinkedInPoster("frogennius@gmail.com", "******"));