<?php declare(strict_types=1);


namespace App\Model\Dao;


use App\Model\Entity\Product;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * Class ProductDao
 * @package App\Model\Dao
 * @Bean()
 */
class ProductDao
{

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
        return Product::where($where)
            ->orderBy('product_id', 'desc')
            ->paginate($page, $limit);
    }

    /**
     * 获取团队分页数据
     *
     * @param $user_id
     * @param $level
     * @param $page
     * @return array

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
    }*/

    /**
     * 获取产品信息
     *
     * @param $productId
     * @return \Swoft\Db\Eloquent\Builder[]|\Swoft\Db\Eloquent\Model[]
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getInfo($productId)
    {
        return Product::where('product_id', $productId)
            ->first()
            ->toArray();
    }

    /**
     * 更新一条数据
     *
     * @param $productId
     * @param $data
     * @return int
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function update(int $productId, array $data)
    {
        return Product::where(['product_id' => $productId])
            ->limit(1)
            ->update($data);
    }

    /**
     * 批量更新状态
     *
     * @param $status
     * @param $productIds
     * @return int
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function batchUpdateStatus($status, $productIds)
    {
        return Product::whereIn('product_id', $productIds)->update(['status' => $status]);
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
        $model = Product::new($data);
        $model->save();
        return $model->getProductId();
    }


}
