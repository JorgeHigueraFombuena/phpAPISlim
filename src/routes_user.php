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
        $this->logger->info('GET \'/users/' . $args['id'] . '\' : id = ' . $args['id']);
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

        $result = getEntityManager()
            ->getRepository('MiW16\Results\Entity\Result')
            ->findOneBy(array("user" => $args['id']));
        if (!empty($result)) {
            $newResponse = $response->withStatus(403);
            $datos = array(
                'code' => 403,
                'message' => 'User has result. The result must be deleted before'
            );
            return $this->renderer->render($newResponse, 'message.phtml', $datos);
        } else if (empty($usuario)) {  // 404 - User id. not found
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

        $em = getEntityManager();
        if (!isset($data['username']) || empty($data['username'])
            || !isset($data['email']) || empty($data['email'])
            || !isset($data['password']) || empty($data['password'])
        ) {
            $newResponse = $response->withStatus(422);
            $datos = array(
                'code' => 422,
                'message' => '`Unprocessable entity` Username, e-mail or password is left out'
            );
            return $this->renderer->render($newResponse, 'message.phtml', $datos);
        } else if (strpos($data['email'], '@') === false) {
            $newResponse = $response->withStatus(400);
            $datos = array(
                'code' => 400,
                'message' => '`Bad Request` Need a good formed email.'
            );
            return $this->renderer->render($newResponse, 'message.phtml', $datos);
        } else {
            $usuarioUsername = $em
                ->getRepository('MiW16\Results\Entity\User')
                ->findOneBy(array('username' => $data['username']));
            $usuarioEmail = $em
                ->getRepository('MiW16\Results\Entity\User')
                ->findOneBy(array('email' => $data['email']));

            if (!empty($usuarioEmail)
                || !empty($usuarioUsername)
            ) {
                $newResponse = $response->withStatus(422);
                $datos = array(
                    'code' => 400,
                    'message' => '`Bad Request` Username or email already exists.'
                );
                return $this->renderer->render($newResponse, 'message.phtml', $datos);
            }

        }

        /** @var \MiW16\Results\Entity\User $usuario */
        $usuario = new \MiW16\Results\Entity\User();
        $usuario->setUsername($data['username']);
        $usuario->setEmail($data['email']);
        $usuario->setPassword($data['password']);
        $em->persist($usuario);
        $em->flush();
        $newResponse = $response->withStatus(201);
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
        $this->logger->info('PUT \'/users/' . $args['id'] . '\' : id = ' . $args['id']);
        $data = json_decode($request->getBody(), true); // parse the JSON into an assoc. array
        $em = getEntityManager();
        /** @var \MiW16\Results\Entity\User $usuario */
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
        } else if (!isset($data['username']) || empty($data['username'])
            || !isset($data['email']) || empty($data['email'])
            || !isset($data['password']) || empty($data['password'])
            || !isset($data['enabled']) || empty($data['enabled'])
            || !isset($data['last_login']) || empty($data['last_login'])
        ) {
            $newResponse = $response->withStatus(422);
            $datos = array(
                'code' => 422,
                'message' => '`Unprocessable entity` Some required data is missing'
            );
            return $this->renderer->render($newResponse, 'message.phtml', $datos);
        } else if (strpos($data['email'], '@') === false) {
            $newResponse = $response->withStatus(400);
            $datos = array(
                'code' => 400,
                'message' => '`Bad Request` Need a good formed email.'
            );
            return $this->renderer->render($newResponse, 'message.phtml', $datos);
        } else {
            $usuarioUsername = $em
                ->getRepository('MiW16\Results\Entity\User')
                ->findOneBy(array('username' => $data['username']));
            $usuarioEmail = $em
                ->getRepository('MiW16\Results\Entity\User')
                ->findOneBy(array('email' => $data['email']));

            if (!empty($usuarioEmail)
                || !empty($usuarioUsername)
            ) {
                $newResponse = $response->withStatus(422);
                $datos = array(
                    'code' => 400,
                    'message' => '`Bad Request` Username or email already exists.'
                );
                return $this->renderer->render($newResponse, 'message.phtml', $datos);
            }

        }
        $usuario->setUsername($data['username']);
        $usuario->setEnabled($data['enabled'] === 'true');
        $usuario->setPassword($data['password']);
        $usuario->setEmail($data['email']);
        $usuario->setToken($data['token']);
        $usuario->setLastLogin(new DateTime($data['last_login']));
        $em->persist($usuario);
        $em->flush();

        $newResponse = $response->withStatus(200);
        return $newResponse;
    }
)->setName('miw_post_users');

