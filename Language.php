<?php

namespace pvlg\language;

use Yii;
use yii\base\Component;
use yii\helpers\Url;
use yii\web\Cookie;

/**
 * Language switcher component
 * You must define available languages in Yii::$app->params['languages'] as code => language
 * [
 *    'en' => 'english',
 *    'ru' => [
 *        'queryValue' => 'ru',
 *        'cookieValue' => 'rus',
 *        'sessionValue' => 'russian',
 *    ],
 *    'it' => [
 *        'queryValue' => 'italiano',
 *        'cookieValue' => 'italiano',
 *        'sessionValue' => 'italiano',
 *    ],
 * ]
 */
class Language extends Component
{

    /**
     * @var string language query param name
     */
    public $queryParam = 'language';

    /**
     * @var string language cookie param name
     */
    public $cookieParam = 'language';

    /**
     * @var string language session param name
     */
    public $sessionParam = 'language';

    /**
     * @var array cookie params
     */
    public $cookieParams = [];
    
    /**
     * @var array
     */
    private $_languages = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!isset(Yii::$app->params['languages'])) {
            throw new \yii\base\InvalidConfigException("You must define Yii::\$app->params['languages'] array");
        }

        foreach (Yii::$app->params['languages'] as $code => $language) {
            if (is_array($language)) {
                $this->_languages[$code] = $language;
            } else {
                $this->_languages[$code] = [
                    'name' => $language,
                    'queryValue' => $language,
                    'cookieValue' => $language,
                    'sessionValue' => $language,
                ];
            }
        }

        $queryValue = Yii::$app->request->get($this->queryParam);
        $cookieValue = Yii::$app->request->cookies->getValue($this->cookieParam);
        $sessionValue = Yii::$app->session->get($this->sessionParam);

        if ($queryValue !== null) {
            $code = $this->getCode('queryValue', $queryValue);

            $config = [
                'name' => $this->cookieParam,
                'value' => $this->_languages[$code]['cookieValue'],
            ];
            if (isset($this->cookieParams['expire'])) {
                $config['expire'] = $this->cookieParams['expire'];
            } else {
                $config['expire'] = time() + 365 * 24 * 60 * 60;
            }
            if (isset($this->cookieParams['path'])) {
                $config['path'] = $this->cookieParams['path'];
            }
            if (isset($this->cookieParams['domain'])) {
                $config['domain'] = $this->cookieParams['domain'];
            }
            if (isset($this->cookieParams['secure'])) {
                $config['secure'] = $this->cookieParams['secure'];
            }
            if (isset($this->cookieParams['httponly'])) {
                $config['httponly'] = $this->cookieParams['httponly'];
            }
            Yii::$app->response->cookies->add(new Cookie($config));
            Yii::$app->session->set($this->sessionParam, $this->_languages[$code]['sessionValue']);
            Yii::$app->language = $code;
        } elseif ($cookieValue !== null && $cookieValue !== $sessionValue) {
            $code = $this->getCode('cookieValue', $cookieValue);
            Yii::$app->session->set($this->sessionParam, $this->_languages[$code]['sessionValue']);
            Yii::$app->language = $code;
        } elseif ($sessionValue !== null) {
            $code = $this->getCode('sessionValue', $sessionValue);
            Yii::$app->language = $code;
        }
    }

    public function getLanguage()
    {
        return $this->_languages[Yii::$app->language];
    }

    public function getCode($param, $value)
    {
        foreach ($this->_languages as $code => $language) {
            if ($language[$param] == $value) {
                return $code;
            }
        }

        return Yii::$app->language;
    }
}
