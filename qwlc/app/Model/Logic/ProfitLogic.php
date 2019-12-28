<?php declare(strict_types=1);


namespace App\Model\Logic;


use App\Model\Dao\ProfitDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * Class ProfitLogic
 * @package App\Model\Logic
 * @Bean()
 */
class ProfitLogic
{
    /**
     * 注入ProfitLogic类
     *
     * @Inject()
     * @var ProfitDao
     */
    private $_dao;

    /**
     * 获取用户收益列表
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
        }

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