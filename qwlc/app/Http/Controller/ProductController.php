<?php //declare(strict_types=1);

namespace App\Http\Controller;

use App\Rpc\Lib\ProductInterface;
use Swoft\Context\Context;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;

/**
 * @Controller()
 */
class ProductController
{
    /**
     * @Reference(pool="product.pool")
     * @var ProductInterface
     */
    private $_productService;

    /**
     * 产品列表
     *
     * @RequestMapping("/api/product", method={RequestMethod::GET})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function index()
    {
        $page = Context::get()->getRequest()->query('page', 1);
        $limit = Context::get()->getRequest()->query('limit', 10);
        $data = $this->_productService->getList($page, $limit);

        return response($data['data']);
    }

    /**
     * 产品信息
     *
     * @RequestMapping("/api/product/{id}", method={RequestMethod::GET})
     * @param int $id
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function detail(int $id)
    {
        $data = $this->_productService->detail($id);

        return response($data['data'], $data['code']);
    }

}
