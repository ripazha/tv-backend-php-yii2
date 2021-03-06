<?php

namespace app\controllers;

use Yii;
use app\models\Entry;
use yii\web\Controller;

use M3uParser\M3uData;

class FileController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->response->sendContentAsFile(Entry::CurrentFile(), 'lista.m3u', [
            'mimeType' => 'audio/x-mpequrl',
            'inline' => true
        ]);
    }

    public function actionView($id)
    {
        $data = new M3uData();
        $query = Entry::find();
        if(!empty($id))
        {
            $query->joinWith('playlistEntry',false);
            $query->andWhere(['playlist_entry.playlist_id'=>$id]);
        }
        $entries = $query->all();

        // $data->setAttribute('test-name', 'test-value');
        foreach($entries as $entry)
        {
            $data->append($entry->M3uEntry);
        }
        return Yii::$app->response->sendContentAsFile("$data", 'lista.m3u', [
            'mimeType' => 'audio/x-mpequrl',
            'inline' => true
        ]);
    }
}