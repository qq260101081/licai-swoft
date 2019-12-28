<?php declare(strict_types=1);


namespace App\Model\Logic;


use App\Model\Dao\IncomeDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * Class ProfitLogic
 * @package App\Model\Logic
 * @Bean()
 */
class IncomeLogic
{
    /**
     * 注入IncomeDao类
     *
     * @Inject()
     * @var IncomeDao
     */
    private $_dao;

    /**
     * 获取用户收益列表
     *
     * @param array $search
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getPage(array $search, int $page, int $limit): array
    {
        $where = [];
        if ($search['phone'])
        {
            $where[] = ['b.phone', '=', $search['phone']];
        }
        if ($search['name'])
        {
            $where[] = ['b.name', '=', $search['name']];
        }
        if ('' !== $search['type'])
        {
            $where[] = ['a.type', '=', $search['type']];
        }
        if ($search['create_time'])
        {
            $where[] = ['a.create_time', '>=', strtotime($search['create_time'][0])];
            $where[] = ['a.create_time', '<', strtotime($search['create_time'][1])];
        }

        $result = $this->_dao->getPage($where, $page, $limit);

        return ['data' => $result, 'code' => 0];
    }


    /**
     * 创建用户
     *
     * @param $post
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException

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
*/
}