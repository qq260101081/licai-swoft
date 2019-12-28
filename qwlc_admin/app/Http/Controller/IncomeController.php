<?php declare(strict_types=1);

namespace App\Http\Controller;

use App\Model\Logic\IncomeLogic;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Context\Context;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;

/**
 * @Controller()
 */
class IncomeController
{

    /**
     * @Inject()
     * @var IncomeLogic
     */
    private $_logic;

    /**
     * 收益列表
     *
     * @RequestMapping("/income", method={RequestMethod::GET})
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
            'type'     => Context::get()->getRequest()->query('type', 0),
            'create_time' => Context::get()->getRequest()->query('create_time', '')
        ];

        $data = $this->_logic->getPage($search, $page, $limit);

        return response($data['data']);
    }

}
