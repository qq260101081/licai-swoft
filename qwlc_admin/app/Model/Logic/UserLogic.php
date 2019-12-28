<?php declare(strict_types=1);


namespace App\Model\Logic;


use App\Model\Dao\LowerRelationDao;
use App\Model\Dao\IncomeDao;
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
     * @var LowerRelationDao
     */
    private $_relation_dao;

    /**
     * @Inject()
     * @var IncomeDao
     */
    private $_profitDao;

    /**
     * 获取用户列表
     *
     * @param array $search
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getUserList(array $search, int $page, int $limit): array
    {
        $where = [];
        if ($search['phone'])
        {
            $where[] = ['phone', '=', $search['phone']];
        }
        if ($search['name'])
        {
            $where[] = ['name', '=', $search['name']];
        }
        if ('' !== $search['status'])
        {
            $where[] = ['status', '=', $search['status']];
        }
        if ($search['create_time'])
        {
            $where[] = ['create_time', '>=', strtotime($search['create_time'][0])];
            $where[] = ['create_time', '<', strtotime($search['create_time'][1])];
        }

        $result = $this->_dao->getAll($where, $page, $limit);

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

        $user['total_amount'] = moneyFormat($user['amount'] + $user['income']);

        $user['last_month_profit'] = 0.00;
        $profit && $user['last_month_profit'] =  moneyFormat($profit['point']);

        return ['data' => $user, 'code' => 0];
    }

    /**
     * 更新用户信息
     *
     * @param $user_id
     * @param $params
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function update($user_id, $params)
    {
        $data = [];

        if (isset($params['name']))
        {
            $data['name'] = $params['name'];
        }

        if (isset($params['phone']))
        {
            $data['phone'] = $params['phone'];
        }

        if (isset($params['idcard']))
        {
            $data['idcard'] = $params['idcard'];
        }

        if (isset($params['bank_no']))
        {
            $data['bank_no'] = $params['bank_no'];
        }

        if (isset($params['password']) && $params['password'])
        {
            $data['password'] = password_hash($params['password'], PASSWORD_DEFAULT);
        }

        if (isset($params['trans_password']) && $params['trans_password'])
        {
            $data['trans_password'] = password_hash($params['trans_password'], PASSWORD_DEFAULT);
        }

        $oneLevel = [];
        $twoLevel = [];
        $delTowlevel = false;

        if (isset($params['referrer_user_id']) && $params['referrer_user_id'])
        {
            // 查一级推荐用户
            $oneLevelUser = $this->_dao->getInfo((int)$params['referrer_user_id']);
            if (!$oneLevelUser)
            {
                return ['data' => [], 'code' => 10501];
            }

            $oneLevel['user_id'] = $params['referrer_user_id'];
            $oneLevel['level'] = 1;  // 1级关系
            $oneLevel['action'] = 0; // 默认创建

            $oneRelation = $this->_relation_dao->getOneByLowerUserId($user_id,1);
            $oneRelation && $oneLevel['action'] = 1; // 更新

            // 查推荐人上级用户
            $twoLevelUser = $this->_relation_dao->getOneByLowerUserId($params['referrer_user_id'], 1);

            if ($twoLevelUser)
            {
                // 查推荐人与修改用户的二级关系是否存在
                $exist = $this->_relation_dao->getOneByLowerUserId($user_id, 2);
                if ($exist)
                {
                    $twoLevel['user_id'] = $twoLevelUser['user_id'];
                    $twoLevel['level'] = 2;
                    $twoLevel['action'] = 1; // 更新
                }
                else
                {
                    $twoLevel['user_id'] = $twoLevelUser['user_id'];
                    $twoLevel['level'] = 2;
                    $twoLevel['action'] = 0; // 创建
                }
            }
            else
            {
                // 修改用户存在二级关系
                $userTowLevel = $this->_relation_dao->getOneByLowerUserId($user_id, 2);
                $userTowLevel && $delTowlevel = true;
            }

        }

        $result = $this->_dao->update($user_id, $data, $oneLevel, $twoLevel, $delTowlevel);
        if (!$result)
        {
            return ['data' => [], 'code' => 1];
        }

        return ['data' => [], 'code' => 0];
    }

    /**
     * 加钱
     *
     * @param $user_id
     * @param $amount
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function plus($user_id, $amount)
    {
        if ($amount < 1)
        {
            return ['data' => [], 'code' => 10502];
        }

        $amount = yuanToCent($amount);
        $result = $this->_dao->plus($user_id, $amount);
        if (!$result)
        {
            return ['data' => [], 'code' => 1];
        }

        return ['data' => [], 'code' => 0];
    }

    /**
     * 减钱
     *
     * @param $user_id
     * @param $amount
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function cut($user_id, $amount)
    {
        if ($amount < 1)
        {
            return ['data' => [], 'code' => 10502];
        }

        $amount = yuanToCent($amount);

        // 判断闹金额是否够减
        $user = $this->_dao->getInfo($user_id);
        if ($user['amount'] < $amount)
        {
            return ['data' => [], 'code' => 10503];
        }

        $result = $this->_dao->cut($user_id, $amount);
        if (!$result)
        {
            return ['data' => [], 'code' => 1];
        }

        return ['data' => [], 'code' => 0];
    }

    /**
     * 更新用户状态
     *
     * @param $status
     * @param $user_ids
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function changeStatus($status, $user_ids)
    {
        if (!$user_ids)
        {
            return ['data' => [], 'code' => 1];
        }
        $user_ids = explode(',', $user_ids);
        $result = $this->_dao->batchUpdateStatus($status, $user_ids);

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
            'username'       => $post['username'],
            'name'           => $post['name'],
            'idcard'         => $post['idcard'],
            'phone'          => $post['phone'],
            'bank_no'        => $post['bank_no'],
            'password'       => password_hash($post['password'], PASSWORD_DEFAULT),
            'trans_password' => password_hash($post['trans_password'], PASSWORD_DEFAULT)
        ];

        $oneLevel = [];
        $twoLevel = [];

        if (isset($post['referrer_user_id']) && $post['referrer_user_id'])
        {
            // 查一级推荐用户
            $oneLevelUser = $this->_dao->getInfo((int)$post['referrer_user_id']);

            if (!$oneLevelUser)
            {
                return ['data' => [], 'code' => 10501];
            }
            $oneLevel['user_id'] = $post['referrer_user_id'];
            $oneLevel['level'] = 1;

            // 查二级推荐用户
            $twoLevelUser = $this->_relation_dao->getOneByLowerUserId($oneLevelUser['user_id'], 1);
            if ($twoLevelUser)
            {
                $twoLevel['user_id'] = $twoLevelUser['user_id'];
                $twoLevel['level'] = 2;
            }

        }


        $result = $this->_dao->createOne($data, $oneLevel, $twoLevel);
        if (!$result)
        {
            return ['data' => [], 'code' => 1];
        }

        return ['data' => ['user_id' => $result], 'code' => 0];
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

}
