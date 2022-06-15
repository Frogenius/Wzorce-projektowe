<?php

interface Downloader
{
    public function download(string $url): string;
}

class SimpleDownloader implements Downloader
{
    public function download(string $url): string
    {
        echo "</br> Pobieranie pliku z Internetu. </br>";
        $result = file_get_contents($url);
        echo "Pobrany bajty: " . strlen($result) . "</br>";

        return $result;
    }
}

class CachingDownloader implements Downloader
{
   
    private $downloader;
    private $cache = [];

    public function __construct(SimpleDownloader $downloader)
    {
        $this->downloader = $downloader;
    }

    public function download(string $url): string
    {
        if (!isset($this->cache[$url])) {
            echo "CacheProxy MISS. ";
            $result = $this->downloader->download($url);
            $this->cache[$url] = $result;
        } else {
            echo "Trafienie do serwera proxy pamięci podręcznej. Pobieranie wyniku z pamięci podręcznej. </br>";
        }
        return $this->cache[$url];
    }
}

function clientCode(Downloader $subject)
{
    

    $result = $subject->download("http://example.com/");

    $result = $subject->download("http://example.com/");

}

echo "Wykonywanie kodu klienta z rzeczywistym tematem. </br>";
$realSubject = new SimpleDownloader;
clientCode($realSubject);

echo "</br>";

echo "Wykonywanie tego samego kodu klienta za pomocą proxy: ";
$proxy = new CachingDownloader($realSubject);
clientCode($proxy);