<?php //declare(strict_types=1);

namespace App\Http\Controller;

use App\Rpc\Lib\ProfitInterface;
use Swoft\Context\Context;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;

/**
 * @Controller()
 */
class ProfitController
{

    /**
     * @Reference(pool="profit.pool")
     * @var ProfitInterface
     */
    private $_profitService;

    /**
     * 用户列表
     *
     * @RequestMapping("/api/profit", method={RequestMethod::GET})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function index()
    {
        $page = Context::mustGet()->getRequest()->query('page', 1);
        $userId = getUserId();

        $data = $this->_profitService->pageByUser($userId, $page);

        return response($data['data']);
    }



    /**
     * 创建用户
     *
     * @RequestMapping(method={RequestMethod::POST})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException

    public function create()
    {
        $post = Context::mustGet()->getRequest()->post();
        $data = $this->_logic->userCreate($post);

        return response($data['data'], $data['code']);
    }*/

}
