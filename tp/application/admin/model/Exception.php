<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/16
 * Time: 09:16
 */
namespace app\admin\model;
use think\Model;

class Exception extends Model{
    public function errorMessage() {
        $errorMsg = '<strong>' . $this->getMessage() . "</strong><br />\n";
        return $errorMsg;
    }
}
?>
