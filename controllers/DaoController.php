<?php
namespace app\controllers;

use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;

class DaoController extends Controller {
    /**
     * 使用DAO 查询数据
     * 传入sql语句从数据库往外拿数据
     * queryAll
     * querOne
     * queryScalar 查询统计
     * queryColumn 得到这一列的值数组
     */
    public function actionIndex() {
        $conn = Yii::$app->db;
        $sql = "select * from user";
        //$command = $conn->createCommand($sql);
        //$data = $command->queryAll();
        //$data = $command->queryOne();
        //$data = $command->queryScalar();
        //$data = $command->queryColumn();
        $data = $conn->createCommand($sql)->queryAll();
        VarDumper::dump($data,10,true);
    }

    /**
     * 增删改
     */
    public function actionInsert()
    {
        $sql = "insert user (username) value ('Japan')";
        //$re = Yii::$app->db->createCommand($sql)->execute();//返回影响的行数
        //$re = Yii::$app->db->createCommand()->insert('user',['username'=>'kun'])->execute();
        //$re = Yii::$app->db->createCommand()->batchInsert('user',['username'],[['a'],['b'],['c']])->execute();
        //$re = Yii::$app->db->createCommand()->update('user',['username'=>'ddd'],['id'=>3])->execute();
        $re = Yii::$app->db->createCommand()->delete('user', 'id>5')->execute();
        return $re;
    }
    /**
     * 参数绑定
     */
    public function actionBind() {
        //bindValue 绑定一个参数,参数为具体值
        //bindValues 绑定多个参数,参数以是变量
        //bindParam 绑定多个参数, 参数可以是变量
        $conn = Yii::$app->db;
        $sql = "select * from user where id = :id";
        $command = $conn->createCommand($sql);
        //$command = $conn->createCommand($sql,[':id'=>2]);//也可以在第二个参数这直接绑定
        $id = 3;
        //$command ->bindValues([":id"=>$id]);
        $command ->bindParam(':id',$id);
        $re = $command->queryOne();
        VarDumper::dump($re,10,true);exit;
        //return $re;

    }

    /**
     * query 对象的使用方法
     * distinct() 根据字段去重
     */
    public function actionQuery()
    {
        $query = (new Query())->distinct()->select(['username', 'id'])->from('user,product')->all;
        return $query;
    }

}

