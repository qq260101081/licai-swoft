<?php //declare(strict_types=1);

namespace App\Http\Controller;

use App\Model\Logic\ProductLogic;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Context\Context;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;

/**
 * @Controller()
 */
class ProductController
{
    /**
     * 注入逻辑层
     *
     * @Inject()
     * @var ProductLogic
     */
    private $_logic;

    /**
     * 产品列表
     *
     * @RequestMapping("/product", method={RequestMethod::GET})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Exception\SwoftException
     */
    public function index()
    {
        $page = Context::get()->getRequest()->query('page', 1);
        $limit      = Context::get()->getRequest()->query('limit', 10);
        $search = [
            'name'       => Context::get()->getRequest()->query('name', ''),
            'status'     => Context::get()->getRequest()->query('status', ''),
            'create_time' => Context::get()->getRequest()->query('create_time', '')
        ];
        $data = $this->_logic->getProductList($search, $page, $limit);

        return response($data['data']);
    }

    /**
     * 用户信息
     *
     * @RequestMapping("/info/{product_id}", method={RequestMethod::GET})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function view($product_id)
    {
        $data = $this->_logic->getInfo($product_id);

        return response($data['data'], $data['code']);
    }

    /**
     * 批量更新状态
     *
     * @RequestMapping("/product/changeStatus", method={RequestMethod::PUT})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Swoft\Exception\SwoftException
     */
    public function changeStatus()
    {
        $status = Context::get()->getRequest()->post('status', 0);
        $userIds = Context::get()->getRequest()->post('ids', '');
        $data = $this->_logic->changeStatus($status, $userIds);

        return response($data['data'], $data['code']);
    }

    /**
     * 更新产品
     *
     * @RequestMapping("/product/{id}", method={RequestMethod::PUT})
     * @param int $id
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Swoft\Exception\SwoftException
     */
    public function update(int $id)
    {
        $post = Context::get()->getRequest()->post();
        $data = $this->_logic->update($id, $post);

        return response($data['data'], $data['code']);
    }

    /**
     * 创建产品
     *
     * @RequestMapping("/product", method={RequestMethod::POST})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Swoft\Exception\SwoftException
     */
    public function create()
    {
        $post = Context::get()->getRequest()->post();
        $data = $this->_logic->create($post);

        return response($data['data'], $data['code']);
    }

}
