<?php

namespace Hodc\Response;

class CheckerResponse
{
    protected $status = false;
    protected $errorMessage = null;
    protected $errorCode = null;
    protected $whoisRawText = null;
    protected $domains = [];

    public function isStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;

        return $this;
    }

    public function addDomainResonse(DomainResponse $domain)
    {
        $this->domains[] = $domain;

        return $this;
    }

    public function getWhoisRawText()
    {
        return $this->whoisRawText;
    }

    public function setWhoisRawText($whoisRawText)
    {
        $this->whoisRawText = $whoisRawText;

        return $this;
    }

    /**
     * @return array
     */
    public function getDomains()
    {
        return $this->domains;
    }

    /**
     * @param array $domains
     */
    public function setDomains($domains)
    {
        $this->domains = $domains;
    }


}
