<?php
namespace yii\easyii\controllers;
use yii\easyii\models\Module;

use Yii;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use yii\easyii\models\Admin;

class AdminsController extends \yii\easyii\components\Controller
{
    public $rootActions = 'all';

    public function actionIndex()
    {

      
        $data = new ActiveDataProvider([
            'query' => Admin::find()->desc(),
        ]);

      



        Yii::$app->user->setReturnUrl(['/admin/admins']);

        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate()
    {
        $model = new Admin;
        $model->scenario = 'create';


        $dataModule = new ActiveDataProvider([
            'query' => Module::find()->sort(),
        ]);

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if($model->save()){
                    $this->flash('success', Yii::t('easyii', 'Admin created'));
                    return $this->redirect(['/admin/admins']);
                }
                else{
                    $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        }
        else {
        
            foreach ($dataModule->models as $module) {
                $module->status = Module::STATUS_OFF;
            }


            return $this->render('create', [
                'model' => $model,
                'modules' => $dataModule->models
            ]);
        }
    }



    public function actionEdit($id)
    {
        $model = Admin::findOne($id);


        $dataModule = new ActiveDataProvider([
            'query' => Module::find()->sort(),
        ]);


        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Not found'));
            return $this->redirect(['/admin/admins']);
        }

        if ($model->load(Yii::$app->request->post())) {

            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
                   
            }
            else{

                if($model->save()){
                    $this->flash('success', Yii::t('easyii', 'Admin updated'));
                }
                else{
                    $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
                }

                return $this->refresh();
            }
        }
        else {
         // var_dump($dataModule->models);
            $module_list = $model->modules;
            foreach ($dataModule->models as $module) {
                if(strpos($module_list, '-'.$module->name.'-') !== false){
                    $module->status = Module::STATUS_ON;
                }else{
                    $module->status = Module::STATUS_OFF;
                }
            }

            // var_dump($dataModule->models);


            return $this->render('edit', [
                'model' => $model,
                'modules' => $dataModule->models
            ]);
        }
    }

    public function actionDelete($id)
    {
        if(($model = Admin::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'Admin deleted'));
    }
}