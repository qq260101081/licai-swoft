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
    // 默认分页大小
    protected $_pageSize = 15;

    /**
     * 获取用户收益分页数据
     *
     * @param int $page
     * @param int $user_id
     * @return array
     */
    public function getPageByUser(int $user_id, int $page)
    {
        return WithdrawLogs::where('user_id',$user_id)
            ->orderBy('withdraw_logs_id', 'DESC')
            ->paginate($page, $this->_pageSize, [
            'withdraw_logs_id',
            'point',
            'status',
            'create_time',
        ]);
    }


    /**
     * 创建一条数据
     *
     * @param int $user_id
     * @param int $amount
     * @return bool
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function createOne(int $user_id, int $amount)
    {
        DB::beginTransaction();

        $result = User::where('user_id', $user_id)->decrement('amount', $amount);

        $model = WithdrawLogs::new(['user_id' => $user_id, 'point' => $amount]);
        $model->save();
        $withdrawId = $model->getUserId();

        if ($result && $withdrawId)
        {
            DB::commit();
            return true;
        }
        else
        {
            DB::rollBack();
            return false;
        }

    }

}