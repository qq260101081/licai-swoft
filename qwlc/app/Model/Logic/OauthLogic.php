<?php declare(strict_types=1);


namespace App\Model\Logic;


use App\Model\Dao\UserDao;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * Class OauthLogic
 * @package App\Model\Logic
 * @Bean()
 */
class OauthLogic
{
    /**
     * 注入UserDao类
     *
     * @Inject()
     * @var UserDao
     */
    private $_dao;

    /**
     * 登录
     *
     * @param $username
     * @param $password
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function login($username, $password)
    {
        $nowTime = time();

        $user = $this->_dao->getOneByUsername($username);
        // 判断用户存在 和 密码是否正确
        if (!$user || !password_verify($password, $user['password']))
        {
             return ['data' => [], 'code' => '30003'];
        }

        // 访问接口的token
        $accessTokenArr = [
            'iss' => env('JWT_ISSUER'), //签发者 可选
            'aud' => env('JWT_AUDIENCE'), //接收该JWT的一方，可选
            'iat' => $nowTime, //签发时间
            'nbf' => $nowTime , //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
            'exp' => $nowTime + env('JWT_ACCESS_EXP'), //过期时间,这里设置2个小时
            'scopes' => 'role_access', //token标识，请求接口的token
            'data' => [ //自定义信息，不要定义敏感信息
                'user_id' => $user['user_id']
            ]
        ];

        // 刷新访问用的token
        $refreshTokenArr = [
            'iss' => env('JWT_ISSUER'), //签发者 可选
            'aud' => env('JWT_AUDIENCE'), //接收该JWT的一方，可选
            'iat' => $nowTime, //签发时间
            'nbf' => $nowTime , //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
            'exp' => $nowTime + env('JWT_LOGIN_EXP'), //过期时间,这里设置2个小时
            'scopes' => 'role_refresh', //token标识，刷新access_token
            'data' => [ //自定义信息，不要定义敏感信息
                'user_id' => $user['user_id']
            ]
        ];

        $accessToken = JWT::encode($accessTokenArr, env('JWT_KEY'), env('JWT_ALG'));

        // 更新登录时间
        $this->_dao->editOne($user['user_id'], ['last_login_time' => time()]);

        return ['data' => [
            'access_token' => $accessToken,
            'refresh_token' => JWT::encode($refreshTokenArr, env('JWT_KEY'), env('JWT_ALG'))
        ], 'code' => 0];
    }

    /**
     * 刷新access_token
     *
     * @param $access_token
     * @param $refresh_token
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function refreshToken($access_token, $refresh_token)
    {
        if (!$access_token)
        {
            return ['data' => [], 'code' => '30007'];
        }
        if (!$refresh_token)
        {
            return ['data' => [], 'code' => '30008'];
        }

        // 验证access_token
        try{
            JWT::$leeway = 60; // 当前时间减去60，把时间留点余地
            $decoded = JWT::decode($access_token, env('JWT_KEY'), [env('JWT_ALG')]);

            // 如果没过期直接返回，减少服务器压力
            return [
                'data'=>[
                    'access_token' => $access_token,
                    'refresh_token' => $refresh_token,
                ], 'code' => 0
            ];

        }catch (SignatureInvalidException $e){ // 签名不正确

            return ['data' => [], 'code' => '30004'];

        } catch (BeforeValidException $e) { // 签名在某个时间点之后才能用

            return ['data' => [], 'code' => '30006'];

        }catch (ExpiredException $e){ // token过期

            // 验证refresh_token
            try{

                $decoded = JWT::decode($refresh_token, env('JWT_KEY'), [env('JWT_ALG')]);
                $decoded = (array)$decoded;

                // 刷新 access_token
                $nowTime = time();
                $accessToken = [
                    'iss' => env('JWT_ISSUER'), //签发者 可选
                    'aud' => env('JWT_AUDIENCE'), //接收该JWT的一方，可选
                    'iat' => $nowTime, //签发时间
                    'nbf' => $nowTime , //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
                    'exp' => $nowTime + env('JWT_ACCESS_EXP'), //过期时间,这里设置2个小时
                    'scopes' => 'role_access', //token标识，请求接口的token
                    'data' => [ //自定义信息，不要定义敏感信息
                        'user_id' => $decoded['data']->user_id
                    ]
                ];

                return [
                    'data'=>[
                        'access_token' => JWT::encode($accessToken, env('JWT_KEY'), env('JWT_ALG')),
                        'refresh_token' => $refresh_token,
                    ],
                    'code' => 0
                ];

            }catch (SignatureInvalidException $e){ // 签名不正确

                return ['data' => [], 'code' => '30004'];

            } catch (BeforeValidException $e) { // 签名在某个时间点之后才能用

                return ['data' => [], 'code' => '30006'];

            }catch (ExpiredException $e){ // token过期

                return ['data' => [], 'code' => '2']; // 如果 refresh_token过期拒绝刷新，请重新登录

            }

        }
    }

}