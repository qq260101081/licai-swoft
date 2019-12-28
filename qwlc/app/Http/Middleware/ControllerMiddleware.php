<?php declare(strict_types=1);


namespace App\Http\Middleware;

use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Http\Server\Contract\MiddlewareInterface;

/**
 * @Bean()
 * Class ControllerMiddleware
 * @package App\Http\Middleware
 */
class ControllerMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // 不参与授权接口
        $allow = [
            '/api/oauth/login',
            '/api/oauth/logout',
            '/api/oauth/refreshToken',
        ];

        $route = $request->getUri()->getPath();

        if (!in_array($route, $allow))
        {
            $accessToken = $request->getHeaderLine("access-token");
            if (empty($accessToken))
            {
                 return response([], 30007);
            }

            try{
                JWT::$leeway = 60; // 当前时间减去60，把时间留点余地
                $decoded = JWT::decode($accessToken, env('JWT_KEY'), [env('JWT_ALG')]);
                $arr = (array)$decoded;

            }catch (SignatureInvalidException $e){ // 签名不正确

                return response([], 30004);

            } catch (BeforeValidException $e) { // 签名在某个时间点之后才能用

                return response([], 30006);

            }catch (ExpiredException $e){ // token过期

                return response([], 30005);

            }

        }

        $response = $handler->handle($request);
        return $response;
    }
}
