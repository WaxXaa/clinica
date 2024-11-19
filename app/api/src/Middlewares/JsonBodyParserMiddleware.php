<?php
namespace App\Middlewares;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class JsonBodyParserMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        $contentType = $request->getHeaderLine('Content-Type'); // Obtén el tipo de contenido

        // Verifica si el tipo de contenido es JSON
        if (strstr($contentType, 'application/json')) {
            $contents = json_decode(file_get_contents('php://input'), true); // Obtén y decodifica el cuerpo
            if (json_last_error() === JSON_ERROR_NONE) {
                $request = $request->withParsedBody($contents); // Almacena el contenido decodificado en el cuerpo de la solicitud
            }
        }

        return $handler->handle($request); // Continúa el manejo de la solicitud
    }
}
