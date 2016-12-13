<?php // src/routes_user.php

use Swagger\Annotations as SWG;

/**
 * @var \Slim\App $app
 */
$app->get(
    '/users',
    function ($request, $response, $args) {
        $this->logger->info('GET \'/users\'');
        $usuarios = getEntityManager()
            ->getRepository('MiW16\Results\Entity\User')
            ->findAll();

        if (empty($usuarios)) { // 404 - User object not found
            $newResponse = $response->withStatus(404);
            $datos = array(
                'code' => 404,
                'message' => 'User object not found'
            );
            return $this->renderer->render($newResponse, 'message.phtml', $datos);
        }

        return $response->withJson(array('users' => $usuarios));
    }
)->setName('miw_cget_users');

/**
 * @var \Slim\App $app
 */
$app->get(
    '/users/{id:[0-9]+}',
    function ($request, $response, $args) {
        $this->logger->info('GET \'/users/' . $args['id'] . '\'');
        $usuario = getEntityManager()
            ->getRepository('MiW16\Results\Entity\User')
            ->findOneById($args['id']);

        if (empty($usuario)) {  // 404 - User id. not found
            $newResponse = $response->withStatus(404);
            $datos = array(
                'code' => 404,
                'message' => 'User not found'
            );
            return $this->renderer->render($newResponse, 'message.phtml', $datos);
        }

        return $response->withJson($usuario);
    }
)->setName('miw_get_users');

/**
 * @var \Slim\App $app
 */
$app->delete(
    '/users/{id:[0-9]+}',
    function ($request, $response, $args) {
        $this->logger->info('DELETE \'/users/' . $args['id'] . '\'');
        $em = getEntityManager();
        $usuario = $em
            ->getRepository('MiW16\Results\Entity\User')
            ->findOneById($args['id']);
        if (empty($usuario)) {  // 404 - User id. not found
            $newResponse = $response->withStatus(404);
            $datos = array(
                'code' => 404,
                'message' => 'User not found'
            );
            return $this->renderer->render($newResponse, 'message.phtml', $datos);
        } else {
            $em->remove($usuario);
            $em->flush();
        }

        return $response->withStatus(204);
    }
)->setName('miw_delete_users');

/**
 * @var \Slim\App $app
 */
$app->options(
    '/users',
    function ($request, $response, $args) {
        $this->logger->info('OPTIONS \'/users\'');

        return $response
            ->withHeader(
                'Allow',
                'OPTIONS, GET, POST, PUT, DELETE'
            );
    }
)->setName('miw_options_users');

/**
 * @var \Slim\App $app
 */
$app->post(
    '/users',
    function ($request, $response, $args) {
        $this->logger->info('POST \'/users\'');
        $data = json_decode($request->getBody(), true); // parse the JSON into an assoc. array
        // process $data...

        // TODO
        $newResponse = $response->withStatus(501);
        return $newResponse;
    }
)->setName('miw_post_users');

/**
 * @var \Slim\App $app
 */
$app->put(
    '/users/{id:[0-9]+}',
    function ($request, $response, $args) {
        $this->logger->info('PUT \'/users\'');
        $data = json_decode($request->getBody(), true); // parse the JSON into an assoc. array
        // process $data...

        // TODO
        $newResponse = $response->withStatus(501);
        return $newResponse;
    }
)->setName('miw_post_users');

