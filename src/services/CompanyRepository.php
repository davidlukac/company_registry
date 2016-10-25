<?php

namespace davidlukac\company_registry\services;

use Behat\Mink\Driver\GoutteDriver;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Session;
use davidlukac\company_registry\models\CompanyInfo;
use DusanKasan\Knapsack\Collection;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

/**
 * Class CompanyRepository.
 *
 * @package davidlukac\company_registry\services
 */
class CompanyRepository
{
    const BASE_URL = "http://orsr.sk";
    private $searchUrl = self::BASE_URL . "/hladaj_ico.asp";
    private $detailUrl = self::BASE_URL . "/vypis.asp";
    /* @var LoggerInterface $og */
    private $log;

    /**
     * CompanyRepository constructor.
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->log = $logger;
    }

    /**
     * @param Int $id
     *
     * @return CompanyInfo
     */
    public function findById($id)
    {
        $driver = new GoutteDriver();
        $session = new Session($driver);
        $session->start();

        $url = $this->searchUrl . "?ICO=${id}}&SID=0";
        $session->visit($url);
        $page = $session->getPage();

        $resultSet = Collection::from($page->findAll("css", "div.bmk"));

        /* @var NodeElement $result */
        $result = $resultSet->getOrDefault(0, null);

        $company = new CompanyInfo();
        $company->setId($id);
        if ($result) {
            $company->setExists(true);
        } else {
            $company->setExists(false);
        }

        $this->log->debug(\GuzzleHttp\json_encode($company));

        return $company;
    }

    /**
     * Confirm whether company exists
     *
     * @param Int $id Company ID.
     *
     * @return CompanyInfo True if company was found, false othewise.
     */
    public function exists($id)
    {
        $driver = new GoutteDriver();
        $session = new Session($driver);
        $session->start();

        $url = $this->searchUrl . "?ICO=${id}}&SID=0";
        $session->visit($url);
        $page = $session->getPage();

        $resultSet = Collection::from($page->findAll("css", "div.bmk"));

        /* @var NodeElement $result */
        $result = $resultSet->getOrDefault(0, null);

        $company = new CompanyInfo();
        $company->setId($id);
        if ($result) {
            $company->setExists(true);
        } else {
            $company->setExists(false);
        }

        $this->log->debug(\GuzzleHttp\json_encode($company));

        return $company;
    }

    public function getAll()
    {
        throw new ServiceUnavailableHttpException("Not implemented");
    }
}
