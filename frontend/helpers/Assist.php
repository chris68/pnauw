<?php
namespace frontend\helpers;
use yii\helpers\Html;
use yii\helpers\Url;

class Assist
{
    /**
     * Create a nice html anchor to link
     * @param string $text The text to display in the html anchor
     * @param array|string $url The parameter to be used to generate the respective URL
     * @param array $options The optional options for the html element
     * @return mixed the generated anchor tag
     */
    public static function linkNew($text, $url, $options = [])
    {
        $options['target'] = '_blank';
        
        if (!isset($options['title'])) {
            $options['title'] = 'Absprung (öffnet in einem neuem Fenster/Reiter)';
        }
        
        return Html::a($text, $url, $options);
    }
    
    /**
     * Create a nice html anchor to the help page
     * @param string $text The text to display in the html anchor
     * @param string $anchor The optional name of the anchor (without the '#'!)
     * @param array $options The optional options for the html element
     * @return mixed the generated anchor tag
     */
    public static function help($text, $anchor=NULL, $options = [])
    {
        if (!isset($options['target'])) {
            $options['target'] = '_blank';
        }
        
        if (!isset($options['title'])) {
            $options['title'] = 'Hilfe zu dem Thema';
            if (isset($options['target'])) {
                if ($options['target'] == '_blank') {
                    $options['title'] = $options['title'].' in einem neuem Fenster/Reiter';
                }
            }
        }
        
        $url = Url::to(['site/help']).(isset($anchor)?('#'.$anchor):'');
        return Html::a($text, $url, $options);
    }
    
    /**
     * Create a nice html anchor to an external link
     * @param string $text The text to display in the html anchor
     * @param string $url The link 
     * @param array $options The optional options for the html element
     * @return mixed the generated anchor tag
     */
    public static function extlink($text, $url, $options = [])
    {
        if (!isset($options['target'])) {
            $options['target'] = '_blank';
        }
        
        if (!isset($options['title'])) {
            $options['title'] = 'Externer Link';
            if (isset($options['target'])) {
                if ($options['target'] == '_blank') {
                    $options['title'] = $options['title'].' (öffnet in einem neuem Fenster/Reiter)';
                }
            }
        }
        
        return Html::a($text, $url, $options);
    }
}
