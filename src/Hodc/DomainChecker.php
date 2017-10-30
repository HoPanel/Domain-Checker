<?php

namespace Hodc;

use Hodc\Response\CheckerResponse;
use Hodc\Response\DomainResponse;
use Hodi\Parser;

class DomainChecker
{
    /** @var WhoisList */
    protected $whoisList = null;

    /** @var Parser */
    protected $parser = null;

    /** @var CheckerResponse */
    protected $response = null;

    public function __construct()
    {
        $this->whoisList = new WhoisList();
        $this->parser = new Parser();
        $this->response = new DomainResponse();
    }

    public function addWhoisProvider($providerName, $whoisUrl)
    {
        $this->whoisList->addProvider($providerName, $whoisUrl);

        return $this;
    }

    public function removeWhoisProvider($providerName)
    {
        $this->whoisList->removeProvider($providerName);

        return $this;
    }

    public function checkDomain($domainName)
    {
        $parsed = $this->parseDomain($domainName);

        if (!$parsed) {
            $this->response->setStatus(false)
                ->setErrorMessage('Domain Parse Error')
                ->setErrorCode('NF01');
            return $this->response;
        }

        $provider = $this->whoisList->getProvider($parsed['tld']);

        if (!$provider) {
            $this->response->setStatus(false)
                ->setErrorMessage('Tld not found')
                ->setErrorCode('NF02');

            return $this->response;
        }

        return $this->getDomainWhois($parsed['host'], $provider);
    }

    private function getDomainWhois($domainHost, $whoisUrl)
    {
        $domainResult = new DomainResponse();

        $serverConn = @fsockopen($whoisUrl, 43);

        $response = '';
        if ($serverConn) {
            fwrite($serverConn, "$domainHost\r\n");
            while (!feof($serverConn)) {
                $response .= fgets($serverConn, 128);
            }
            fclose($serverConn);
        }

        $domainResult->setWhoisRawText($response);
        $domainResult->fill($this->parseWhoisText($response));
        $domainResult->setStatus(true);

        return $domainResult;
    }

    private function parseDomain($domainName)
    {
        if (strpos($domainName, 'http') === false) {
            $domainName = 'http://' . $domainName;
        }
        $result = $this->parser->parseUrl($domainName);
        if (!$result->getIsDomain()) {
            return [];
        }

        $host = $result->getDomainHost();
        $tld = substr(strrchr($host, '.'), 1);

        return [
            'host' => $host,
            'tld' => $tld,
        ];
    }

    private function parseWhoisText($rawText)
    {
        $rows = explode("\n", $rawText);
        $arrs = [];
        foreach ($rows as $row) {
            $posOfFirstColon = strpos($row, ':');
            $key = str_replace(' ', '_', strtoupper(substr($row, 0, $posOfFirstColon)));
            $key = str_replace('___', '', $key);

            if ($key) {
                $arrs[$key] = trim(substr($row, $posOfFirstColon + 1));
            }
        }

        return $arrs;
    }
}
