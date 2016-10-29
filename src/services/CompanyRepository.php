<?php

namespace davidlukac\company_registry\services;

use Behat\Mink\Driver\GoutteDriver;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Session;
use davidlukac\company_registry\models\CompanyInfo;
use DusanKasan\Knapsack\Collection;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

/**
 * Class CompanyRepository.
 *
 * @package davidlukac\company_registry\services
 */
class CompanyRepository
{
    const BASE_URL = "http://orsr.sk";

    protected $searchUrl = self::BASE_URL . "/hladaj_ico.asp";
    protected $detailUrl = self::BASE_URL . "/vypis.asp";

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
     * Find and return company information by ID (ICO).
     *
     * @param Int $companyId
     *
     * @return CompanyInfo
     */
    public function findById($companyId)
    {
        $driver = new GoutteDriver();
        $session = new Session($driver);
        $session->start();

        $url = $this->searchUrl . "?ICO=${companyId}}&SID=0";
        $session->visit($url);
        $page = $session->getPage();

        $resultRows = Collection::from($page->findAll("xpath", "//tr[td/div[@class='sbj']]"));

        if ($resultRows->isEmpty()) {
            // Handle "not-found".
            throw new NotFoundHttpException("Company with ID ${companyId} was not found.");
        } elseif ($resultRows->size() > 1) {
            // Handle too many results.
            throw new NotFoundHttpException("Unambiguous company ID: ${companyId}!");
        } else {
            /* @var NodeElement $result */
            $result = $resultRows->first();
        }

        /* @var NodeElement $linkElement */
        $linkElement = $result->findLink("Aktuálny");
        $companyName = $result->find('css', '.sbj')->getText();

        $linkElement->click();

        $detailPage = $session->getPage();
        $address = $detailPage->find('xpath', "//tr[td/span[contains(text(),\"Sídlo\")]]/td[2]//td[1]")->getText();

        $company = new CompanyInfo();
        $company->setCompanyId($companyId);
        $company->setName($companyName);
        if ($result) {
            $company->setExists(true);
        } else {
            $company->setExists(false);
        }
        $company->setAddress($address);

        $this->log->debug(\GuzzleHttp\json_encode($company));

        return $company;
    }

    /**
     * Confirm whether company exists
     *
     * @param Int $companyId Company ID.
     *
     * @return CompanyInfo True if company was found, false othewise.
     */
    public function exists($companyId)
    {
        $driver = new GoutteDriver();
        $session = new Session($driver);
        $session->start();

        $url = $this->searchUrl . "?ICO=${companyId}}&SID=0";
        $session->visit($url);
        $page = $session->getPage();

        $resultSet = Collection::from($page->findAll("css", "div.bmk"));

        /* @var NodeElement $result */
        $result = $resultSet->getOrDefault(0, null);

        $company = new CompanyInfo();
        $company->setCompanyId($companyId);
        if ($result) {
            $company->setExists(true);
        } else {
            $company->setExists(false);
        }

        $this->log->debug(\GuzzleHttp\json_encode($company));

        return $company;
    }

    /**
     * @todo Implement.
     */
    public function getAll()
    {
        throw new ServiceUnavailableHttpException("Not implemented");
    }
}
