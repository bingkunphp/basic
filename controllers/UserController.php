<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class UserController extends Controller
{
    function actionLogin()
    {
        echo 'say hello';
        exit;
        $this->layout = false;
        return $this->render('index');
    }
}

