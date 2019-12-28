<?php declare(strict_types=1);

namespace App\Http\Controller;

use App\Rpc\Lib\WithdrawInterface;
use Swoft\Context\Context;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;

/**
 * @Controller()
 */
class WithdrawController
{

    /**
     * @Reference(pool="withdraw.pool")
     * @var WithdrawInterface
     */
    private $_withdrawService;

    /**
     * 用户列表
     *
     * @RequestMapping("/api/withdraw", method={RequestMethod::GET})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function index()
    {
        $page = (int)Context::mustGet()->getRequest()->query('page', 1);
        $userId = (int)getUserId();

        $data = $this->_withdrawService->pageByUser($userId, $page);

        return response($data['data']);
    }



    /**
     * 提现申请
     *
     * @RequestMapping("/api/withdraw", method={RequestMethod::POST})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */

    public function create()
    {
        $userId = (int)getUserId();
        $amount = Context::mustGet()->getRequest()->post('amount', 0);

        $data = $this->_withdrawService->create($userId, $amount);

        return response($data['data'], $data['code']);
    }

}
