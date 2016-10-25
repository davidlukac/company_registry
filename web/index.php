<?php

use davidlukac\company_registry\models\CompanyInfo;
use davidlukac\company_registry\services\CompanyRepository;
use Silex\Provider\MonologServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

require_once __DIR__ . '/../vendor/autoload.php';

$api_v1 = '/api/v1';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new MonologServiceProvider(), [
    'monolog.logfile' => __DIR__ . '/../log/development.log',
]);

$app->get("${api_v1}/ico/exists/{id}", function ($id) use ($app) {
    /* @var CompanyInfo $result */
    $result = new stdClass();

    try {
        $orsrRepository = new CompanyRepository($app['monolog']);
        $result = $orsrRepository->exists($id);
    } catch (ServiceUnavailableHttpException $e) {
        $app->abort(404, $e->getMessage());
    }

    return $app->json($result->toPlainStdClass());
});

$app->get("${api_v1}/companies", function () use ($app) {
    $result = new stdClass();

    try {
        $orsrRepository = new CompanyRepository($app['monolog']);
        $orsrRepository->getAll();
    } catch (ServiceUnavailableHttpException $e) {
        $app->abort(404, $e->getMessage());
    }

    return $app->json([]);
});

$app->get("${api_v1}/companies/{id}", function ($id) use ($app) {
    /* @var CompanyInfo $result */
    $result = new stdClass();

    try {
        $orsrRepository = new CompanyRepository($app['monolog']);
        $result = $orsrRepository->findById($id);
    } catch (ServiceUnavailableHttpException $e) {
        $app->abort(404, $e->getMessage());
    }

    return $app->json($result->toPlainStdClass());
});

$app->get("/", function () use ($app) {
    $text = "Welcome to unofficial Slovak Company registry API. For usage documentation see ... .";
    return new Response($text);
});

$app->run();
