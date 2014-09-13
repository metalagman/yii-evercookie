<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */

class EverCookie extends CWidget
{
    public $variableName = 'ec';
    public $sourcesDir = 'vendor.lagman.evercookie';
    public $baseUrl;

    public function init()
    {
        $this->baseUrl = Yii::app()->getComponent('assetManager')->publish(Yii::getPathOfAlias($this->sourcesDir));
        Yii::app()->getComponent('clientScript')->registerScriptFile($this->baseUrl . '/js/swfobject-2.2.min.js', CClientScript::POS_HEAD);
        Yii::app()->getComponent('clientScript')->registerScriptFile($this->baseUrl . '/js/evercookie.js', CClientScript::POS_HEAD);
    }

    public function run()
    {
        $options = [
            'baseurl' => $this->baseUrl,
//            'asseturi' => '/assets',
//            'phpuri' => '/php',
        ];

        $jsOptions = CJSON::encode($options);

        Yii::app()->getComponent('clientScript')->registerScript('EverCookieInit#' . $this->id,
            "var {$this->variableName};", CClientScript::POS_HEAD);

        Yii::app()->getComponent('clientScript')->registerScript('EverCookieReady#' . $this->id,
            "{$this->variableName} = new evercookie({$jsOptions});", CClientScript::POS_READY);
    }
}