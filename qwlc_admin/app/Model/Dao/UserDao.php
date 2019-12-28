<?php declare(strict_types=1);


namespace App\Model\Dao;


use App\Model\Entity\AmountLogs;
use App\Model\Entity\LowerRelation;
use App\Model\Entity\User;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Db\DB;

/**
 * Class UserDao
 * @package App\Model\Dao
 * @Bean()
 */
class UserDao
{
    // 默认分页大小
    protected $_pageSize = 15;

    /**
     * 获取分页数据
     *
     * @param $where
     * @param $page
     * @param $limit
     * @return array
     */
    public function getAll($where, $page, $limit)
    {
        return User::where($where)
            ->orderBy('user_id', 'desc')
            ->paginate($page, $limit, [
            'user_id',
            'name',
            'idcard',
            'username',
            'phone',
            'amount',
            'income',
            'bank_no',
            'status',
            'create_time',
            'update_time',
            'last_login_time',
        ]);
    }

    /**
     * 获取团队分页数据
     *
     * @param $user_id
     * @param $level
     * @param $page
     * @return array
     */
    public function getTeamList($user_id, $level, $page)
    {
        return LowerRelation::where([
                'a.user_id' => $user_id,
                'level' => $level
            ])
            ->from('lower_relation AS a')
            ->join('user AS b', 'a.user_id', '=', 'b.user_id')
            ->paginate($page, $this->_pageSize, [
                'b.user_id',
                'b.name',
                'b.phone',
                'b.amount',
                'b.income',
                'b.create_time',
            ]);
    }

    /**
     * 获取用户信息
     *
     * @param $user_id
     * @return \Swoft\Db\Eloquent\Builder[]|\Swoft\Db\Eloquent\Model[]
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getInfo($user_id)
    {
        return User::where('user_id', $user_id)->first([
            'user_id',
            'username',
            'name',
            'phone',
            'idcard',
            'amount',
            'income',
            'bank_no',
            'status',
            'create_time',
            'update_time',
            'last_login_time',
        ])->getArrayableAttributes();
    }

    /**
     * 获取一条信息
     *
     * @param $username
     * @return object|\Swoft\Db\Eloquent\Builder|\Swoft\Db\Eloquent\Model|null
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getOneByUsername($username)
    {
        return User::where('username', $username)->first([
            'user_id',
            'name',
            'username',
            'phone',
            'idcard',
            'password',
            'trans_password',
            'amount',
            'income',
            'bank_no',
            'status',
            'create_time',
            'update_time',
            'last_login_time',
        ]);
    }

    /**
     * 更新一条数据
     *
     * @param $user_id
     * @param $data
     * @param $oneLevel
     * @param $twoLevel
     * @param $delTowlevel
     * @return int
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function update($user_id, $data, $oneLevel, $twoLevel, $delTowlevel)
    {
        DB::beginTransaction();

        try {

            User::where(['user_id' => $user_id])->limit(1)->update($data);

            if ($oneLevel)
            {
               if ($oneLevel['action'])
                {
                    LowerRelation::where(['lower_user_id' => $user_id, 'level' => $oneLevel['level']])
                        ->limit(1)
                        ->update(['user_id' => $oneLevel['user_id']]);
                }
                else
                {
                    $model = LowerRelation::new([
                        'user_id' => $oneLevel['user_id'],
                        'lower_user_id' => $user_id,
                        'level' => $oneLevel['level'],
                    ]);
                    $model->save();
                    $model->getLowerRelationId();
                } 
            }

            if ($twoLevel)
            {
                if ($twoLevel['action'])
                {
                    LowerRelation::where(['lower_user_id' => $user_id, 'level' => $twoLevel['level']])
                        ->limit(1)
                        ->update(['user_id' => $twoLevel['user_id'], 'level' => $twoLevel['level']]);
                }
                else
                {
                    $twoLevelMmodel = LowerRelation::new([
                        'user_id' => $twoLevel['user_id'],
                        'lower_user_id' => $user_id,
                        'level' => $twoLevel['level'],
                    ]);
                    $twoLevelMmodel->save();
                    $twoLevelMmodel->getLowerRelationId();
                }
            }

            if ($delTowlevel)
            {
                LowerRelation::where(['lower_user_id' => $user_id, 'level' => 2])->limit(1)->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }


    }

    /**
     * 批量更新状态
     *
     * @param $status
     * @param $user_ids
     * @return int
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function batchUpdateStatus($status, $user_ids)
    {
        return User::whereIn('user_id', $user_ids)->update(['status' => $status]);
    }

    /**
     * 加钱
     *
     * @param $user_id
     * @param $amount
     * @return bool
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function plus($user_id, $amount)
    {
        DB::beginTransaction();

        $model = AmountLogs::new([
            'user_id' => $user_id,
            'amount' => $amount,
        ]);
        $model->save();
        $id = $model->getAmountLogsId();

        $userRes = User::where('user_id', $user_id)
            ->increment('amount', $amount);

        if ($id && $userRes)
        {
            DB::commit();
            return true;
        }

        DB::rollBack();
        return false;
    }

    /**
     * 减钱
     *
     * @param $user_id
     * @param $amount
     * @return bool
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function cut($user_id, $amount)
    {
        DB::beginTransaction();

        $model = AmountLogs::new([
            'user_id' => $user_id,
            'amount' => $amount,
            'type' => 1
        ]);
        $model->save();
        $id = $model->getAmountLogsId();

        $userRes = User::where('user_id', $user_id)
            ->decrement('amount', $amount);

        if ($id && $userRes)
        {
            DB::commit();
            return true;
        }

        DB::rollBack();
        return false;
    }

    /**
     * 创建一条数据
     *
     * @param $data
     * @param $oneLevel
     * @param $twoLevel
     * @return int|null
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function createOne($data, $oneLevel, $twoLevel)
    {
        DB::beginTransaction();

        try {

            $model = User::new($data);
            $model->save();
            $userId = $model->getUserId();

            if ($oneLevel)
            {
                $oneLevelModel = LowerRelation::new([
                    'user_id' => $oneLevel['user_id'],
                    'level' => $oneLevel['level'],
                    'lower_user_id' => $userId
                ]);
                $oneLevelModel->save();
                $oneLeveRes = $oneLevelModel->getLowerRelationId();

                if ($twoLevel)
                {
                    $twoLevelModel = LowerRelation::new([
                        'user_id' => $twoLevel['user_id'],
                        'level' => $twoLevel['level'],
                        'lower_user_id' => $userId
                    ]);
                    $twoLevelModel->save();
                    $twoLevelRes = $twoLevelModel->getLowerRelationId();
                }
            }

            DB::commit();
            return true;
        }catch (\Exception $e) {

            DB::rollBack();
            return false;
        }

    }


}
