<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class FaceController extends Controller{

	public function actionLogin(){ 

	   // 上传文件路径 
	    $dir = "./Uploads/temp/"; 
	    if(!file_exists($dir)){ 
			mkdir($dir,0777,true); 
	    } 
	   $upload = new \Think\Upload(); 
	   $upload->maxSize = 2048000 ;// 设置附件上传大小 
	   $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型 
	   $upload->savepath = ''; 
	   $upload->autoSub = false; 
	   $upload->rootPath = $dir; // 设置附件上传根目录 
	   // 上传单个文件 
	   $info = $upload->uploadOne($_FILES['file']); 
	   if(!$info) {// 上传错误提示错误信息 
		 echo json_encode(array('error'=>true,'msg'=>$upload->getError()),JSON_UNESCAPED_UNICODE); 
	   }else{// 上传成功 获取上传文件信息 
		$file = $dir . $info['savepath'].$info['savename']; 
		$image = base64_encode(file_get_contents($file)); 
		$client = $this->init_face(); 
		$options['liveness_control'] = 'NORMAL'; 
		$options['max_user_num'] = '1'; 
		$ret = $client->search($image,'BASE64','student',$options); 
		// echo json_encode($ret,JSON_UNESCAPED_UNICODE); 
		// exit; 
		if($ret['error_code']==0){ 
		 $user = $ret['result']['user_list'][0]; 
		 $no = $user['user_id']; 
		 $score = $user['score']; 
		 if($score>=95){ 
		  $data = M('student')->where("no = '{$no}'")->find(); 
		  $data['score'] = $score; 
		  // $data['name'] = json_decode($data['name'],true); 
		  // $data['sex'] = json_decode($data['sex'],true); 
		  echo '识别成功' . json_encode($data,JSON_UNESCAPED_UNICODE); 
		 }else{ 
		  echo '识别失败' . $data['score']; 
		 } 
		} 
	   } 
  }

}


