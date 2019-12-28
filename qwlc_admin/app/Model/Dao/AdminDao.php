<?php declare(strict_types=1);


namespace App\Model\Dao;

use App\Model\Entity\Admin;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * Class AdminDao
 * @package App\Model\Dao
 * @Bean()
 */
class AdminDao
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
        return Admin::paginate($page, $this->_pageSize, [
            'admin_id',
            'name',
            'username',
            'status',
            'avatar',
            'create_time',
            'update_time',
            'last_login_time',
        ]);
    }

    /**
     * 获取管理员信息
     *
     * @param $admin_id
     * @return array
     */
    public function getInfo($admin_id)
    {
        return Admin::find($admin_id, [
            'admin_id',
            'name',
            'username',
            'status',
            'avatar',
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
        return Admin::where('username', $username)->first([
            'admin_id',
            'name',
            'username',
            'password',
            'status',
            'avatar',
            'create_time',
            'update_time',
            'last_login_time',
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
        return Admin::where(['admin_id' => $admin_id])->limit(1)->update($data);
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
        $model = Admin::new($data);
        $model->save();
        return $model->getUserId();
    }


}