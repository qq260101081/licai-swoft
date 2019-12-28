<?php declare(strict_types=1);


namespace App\Rpc\Service;


use App\Model\Logic\ProductLogic;
use App\Rpc\Lib\ProductInterface;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Rpc\Server\Annotation\Mapping\Service;

/**
 * Class ProductService
 *
 * @since 2.0
 * @Service()
 */
class ProductService implements ProductInterface
{
    /**
     * @Inject()
     * @var ProductLogic
     */
    private $_logic;

    /**
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getList(int $page, int $limit): array
    {
        return $this->_logic->getProductList($page, $limit);
    }

    /**
     * 获取一条信息
     *
     * @param int $id
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function detail(int $id): array
    {
        return $this->_logic->getInfo($id);
    }
}
