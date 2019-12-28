<?php //declare(strict_types=1);

namespace App\Http\Controller;

use App\Model\Logic\UserLogic;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Context\Context;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;

/**
 * @Controller()
 */
class UserController
{

    /**
     * @Inject()
     * @var UserLogic
     */
    private $_logic;

    /**
     * 用户列表
     *
     * @RequestMapping("/user", method={RequestMethod::GET})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function index()
    {
        $page       = Context::get()->getRequest()->query('page', 1);
        $limit      = Context::get()->getRequest()->query('limit', 10);
        $search = [
            'phone'      => Context::get()->getRequest()->query('phone', ''),
            'name'       => Context::get()->getRequest()->query('name', ''),
            'status'     => Context::get()->getRequest()->query('status', ''),
            'create_time' => Context::get()->getRequest()->query('create_time', '')
        ];

        $data = $this->_logic->getUserList($search, $page, $limit);

        return response($data['data']);
    }

    /**
     * 用户信息
     *
     * @RequestMapping("/user/info", method={RequestMethod::GET})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function view()
    {
        $user_id = getUserId();

        $data = $this->_userService->info($user_id);

        return response($data['data'], $data['code']);
    }

    /**
     * 批量更新用户状态
     *
     * @RequestMapping("/user/changeStatus", method={RequestMethod::PUT})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function changeStatus()
    {
        $status = Context::get()->getRequest()->post('status', 0);
        $userIds = Context::get()->getRequest()->post('ids', '');
        $data = $this->_logic->changeStatus($status, $userIds);

        return response($data['data'], $data['code']);
    }

    /**
     * 更新用户
     *
     * @RequestMapping("/user/{user_id}", method={RequestMethod::PUT})
     * @param $user_id
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function update(int $user_id)
    {
        $post = Context::get()->getRequest()->post();
        $data = $this->_logic->update($user_id, $post);

        return response($data['data'], $data['code']);
    }

    /**
     * 用户加钱
     *
     * @RequestMapping("/user/plus/{user_id}", method={RequestMethod::PUT})
     * @param $user_id
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function plus(int $user_id)
    {
        $amount = (int)Context::get()->getRequest()->post('amount', '');
        $data = $this->_logic->plus($user_id, $amount);

        return response($data['data'], $data['code']);
    }

    /**
     * 用户减钱
     *
     * @RequestMapping("/user/cut/{user_id}", method={RequestMethod::PUT})
     * @param $user_id
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function cut(int $user_id)
    {
        $amount = (int)Context::get()->getRequest()->post('amount', '');
        $data = $this->_logic->cut($user_id, $amount);

        return response($data['data'], $data['code']);
    }


    /**
     * 创建用户
     *
     * @RequestMapping("/user", method={RequestMethod::POST})
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

    /**
     * @RequestMapping("/user/team", method={RequestMethod::GET})
     *
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function team()
    {
        $userId = getUserId();
        $level = Context::get()->getRequest()->query('level', 1);
        $page = Context::get()->getRequest()->query('page', 1);

        $data =$this->_userService->teamList($userId, $level, $page);
        return response($data['data'], $data['code']);
    }


}
