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
 * Summary: Creates a new user
 * Notes: Creates a new user
 *
 * @SWG\Post(
 *     method      = "POST",
 *     path        = "/users",
 *     tags        = { "Users" },
 *     summary     = "Creates a new user",
 *     description = "Creates a new user",
 *     operationId = "miw_post_users",
 *     parameters  = {
 *          {
 *          "name":        "data",
 *          "in":          "body",
 *          "description": "`User` properties to add to the system",
 *          "required":    true,
 *          "schema":      { "$ref": "#/definitions/UserData" }
 *          }
 *     },
 *     @SWG\Response(
 *          response    = 201,
 *          description = "`Created` User created",
 *          schema      = { "$ref": "#/definitions/User" }
 *     ),
 *     @SWG\Response(
 *          response    = 400,
 *          description = "`Bad Request` Username or email already exists.",
 *          schema      = { "$ref": "#/definitions/Message" }
 *     ),
 *     @SWG\Response(
 *          response    = 422,
 *          description = "`Unprocessable entity` Username, e-mail or password is left out",
 *          schema      = { "$ref": "#/definitions/Message" }
 *     )
 * )
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
 * Summary: Updates a user
 * Notes: Updates the user identified by &#x60;userId&#x60;.
 *
 * @SWG\Put(
 *     method      = "PUT",
 *     path        = "/users/{userId}",
 *     tags        = { "Users" },
 *     summary     = "Updates a user",
 *     description = "Updates the user identified by `userId`.",
 *     operationId = "miw_put_users",
 *     parameters={
 *          { "$ref" = "#/parameters/userId" },
 *          {
 *          "name":        "data",
 *          "in":          "body",
 *          "description": "`User` data to update",
 *          "required":    true,
 *          "schema":      { "$ref": "#/definitions/UserData" }
 *          }
 *     },
 *     @SWG\Response(
 *          response    = 200,
 *          description = "`Ok` User previously existed and is now updated",
 *          schema      = { "$ref": "#/definitions/User" }
 *     ),
 *     @SWG\Response(
 *          response    = 400,
 *          description = "`Bad Request` User name or e-mail already exists",
 *          schema      = { "$ref": "#/definitions/Message" }
 *     ),
 *     @SWG\Response(
 *          response    = 404,
 *          description = "`Not Found` The user could not be found",
 *          schema      = { "$ref": "#/definitions/Message" }
 *     )
 * )
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

