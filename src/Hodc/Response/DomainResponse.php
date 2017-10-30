<?php

namespace Hodc\Response;

class DomainResponse
{
    protected $status = false;
    private $data = [];

    protected $domainName;
    protected $registryExpiryDate;
    protected $updatedDate;
    protected $creationDate;

    protected $whoisRawText = null;

    public function isStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param $data
     */
    public function fill($data)
    {

        $this->data = $data;


        $this->setDomainName($this->ifSet('DOMAIN_NAME'));
        $this->setNameServer($this->ifSet('NAME_SERVER'));


        if ($this->getDomainName()) {

            $this->setUpdatedDate($this->getDateTime($this->ifSet('UPDATED_DATE')));
            $this->setCreationDate($this->getDateTime($this->ifSet('CREATION_DATE')));
            $this->setRegistryExpiryDate($this->getDateTime($this->ifSet('REGISTRY_EXPIRY_DATE')));
        }
    }

    private function ifSet($key, $default = null)
    {
        return array_key_exists($key, $this->data) ? $this->data[$key] : $default;
    }

    private function getDateTime($val)
    {
        if (!$val) {
            return false;
        }

        if (!empty($val) && $date = date_create_from_format("Y-m-d\TH:i:s\Z", $val)) {
            return $date;
        }

        return false;
    }

    public function getDomainName()
    {
        return $this->domainName;
    }

    public function setDomainName($domainName)
    {
        $this->domainName = $domainName;

        return $this;
    }

    public function getRegistryExpiryDate()
    {
        return $this->registryExpiryDate;
    }

    public function setRegistryExpiryDate(\DateTime $registryExpiryDate)
    {
        $this->registryExpiryDate = $registryExpiryDate;

        return $this;
    }

    public function getUpdatedDate()
    {
        return $this->updatedDate;
    }

    public function setUpdatedDate(\DateTime $updatedDate)
    {
        $this->updatedDate = $updatedDate;

        return $this;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTime $creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getNameServer()
    {
        return $this->nameServer;
    }

    public function setNameServer($nameServer)
    {
        $this->nameServer = $nameServer;

        return $this;
    }

    /**
     * @return null
     */
    public function getWhoisRawText()
    {
        return $this->whoisRawText;
    }

    /**
     * @param null $whoisRawText
     */
    public function setWhoisRawText($whoisRawText)
    {
        $this->whoisRawText = $whoisRawText;
    }


}
