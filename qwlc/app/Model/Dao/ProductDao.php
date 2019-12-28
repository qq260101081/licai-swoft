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
     * @param $page
     * @param $limit
     * @return array
     */
    public function getAll($page, $limit)
    {
        return Product::where('status', 0)->orderBy('product_id', 'desc')
            ->paginate($page, $limit);
    }

    /**
     * 获取产品信息
     *
     * @param $productId
     * @return object|\Swoft\Db\Eloquent\Builder|\Swoft\Db\Eloquent\Model|null
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

}
