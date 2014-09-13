<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */

class EverCookie extends CWidget
{
    public $variableName = 'ec';
    public $sourcesDir = 'vendor.lagman.evercookie';
    public $baseUrl;
    public $scriptOptions = [];

    public function init()
    {
        $this->baseUrl = Yii::app()->getComponent('assetManager')->publish(Yii::getPathOfAlias($this->sourcesDir));
        Yii::app()->getComponent('clientScript')->registerScriptFile($this->baseUrl . '/js/swfobject-2.2.min.js', CClientScript::POS_HEAD);
        Yii::app()->getComponent('clientScript')->registerScriptFile($this->baseUrl . '/js/evercookie.js', CClientScript::POS_HEAD);
    }

    public function run()
    {
        $defaultOptions = [
            'baseurl' => $this->baseUrl,
        ];

        $jsOptions = CJSON::encode(CMap::mergeArray($defaultOptions, $this->scriptOptions));

        Yii::app()->getComponent('clientScript')->registerScript('EverCookieInit#' . $this->id,
            "var {$this->variableName};", CClientScript::POS_HEAD);

        Yii::app()->getComponent('clientScript')->registerScript('EverCookieReady#' . $this->id,
            "{$this->variableName} = new evercookie({$jsOptions});", CClientScript::POS_READY);
    }
}