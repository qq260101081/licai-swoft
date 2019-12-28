<?php declare(strict_types=1);


namespace App\Model\Dao;


use App\Model\Entity\Cfg;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * Class CfgDao
 * @package App\Model\Dao
 * @Bean()
 */
class CfgDao
{

    /**
     * 获取一条
     *
     * @return Cfg
     */
    public function one()
    {
        return Cfg::find(1);
    }

    /**
     * 获取列字段
     * @param $name
     * @return string
     * @throws \Swoft\Db\Exception\DbException
     */
    public function column($name)
    {
        return Cfg::find(1, [$name])->toArray();
    }

    /**
     * 更新一条数据
     *
     * @param $id
     * @param $data
     * @return int
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function update(int $id, array $data)
    {
        return Cfg::where(['id' => $id])
            ->limit(1)
            ->update($data);
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
        $model = Cfg::new($data);
        $model->save();
        return $model->getId();
    }


}
