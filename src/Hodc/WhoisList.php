<?php

namespace Hodc;

class WhoisList
{
    protected $whoisList = [];

    protected $whoisSourceFile = __DIR__.'/db/whois.json';

    public function __construct($sourceFile = null)
    {
        if (!$sourceFile) {
            $this->whoisSourceFile = $sourceFile;
        }
        $this->loadDb();
    }

    private function loadDb()
    {
        if (file_exists($this->whoisSourceFile)) {
            $result = file_get_contents($this->whoisSourceFile, true);
            $this->whoisList = $result;
        }
    }

    public function getProvider($providerName)
    {
        return (array_key_exists($providerName, $this->whoisList)) ? $this->whoisList[$providerName] : null;
    }

    public function getAllWhoisList()
    {
        return $this->whoisList;
    }

    public function addProvider($provider, $whoisUrl)
    {
        $this->whoisList[$provider] = $whoisUrl;

        return $this;
    }

    public function removeProvider($provider)
    {
        unset($this->whoisList[$provider]);
    }
}
