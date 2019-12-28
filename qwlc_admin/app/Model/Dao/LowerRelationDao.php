<?php declare(strict_types=1);


namespace App\Model\Dao;

use App\Model\Entity\LowerRelation;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * Class LowerRelationDao
 * @package App\Model\Dao
 * @Bean()
 */
class LowerRelationDao
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
        return LowerRelation::paginate($page, $this->_pageSize, [
            'admin_id',
            'name',
            'username',
            'status',
            'create_time',
            'update_time',
            'last_login_time',
        ]);
    }

    /**
     * 获取一条信息
     *
     * @param $lower_relation_id
     * @return array
     */
    public function getInfo($lower_relation_id)
    {
        return LowerRelation::find($lower_relation_id, [
            'lower_relation_id',
            'user_id',
            'lower_user_id',
            'level',
            'create_time',
            'update_time',
        ])->getArrayableAttributes();
    }

    /**
     * 指定下级用户ID获取一条信息
     *
     * @param $lower_user_id
     * @param $level
     * @return object|\Swoft\Db\Eloquent\Builder|\Swoft\Db\Eloquent\Model|null
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getOneByLowerUserId($lower_user_id, $level)
    {
        return LowerRelation::where(['lower_user_id' => $lower_user_id, 'level' => $level])->first([
            'lower_relation_id',
            'user_id',
            'lower_user_id',
            'level',
            'create_time',
            'update_time',
        ]);
    }

    /**
     * 指定下级用户ID和上级用户ID获取一条信息
     *
     * @param $lower_user_id
     * @param $user_id
     * @param $level
     * @return object|\Swoft\Db\Eloquent\Builder|\Swoft\Db\Eloquent\Model|null
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getOneByLowerUserIdAndUserId($lower_user_id, $user_id, $level)
    {
        return LowerRelation::where(['lower_user_id' => $lower_user_id,'user_id' => $user_id, 'level' => $level])->first([
            'lower_relation_id',
            'user_id',
            'lower_user_id',
            'level',
            'create_time',
            'update_time',
        ]);
    }

    /**
     * 更新一条数据
     *
     * @param $admin_id
     * @param $data
     * @return int
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function editOne($admin_id, $data)
    {
        return LowerRelation::where(['admin_id' => $admin_id])->limit(1)->update($data);
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
        $model = LowerRelation::new($data);
        $model->save();
        return $model->getUserId();
    }


}