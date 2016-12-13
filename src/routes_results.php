<?php // apiResultsDoctrine - src/routes_results.php

// TODO

use Swagger\Annotations as SWG;

/**
 * @var \Slim\App $app
 */
$app->get(
    '/results',
    function ($request, $response, $args) {
        $this->logger->info('GET \'/results\'');
        $results = getEntityManager()
            ->getRepository('MiW16\Results\Entity\Result')
            ->findAll();

        if (empty($results)) { // 404 - User object not found
            $newResponse = $response->withStatus(404);
            $datos = array(
                'code' => 404,
                'message' => 'Result object not found'
            );
            return $this->renderer->render($newResponse, 'message.phtml', $datos);
        }

        return $response->withJson(array('results' => $results));
    }
)->setName('miw_cget_results');

/**
 * @var \Slim\App $app
 */
$app->get(
    '/results/{id:[0-9]+}',
    function ($request, $response, $args) {
        $this->logger->info('GET \'/results/' . $args['id'] . '\'');
        $this->logger->info('GET \'/results/' . $args['id'] . '\' : id = ' . $args['id']);
        $result = getEntityManager()
            ->getRepository('MiW16\Results\Entity\Result')
            ->findOneById($args['id']);

        if (empty($result)) {  // 404 - User id. not found
            $newResponse = $response->withStatus(404);
            $datos = array(
                'code' => 404,
                'message' => 'Result not found'
            );
            return $this->renderer->render($newResponse, 'message.phtml', $datos);
        }

        return $response->withJson($result);
    }
)->setName('miw_get_results');


/**
 * @var \Slim\App $app
 */
$app->delete(
    '/results/{id:[0-9]+}',
    function ($request, $response, $args) {
        $this->logger->info('DELETE \'/results/' . $args['id'] . '\'');
        $this->logger->info('DELETE \'/results/' . $args['id'] . '\' : id = ' . $args['id']);
        $em = getEntityManager();
        $result = $em
            ->getRepository('MiW16\Results\Entity\Result')
            ->findOneById($args['id']);
        if (empty($result)) {  // 404 - User id. not found
            $newResponse = $response->withStatus(404);
            $datos = array(
                'code' => 404,
                'message' => 'User not found'
            );
            return $this->renderer->render($newResponse, 'message.phtml', $datos);
        } else {
            $em->remove($result);
            $em->flush();
        }

        return $response->withStatus(204);
    }
)->setName('miw_delete_results');


/**
 * @var \Slim\App $app
 */
$app->options(
    '/results',
    function ($request, $response, $args) {
        $this->logger->info('OPTIONS \'/results\'');

        return $response
            ->withHeader(
                'Allow',
                'OPTIONS, GET, POST, PUT, DELETE'
            );
    }
)->setName('miw_options_results');

/**
 * @var \Slim\App $app
 */
$app->post(
    '/results',
    function ($request, $response, $args) {
        $this->logger->info('POST \'/results\'');
        $data = json_decode($request->getBody(), true); // parse the JSON into an assoc. array
        ob_start();
        var_dump($data);
        $dataDump = ob_end_clean();
        $this->logger->info('POST \'/results\' : data = ' . $dataDump);
        // process $data...

        // TODO
        $newResponse = $response->withStatus(501);
        return $newResponse;
    }
)->setName('miw_post_results');

/**
 * @var \Slim\App $app
 */
$app->put(
    '/results/{id:[0-9]+}',
    function ($request, $response, $args) {
        $this->logger->info('PUT \'/results\'');
        $this->logger->info('PUT \'/results/' . $args['id'] . '\' : id = ' . $args['id']);
        $data = json_decode($request->getBody(), true); // parse the JSON into an assoc. array
        ob_start();
        var_dump($data);
        $dataDump = ob_end_clean();
        $this->logger->info('PUT \'/results\' : data = ' . $dataDump);
        // process $data...

        // TODO
        $newResponse = $response->withStatus(501);
        return $newResponse;
    }
)->setName('miw_post_results');

