<?php declare(strict_types=1);


namespace App\Model\Dao;


use App\Model\Entity\LowerRelation;
use App\Model\Entity\User;
use Swoft\Bean\Annotation\Mapping\Bean;

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
     * @param $page
     * @return array
     */
    public function getAll($page)
    {
        return User::paginate($page, $this->_pageSize, [
            'user_id',
            'name',
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
     * @return array
     */
    public function getInfo($user_id)
    {
        return User::find($user_id, [
            'user_id',
            'name',
            'phone',
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
     * @return int
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function editOne($user_id, $data)
    {
        return User::where(['user_id' => $user_id])->limit(1)->update($data);
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
        $model = User::new($data);
        $model->save();
        return $model->getUserId();
    }

    /**
     * 团队人数统计
     *
     * @param $user_id
     * @return \Swoft\Stdlib\Collection
     */
    public function teamCount($user_id)
    {
        return LowerRelation::where('user_id', $user_id)
            ->selectRaw('level, count(1) AS count')
            ->groupBy('level')
            ->get()
            ->keyBy('level');
    }
}