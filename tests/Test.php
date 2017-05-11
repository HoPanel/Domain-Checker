<?php

require __DIR__.'/../vendor/autoload.php';

class Test extends \PHPUnit\Framework\TestCase
{
    public function testDomainCheck()
    {
        $dummyDomains = $this->getTestData();

        $checker = new \Hodc\DomainChecker();
        foreach ($dummyDomains as $item) {
            $domains = $checker->checkDomain($item['domain']);
            $this->assertInstanceOf(\Hodc\Response\CheckerResponse::class, $domains);
            $this->assertTrue($domains->isStatus());

            foreach ($domains as $domain) {
                $this->assertInstanceOf(\Hodc\Response\DomainResponse::class, $domain);
            }
        }
    }

    public function getTestData()
    {
        return [
            [
                'domain' => 'projekod.com',
            ],
        ];
    }
}
