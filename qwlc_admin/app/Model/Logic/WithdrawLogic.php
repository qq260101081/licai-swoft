<?php declare(strict_types=1);


namespace App\Model\Logic;


use App\Model\Dao\WithdrawDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * Class WithdrawLogic
 * @package App\Model\Logic
 * @Bean()
 */
class WithdrawLogic
{
    /**
     * 注入ProfitLogic类
     *
     * @Inject()
     * @var WithdrawDao
     */
    private $_dao;

    /**
     * 获取提现列表
     *
     * @param array $search
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getPage(array $search, int $page, int $limit): array
    {
        $where = [];
        if ($search['phone'])
        {
            $where[] = ['b.phone', '=', $search['phone']];
        }
        if ($search['name'])
        {
            $where[] = ['b.name', '=', $search['name']];
        }
        if ('' !== $search['status'])
        {
            $where[] = ['a.status', '=', $search['status']];
        }
        if ($search['create_time'])
        {
            $where[] = ['a.create_time', '>=', strtotime($search['create_time'][0])];
            $where[] = ['a.create_time', '<', strtotime($search['create_time'][1])];
        }

        $result = $this->_dao->getPage($where, $page, $limit);
        return ['data' => $result, 'code' => 0];
    }


    /**
     * 批量更新提现状态为成功
     *
     * @param $withdraw_logs_ids
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function batchSuccess($withdraw_logs_ids)
    {
        if (!$withdraw_logs_ids)
        {
            return ['data' => [], 'code' => 1];
        }
        $withdraw_logs_ids = explode(',', $withdraw_logs_ids);
        $result = $this->_dao->batchSuccess($withdraw_logs_ids);

        if (!$result)
        {
            return ['data' => [], 'code' => 1];
        }

        return ['data' => [], 'code' => 0];
    }

    /**
     * 批量更新提现状态为失败
     *
     * @param $withdraw_logs_ids
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function batchFail($withdraw_logs_ids)
    {
        if (!$withdraw_logs_ids)
        {
            return ['data' => [], 'code' => 1];
        }
        $withdraw_logs_ids = explode(',', $withdraw_logs_ids);
        $result = $this->_dao->batchFail($withdraw_logs_ids);

        if (!$result)
        {
            return ['data' => [], 'code' => 1];
        }

        return ['data' => [], 'code' => 0];
    }

}