<?php //declare(strict_types=1);

namespace App\Http\Controller;

use App\Rpc\Lib\UserInterface;
use Swoft\Context\Context;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;

/**
 * @Controller()
 */
class UserController
{

    /**
     * @Reference(pool="user.pool")
     * @var UserInterface
     */
    private $_userService;


    /**
     * 用户信息
     *
     * @RequestMapping("/api/user/info", method={RequestMethod::GET})
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
     * 更新用户
     *
     * @RequestMapping("/api/user", method={RequestMethod::POST})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function update()
    {
        $post = Context::mustGet()->getRequest()->post();
        $post['user_id'] = getUserId();

        $data = $this->_userService->update($post);

        return response($data['data'], $data['code']);
    }

    /**
     * 团队列表
     *
     * @RequestMapping("/api/user/team", method={RequestMethod::GET})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function team()
    {
        $userId = getUserId();
        $level = Context::mustGet()->getRequest()->query('level', 1);
        $page = Context::mustGet()->getRequest()->query('page', 1);

        $data =$this->_userService->teamList($userId, $level, $page);
        return response($data['data'], $data['code']);
    }

    /**
     * 团队人数统计
     *
     * @RequestMapping("/api/user/teamCount", method={RequestMethod::GET})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function teamCount()
    {
        $userId = getUserId();

        $data =$this->_userService->teamCount($userId);
        return response($data['data'], $data['code']);
    }

}
