<?php //declare(strict_types=1);

namespace App\Http\Controller;

use App\Model\Logic\IncomeLogic;
use App\Rpc\Lib\ProfitInterface;
use Swoft\Bean\Annotation\Mapping\Inject;
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
     * @Inject()
     * @var IncomeLogic
     */
    private $_logic;

    /**
     * 收益列表
     *
     * @RequestMapping("/profit", method={RequestMethod::GET})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function index()
    {
        $page = Context::get()->getRequest()->query('page', 1);
        $data = $this->_logic->getPage($page);

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
        $post = Context::get()->getRequest()->post();
        $data = $this->_logic->userCreate($post);

        return response($data['data'], $data['code']);
    }*/

}
