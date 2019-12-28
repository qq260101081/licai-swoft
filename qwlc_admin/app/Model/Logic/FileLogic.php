<?php declare(strict_types=1);


namespace App\Model\Logic;

use App\Model\Dao\CfgDao;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Http\Message\Upload\UploadedFile;

/**
 * Class FileLogic
 * @package App\Model\Logic
 * @Bean()
 */
class FileLogic
{
    //文件可接受的mime类型
    private static $fileType = ['image/jpeg','image/jpg','image/png','image/gif'];

    /**
     * @Inject()
     * @var CfgDao
     */
    protected $_cfgDao;

    /**
     * 文件上传
     *
     * @param $files
     * @return array
     * @throws \Swoft\Db\Exception\DbException
     */
    public function uploads($files)
    {
        $response = [];
        $imgDomain = $this->_cfgDao->column('img_domain');
        if (!$imgDomain)
        {
            return ['data' => [], 'code' => 20050];
        }

        foreach ($files as $file)
        {
            self::_checkFile($file);
            $response[] = self::_saveFile($file, $imgDomain['imgDomain']);
        }

        return ['data' => ['urls' => $response], 'code' => 0];
    }

    /**
     * 保存文件
     *
     * @param UploadedFile $file
     * @param $imgDomain
     * @return array
     * @throws \Swoft\Db\Exception\DbException
     */
    protected function _saveFile(UploadedFile $file, $imgDomain){


        $dir = alias('@uploads') . '/' . date('Ymd');
        if(!is_dir($dir))
        {
            @mkdir($dir,0777,true);
        }
        $extName = substr($file->getClientFilename(), strrpos($file->getClientFilename(),'.'));
        $fileName = time().rand(1,999999);
        $path = $dir . '/' . $fileName . $extName;
        $file->moveTo($path);
        //修改移动后文件访问权限，文件默认没有访问权限
        @chmod($path,0775);
        //生成缩略图
        /*$manager = new Imag(array('driver' => 'imagick'));
        $thumb = $manager->make($path)->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $thumb_path = $dir. '/' . $fileName . '_thumb' .$extName;
        $thumb->save($dir. '/' . $fileName . '_thumb' .$extName);
        @chmod($thumb_path,0775);*/

        return $imgDomain . explode(alias('@public'),$path)[1];
    }

    /**
     * 图片文件校验
     *
     * @param UploadedFile $file
     * @return bool
     */
    protected function _checkFile(UploadedFile $file)
    {
        if($file->getSize() > 1024*1000*2)
        {
            return ['data' => [], 'code' => 20002];
        }
        if(!in_array($file->getClientMediaType(), self::$fileType))
        {
            return ['data' => [], 'code' => 20001];
        }

        return true;
    }
}
