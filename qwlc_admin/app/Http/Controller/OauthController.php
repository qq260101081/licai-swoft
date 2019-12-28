<?php //declare(strict_types=1);

namespace App\Http\Controller;

use App\Model\Logic\OauthLogic;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Context\Context;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;

/**
 * @Controller("/oauth")
 */
class OauthController
{
    /**
     * 注入Oauth逻辑层
     *
     * @Inject()
     * @var OauthLogic
     */
    private $_logic;


    /**
     * 登录
     *
     * @RequestMapping(method={RequestMethod::POST})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function login()
    {
        $username = Context::get()->getRequest()->post('username', '');
        $password = Context::get()->getRequest()->post('password', '');

        $data = $this->_logic->login($username, $password);

        return response($data['data'], $data['code']);
    }

    /**
     * 刷新access_token
     *
     * @RequestMapping(method={RequestMethod::POST})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function refreshToken()
    {
        $refreshToken = Context::get()->getRequest()->post('refresh_token', '');

        $data = $this->_logic->refreshToken($refreshToken);

        return response($data['data'], $data['code']);
    }

    /**
     * 退出登录
     *
     * @RequestMapping(method={RequestMethod::POST})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function logout()
    {
        return response([], 0);
    }

}
