<?php declare(strict_types=1);


namespace App\Model\Logic;


use App\Model\Dao\ProfitDao;
use App\Model\Dao\UserDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * Class UserLogic
 * @package App\Model\Logic
 * @Bean()
 */
class UserLogic
{
    /**
     * 注入UserDao类
     *
     * @Inject()
     * @var UserDao
     */
    private $_dao;

    /**
     * @Inject()
     * @var ProfitDao
     */
    private $_profitDao;

    /**
     * 获取用户列表
     *
     * @param $page
     * @return array
     */
    public function getUserList(int $page): array
    {
        $result = $this->_dao->getAll($page);

        return ['data' => $result];
    }

    /**
     * 获取用户信息
     *
     * @param $user_id
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getInfo($user_id)
    {
        $user = $this->_dao->getInfo($user_id);

        // 获取用户上个月收益
        $profit = $this->_profitDao->lastMonthProfit($user_id);

        $user['total_amount'] = moneyFormat($user['amount']);
        $user['income'] = moneyFormat($user['income']);

        $user['last_month_profit'] = 0.00;
        $profit && $user['last_month_profit'] =  moneyFormat($profit['point']);

        return ['data' => $user, 'code' => 0];
    }

    /**
     * 更新用户信息
     *
     * @param $post
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function userEdit($post)
    {
        $data = [];

        unset($post['amount'], $post['income'], $post['username'], $post['status']);

        if (isset($post['name']))
        {
            $data['name'] = $post['name'];
        }
        if (isset($post['phone']))
        {
            $data['phone'] = $post['phone'];
        }
        if (isset($post['bank_no']))
        {
            $data['bank_no'] = $post['bank_no'];
        }

        if (isset($post['password']))
        {
            $data['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        }

        if (isset($post['trans_password']))
        {
            $data['trans_password'] = password_hash($post['trans_password'], PASSWORD_DEFAULT);
        }

        $result = $this->_dao->editOne($post['user_id'], $data);
        if (!$result)
        {
            return ['data' => [], 'code' => 1];
        }

        return ['data' => [], 'code' => 0];
    }

    /**
     * 创建用户
     *
     * @param $post
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function userCreate($post)
    {
        $data = [
            'name'           => $post['name'],
            'phone'          => $post['phone'],
            'bank_no'        => $post['bank_no'],
            'password'       => password_hash($post['password'], PASSWORD_DEFAULT),
            'trans_password' => password_hash($post['trans_password'], PASSWORD_DEFAULT)
        ];

        $result = $this->_dao->createOne($data);
        if ($result)
        {
            return ['data' => [], 'code' => 1];
        }

        return ['data' => [], 'code' => 0];
    }

    /**
     * 获取团队列表
     * @param $user_id
     * @param $lelve
     * @param $page
     * @return array
     */
    public function teamList($user_id, $lelve, $page)
    {
        $data = $this->_dao->getTeamList($user_id,$lelve, $page);
        foreach ($data['list'] as $k => $v)
        {
            $data['list'][$k]['create_time'] = date('Y.m.d', $v['create_time']);
            $data['list'][$k]['amount'] = moneyFormat($v['amount']);
            $data['list'][$k]['income'] = moneyFormat($v['income']);
        }

        return ['data' => $data, 'code' => 0];
    }

    /**
     * 团队人数统计
     *
     * @param $user_id
     * @return array
     */
    public function teamCount($user_id)
    {
        $data = [
            'one_level' => 0,
            'two_level' => 0,
        ];
        $result = $this->_dao->teamCount($user_id);
        isset($result[1]) && $data['one_level'] = $result[1]['count'];
        isset($result[2]) && $data['two_level'] = $result[2]['count'];

        return ['data' => $data, 'code' => 0];
    }

}