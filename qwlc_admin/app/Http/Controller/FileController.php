<?php //declare(strict_types=1);

namespace App\Http\Controller;

use App\Model\Logic\FileLogic;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Context\Context;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;

/**
 * @Controller()
 */
class FileController
{
    /**
     * 注入逻辑层
     *
     * @Inject()
     * @var FileLogic
     */
    private $_logic;

    /**
     * 文件上传
     *
     * @RequestMapping("/file", method={RequestMethod::POST})
     * @return \Swoft\Http\Message\Response
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Exception\SwoftException
     */
    public function index()
    {
        $files = Context::get()->getRequest()->getUploadedFiles();
        $data = $this->_logic->uploads($files['file']);
        return response($data['data'], $data['code']);
    }

}
