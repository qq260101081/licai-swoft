<?php declare(strict_types=1);


namespace App\Model\Dao;


use App\Model\Entity\ProfitLogs;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * 用户收益
 *
 * Class ProfitDao
 * @package App\Model\Dao
 * @Bean()
 */
class IncomeDao
{
    /**
     * 获取用户收益分页数据
     *
     * @param int $page
     * @return array
     */
    public function getPage($where, $page, $limit)
    {
        return ProfitLogs::where($where)
        ->from('profit_logs AS a')
        ->join('user AS b', 'a.user_id', '=', 'b.user_id')
        ->orderBy('profit_logs_id', 'desc')
        ->paginate($page, $limit, [
            'b.user_id',
            'b.name',
            'b.phone',
            'b.amount',
            'b.bank_no',
            'a.profit_logs_id',
            'a.point',
            'a.type',
            'a.type',
            'a.create_time',
            'a.update_time',
        ]);
    }

    /**
     * 获取上个月收益
     * @param $user_id
     * @return object|\Swoft\Db\Eloquent\Builder|\Swoft\Db\Eloquent\Model|null
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function lastMonthProfit($user_id)
    {
        return ProfitLogs::where('user_id', $user_id)
            ->orderBy('profit_logs_id', 'DESC')
            ->first([
                'point'
            ]);
    }


    /**
     * 创建一条数据
     *
     * @param $data
     * @return int|null
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function createOne($data)
    {
        $model = ProfitLogs::new($data);
        $model->save();
        return $model->getUserId();
    }

}