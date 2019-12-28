<?php declare(strict_types=1);


namespace App\Rpc\Service;


use App\Model\Logic\UserLogic;
use App\Rpc\Lib\UserInterface;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Rpc\Server\Annotation\Mapping\Service;

/**
 * Class UserService
 *
 * @since 2.0
 * @Service()
 */
class UserService implements UserInterface
{
    /**
     * @Inject()
     * @var UserLogic
     */
    private $_logic;

    /**
     * 我的页面
     *
     * @param int $user_id
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function info(int $user_id): array
    {
        return $this->_logic->getInfo($user_id);
    }

    /**
     * 修改信息
     *
     * @param array $data
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function update(array $data): array
    {
        return $this->_logic->userEdit($data);
    }

    /**
     * @param int $user_id
     * @param int $level
     * @param int $page
     * @return array
     */
    public function teamList(int $user_id, int $level, int $page): array
    {
        return $this->_logic->teamList($user_id, $level, $page);
    }
}