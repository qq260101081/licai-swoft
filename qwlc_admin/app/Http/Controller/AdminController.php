<?php //declare(strict_types=1);

namespace App\Http\Controller;

use App\Model\Logic\AdminLogic;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Context\Context;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;

/**
 * @Controller("/admin")
 */
class AdminController
{
    /**
     * 注入UserLogi逻辑层
     *
     * @Inject()
     * @var AdminLogic
     */
    private $_logic;

    /**
     * 用户列表
     *
     * @RequestMapping(method={RequestMethod::GET})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function index()
    {
        $page = Context::get()->getRequest()->query('page', 1);
        $data = $this->_logic->getUserList($page);

        return response($data['data']);
    }

    /**
     * 用户信息
     *
     * @RequestMapping("info", method={RequestMethod::GET})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function view()
    {
        $adminId = getAdminId();
        $data = $this->_logic->getInfo($adminId);

        return response($data['data'], $data['code']);
    }

    /**
     * 更新用户
     *
     * @RequestMapping(method={RequestMethod::POST})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function update()
    {
        $post = Context::get()->getRequest()->post();
        $data = $this->_logic->userEdit($post);

        return response($data['data'], $data['code']);
    }

    /**
     * 创建用户
     *
     * @RequestMapping(method={RequestMethod::POST})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function create()
    {
        $post = Context::get()->getRequest()->post();
        $data = $this->_logic->userCreate($post);

        return response($data['data'], $data['code']);
    }

}
