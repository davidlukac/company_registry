<?php

use davidlukac\company_registry\dependency_injection\Container;
use davidlukac\company_registry\models\CompanyInfo;
use davidlukac\company_registry\services\CompanyRepository;
use Silex\Provider\MonologServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

require_once __DIR__ . '/../vendor/autoload.php';

$api_v1 = '/api/v1';

$app = new Silex\Application();
$app['container_extra'] = new Container(__DIR__, $app);

/**
 * -----------------------------------------------------------------------------
 * @Route("/api/v1/ico/exists/{id}")
 * -----------------------------------------------------------------------------
 */
$app->get("${api_v1}/ico/exists/{id}", function ($id) use ($app) {
    /* @var CompanyInfo $result */
    $result = new stdClass();

    try {
        $repository = new CompanyRepository($app['monolog']);
        $result = $repository->exists($id);
    } catch (ServiceUnavailableHttpException $e) {
        $app->abort(404, $e->getMessage());
    }

    return $app->json($result->toPlainStdClass());
});

/**
 * -----------------------------------------------------------------------------
 * @Route("/api/v1/companies")
 * -----------------------------------------------------------------------------
 */
$app->get("${api_v1}/companies", function () use ($app) {
    $result = new stdClass();

    try {
        $repository = new CompanyRepository($app['monolog']);
        $repository->getAll();
    } catch (ServiceUnavailableHttpException $e) {
        $app->abort(404, $e->getMessage());
    }

    return $app->json([]);
});

/**
 * -----------------------------------------------------------------------------
 * @Route("/api/v1/companies/{id}")
 * -----------------------------------------------------------------------------
 */
$app->get("${api_v1}/companies/{id}", function ($id) use ($app) {
    /* @var CompanyInfo $result */
    $result = new stdClass();

    try {
        $repository = new CompanyRepository($app['monolog']);
        $result = $repository->findById($id);
    } catch (NotFoundHttpException $e) {
        $app->abort(404, $e->getMessage());
    }

    return $app->json($result->toPlainStdClass());
});

/**
 * -----------------------------------------------------------------------------
 * @Route("/")
 * -----------------------------------------------------------------------------
 */
$app->get("/", function () use ($app) {
    $text = "Welcome to unofficial Slovak Company registry API. For usage documentation see ... .";
    return new Response($text);
});

$app->run();


