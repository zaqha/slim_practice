<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class SessionMiddleware implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
            session_start();
            $_SESSION['user_id'] = '20200003';
            $_SESSION['system_config']['DepartmentImportApiUrl'] = 'http://localhost/RAILS_import_test_api/department.php';
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $request = $request->withAttribute('session', $_SESSION);
        }

        return $handler->handle($request);
    }
}
