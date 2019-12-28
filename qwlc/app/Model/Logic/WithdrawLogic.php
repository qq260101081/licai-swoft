<?php declare(strict_types=1);


namespace App\Model\Logic;


use App\Model\Dao\UserDao;
use App\Model\Dao\WithdrawDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * Class WithdrawLogic
 * @package App\Model\Logic
 * @Bean()
 */
class WithdrawLogic
{
    /**
     * 注入ProfitLogic类
     *
     * @Inject()
     * @var WithdrawDao
     */
    private $_dao;

    /**
     * @Inject()
     * @var UserDao
     */
    private $_userDao;

    /**
     * 获取用户提现列表
     *
     * @param int $page
     * @param int $user_id
     * @return array
     */
    public function getPageByUser( int $user_id, int $page): array
    {
        $result = $this->_dao->getPageByUser($user_id, $page);

        foreach ($result['list'] as $k => $v)
        {
            $result['list'][$k]['point'] = moneyFormat($v['point']);
            $result['list'][$k]['create_time'] = date('Y.m.d', $v['create_time']);
            if ($v['status'] == 2)
            {
                $result['list'][$k]['status'] = '成功';
            }
            elseif ($v['status'] == 1)
            {
                $result['list'][$k]['status'] = '失败';
            }
            else
            {
                $result['list'][$k]['status'] = '处理中';
            }
        }

        return ['data' => $result, 'code' => 0];
    }


    /**
     * 提现申请
     *
     * @param $user_id
     * @param $amount
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function create($user_id, $amount)
    {
        // 判断可提现金额
        $user = $this->_userDao->getInfo($user_id);

        $amount = (float)$amount;
        $amount = moneyFormatCent($amount); // 提现金额
        $amount = (int)$amount;

        // 提现金额不能小于1
        if ($amount < 1)
        {
            return ['data' => [], 'code' => 30500];
        }

        // 提现金额不足
        if ($amount > $user['amount'])
        {
            return ['data' => [], 'code' => 30501];
        }

        $result = $this->_dao->createOne($user_id, $amount);

        if ($result)
        {
            return ['data' => [], 'code' => 0];
        }

        return ['data' => [], 'code' => 1];
    }

}