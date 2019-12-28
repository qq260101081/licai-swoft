<?php declare(strict_types=1);


namespace App\Model\Logic;


use App\Model\Dao\ProductDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * Class ProductLogic
 * @package App\Model\Logic
 * @Bean()
 */
class ProductLogic
{
    /**
     * 注入ProductDao类
     *
     * @Inject()
     * @var ProductDao
     */
    private $_dao;

    /**
     * 获取产品列表
     *
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getProductList(int $page, int $limit): array
    {
        $result = $this->_dao->getAll($page, $limit);
        return ['data' => $result, 'code' => 0];
    }

    /**
     * 获取产品信息
     *
     * @param $productId
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getInfo($productId)
    {
        $data = $this->_dao->getInfo($productId);

        $data['createTime']  = date('Y-m-d H:i', $data['createTime']);
        return ['data' => $data, 'code' => 0];
    }

    /**
     * 更新产品信息
     *
     * @param $productId
     * @param $params
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function update($productId, $params)
    {
        $result = $this->_dao->update($productId, $params);
        if (!$result)
        {
            return ['data' => [], 'code' => 1];
        }

        return ['data' => [], 'code' => 0];
    }


    /**
     * 更新产品状态
     *
     * @param $status
     * @param $productIds
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function changeStatus($status, $productIds)
    {
        if (!$productIds)
        {
            return ['data' => [], 'code' => 1];
        }
        $productIds = explode(',', $productIds);
        $result = $this->_dao->batchUpdateStatus($status, $productIds);

        if (!$result)
        {
            return ['data' => [], 'code' => 1];
        }

        return ['data' => [], 'code' => 0];
    }

}
