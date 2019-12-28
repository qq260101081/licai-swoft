<?php declare(strict_types=1);


namespace App\Model\Dao;


use App\Model\Entity\User;
use App\Model\Entity\WithdrawLogs;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Db\DB;

/**
 * 用户提现
 *
 * Class WithdrawDao
 * @package App\Model\Dao
 * @Bean()
 */
class WithdrawDao
{
    /**
     * 获取用户收益分页数据
     *
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getPage($where, $page, $limit)
    {
        return WithdrawLogs::where($where)
            ->from('withdraw_logs AS a')
            ->join('user AS b', 'a.user_id', '=', 'b.user_id')
            ->orderBy('withdraw_logs_id', 'desc')
            ->paginate($page, $limit, [
                'b.user_id',
                'b.name',
                'b.phone',
                'b.amount',
                'b.bank_no',
                'a.withdraw_logs_id',
                'a.point',
                'a.status',
                'a.create_time',
                'a.update_time',
            ]);
    }


    /**
     * 批量更新提现状态为成功
     *
     * @param $withdraw_logs_ids
     * @return int
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function batchSuccess($withdraw_logs_ids)
    {
        return WithdrawLogs::whereIn('withdraw_logs_id', $withdraw_logs_ids)
            ->where('status', 0)
            ->update(['status' => 2]);
    }

    /**
     * 批量更新提现状态为失败
     *
     * @param $withdraw_logs_ids
     * @return int
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function batchFail($withdraw_logs_ids)
    {
        $err = false;
        $successNum = 0;

        DB::beginTransaction();

        foreach ($withdraw_logs_ids as $v)
        {
            $logModel = WithdrawLogs::find($v);

            if ($logModel['status'] == 0)
            {
                DB::beginTransaction();

                $logRes = $logModel->update(['status' => 1]);

                $userRes = User::where('user_id', $logModel['user_id'])
                    ->increment('amount', $logModel['point']);

                if ($logRes && $userRes)
                {
                    DB::commit();
                    $successNum++;
                }
                else
                {
                    DB::rollBack();
                    $err = true;
                }
            }
        }

        // 有错误回滚
        if ($err || $successNum === 0)
        {
            DB::rollBack();
            return false;
        }

        // 提交事务
        DB::commit();
        return true;
    }


}