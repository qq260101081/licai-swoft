<?php declare(strict_types=1);

namespace App\Http\Controller;

use App\Model\Logic\WithdrawLogic;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Context\Context;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;

/**
 * @Controller()
 */
class WithdrawController
{

    /**
     * @Inject()
     * @var WithdrawLogic
     */
    private $_logic;

    /**
     * 提现列表
     *
     * @RequestMapping("/withdraw", method={RequestMethod::GET})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function index()
    {
        $page       = (int)Context::get()->getRequest()->query('page', 1);
        $limit      = (int)Context::get()->getRequest()->query('limit', 10);
        $search = [
            'phone'      => Context::get()->getRequest()->query('phone', ''),
            'name'       => Context::get()->getRequest()->query('name', ''),
            'status'     => Context::get()->getRequest()->query('status', ''),
            'create_time' => Context::get()->getRequest()->query('create_time', '')
        ];

        $data = $this->_logic->getPage($search, $page, $limit);

        return response($data['data']);
    }

    /**
     * 批量审核为失败状态
     *
     * @RequestMapping("/withdraw/batchFail", method={RequestMethod::PUT})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function batchFail()
    {
        $ids = Context::get()->getRequest()->post('ids', '');

        $data = $this->_logic->batchFail($ids);

        return response($data['data'], $data['code']);
    }

    /**
     * 批量审核为成功状态
     *
     * @RequestMapping("/withdraw/batchSuccess", method={RequestMethod::PUT})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function batchSuccess()
    {
        $ids = Context::get()->getRequest()->post('ids', '');

        $data = $this->_logic->batchSuccess($ids);

        return response($data['data'], $data['code']);
    }

}
