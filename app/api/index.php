<!-- <?php
// use Psr\Http\Message\ResponseInterface as Response;
// use Psr\Http\Message\ServerRequestInterface as Request;
// use Slim\Factory\AppFactory;


// require __DIR__ . '/vendor/autoload.php';

// $app = AppFactory::create();

// $app->get('/ping', function (Request $request, Response $response, $args) {
//     $response->getBody()->write("pong");
//     return $response;
// });
// $app->addBodyParsingMiddleware();

// // login @body.username, @body.password -> return jason @message, @user_id
// $app->post('/login', function (Request $request, Response $response, $args) {
//   $data = $request->getParsedBody();

//   $user = $data['user'] ?? '';
//   $contra = $data['contra'] ?? '';
//     if (!empty($user) && !empty($contra)){
//       trim($user);
//       trim($contra);
//       $controller = new App\Controllers\SeguridadControlador($user, $contra);
//       $res = $controller->login();
//       if ($res) {
//         $response->getBody()->write(json_encode(["message" => "Login successful", "user_id" => $res]));
//     } else {
//         $response->getBody()->write(json_encode(["message" => "Invalid credentials"]));
//         return $response->withStatus(401);  // Código de error 401 para credenciales no válidas
//     }
//   } else {
//     // Si falta alguno de los datos (usuario o contraseña)
//     $response->getBody()->write(json_encode(["message" => $data['user']]));
//     return $response->withStatus(400);  // Código de error 400 para solicitud incorrecta
// }
//     return $response->withHeader('Content-Type', 'application/json');
    
// }
//  );


// $app->run(); -->