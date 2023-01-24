<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/' . IDomainDataProvider::class . EXT;

/**
 * CssScriptDataProvider
 *
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright Copyright 2003-2022 Gurock Software GmbH. All rights reserved.
 * @package   Domain
 */
class CssScriptDataProvider implements IDomainDataProvider
{
    public const CSS_EXTENSION = '.css';

    /** @var CssScriptDomainModel[] $items */
    private $items = [];

    /**
     * JavaScriptDataProvider
     */
    public function __construct()
    {
        DomainLoader::model(CssScriptDomainModel::class);
    }

    /**
     * @return CssScriptDomainModel[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param CssScriptDomainModel[] $items
     *
     * @return CssScriptDataProvider
     */
    public function setItems(array $items): CssScriptDataProvider
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Adding script
     *
     * @param CssScriptDomainModel $cssScriptDomainModel
     *
     * @return static
     */
    public function addScript(CssScriptDomainModel $cssScriptDomainModel): CssScriptDataProvider
    {
        $this->items[] = $cssScriptDomainModel;

        return $this;
    }

    /**
     * @return string
     */
    public function getHeaderScripts(): string
    {
        return $this->prepareHtmlOutput();
    }

    /**
     * @return CssScriptDomainModel[]
     */
    private function getScripts(): array
    {
        $scripts = [];
        /** @var CssScriptDomainModel $script */
        foreach ($this->getItems() ?? [] as $script) {
            $scripts[] = implode(
                    SpecialCharsEnum::$SLASH->value,
                    [
                        DEPLOY_HOSTED
                            ? rtrim(
                            explode(
                                'app',
                                __FILE__
                            )[0],
                            SpecialCharsEnum::$SLASH->value
                        )
                            : getcwd(),
                        $script->getScript(),
                    ]
                )
                . static::CSS_EXTENSION;
        }

        return $scripts;
    }

    /**
     * Generate HTML output for included CSS scripts.
     *
     * @return string
     */
    private function prepareHtmlOutput(): string
    {
        $htmlOutput = '';
        foreach ($this->getItems() ?? [] as $script) {
            $htmlOutput .= sprintf(
                '<link type="text/css" rel="stylesheet" id="css-%s" href="%s" media="all">'
                . SpecialCharsEnum::$EOL->value,
                str_replace(
                    SpecialCharsEnum::$SLASH->value,
                    SpecialCharsEnum::$MINUS->value,
                    $script->getScript()
                ),
                (
                    DEPLOY_HOSTED
                        ? r($script->getScript())
                        : $script->getScript()
                )
                . self::CSS_EXTENSION
                . (
                $script->isCacheEnabled()
                    ? (SpecialCharsEnum::$QUESTION_MARK->value . md5(random_int(10, 10000)))
                    : ''
                )
            );
        }

        return $htmlOutput;
    }
}
