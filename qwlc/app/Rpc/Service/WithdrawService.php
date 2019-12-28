<?php declare(strict_types=1);


namespace App\Rpc\Service;


use App\Model\Logic\WithdrawLogic;
use App\Rpc\Lib\WithdrawInterface;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Rpc\Server\Annotation\Mapping\Service;

/**
 * Class WithdrawService
 *
 * @since 2.0
 * @Service()
 */
class WithdrawService implements WithdrawInterface
{
    /**
     * @Inject()
     * @var WithdrawLogic
     */
    private $_logic;

    /**
     * 用户提现分页列表
     *
     * @param int $user_id
     * @param int $page
     * @return array
     */
    public function pageByUser(int $user_id, int $page): array
    {
        return $this->_logic->getPageByUser($user_id, $page);
    }


    /**
     * @param int $user_id
     * @param $amount
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function create(int $user_id, $amount): array
    {
        return $this->_logic->create($user_id, $amount);
    }
}