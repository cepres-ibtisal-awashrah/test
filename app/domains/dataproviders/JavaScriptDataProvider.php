<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/' . IDomainDataProvider::class . EXT;

/**
 * JavaScriptDataProvider
 *
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright Copyright 2003-2021 Gurock Software GmbH. All rights reserved.
 * @package   Domain
 */
class JavaScriptDataProvider implements IDomainDataProvider
{
    public const JAVASCRIPT_EXTENSION = '.js';

    /** @var JavaScriptDomainModel[] $items */
    private $items = [];

    /** @var JavaScriptDomainModel[] $itemsReady */
    private $itemsReady = [];

    /**
     * JavaScriptDataProvider
     */
    public function __construct()
    {
        DomainLoader::model(JavaScriptDomainModel::class);
    }

    /**
     * @return JavaScriptDomainModel[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param JavaScriptDomainModel[] $items
     *
     * @return JavaScriptDataProvider
     */
    public function setItems(array $items): JavaScriptDataProvider
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return JavaScriptDomainModel[]
     */
    public function getItemsReady(): array
    {
        return $this->itemsReady;
    }

    /**
     * @param JavaScriptDomainModel[] $itemsReady
     *
     * @return JavaScriptDataProvider
     */
    public function setItemsReady(array $itemsReady): JavaScriptDataProvider
    {
        $this->itemsReady = $itemsReady;

        return $this;
    }

    /**
     * Adding script
     *
     * @param JavaScriptDomainModel $javaScriptDomainModel
     *
     * @return static
     */
    public function addScript(JavaScriptDomainModel $javaScriptDomainModel): JavaScriptDataProvider
    {
        if ($javaScriptDomainModel->getRegion() === JavaScriptRegionEnum::$READY) {
            $this->itemsReady[] = $javaScriptDomainModel;
        } else {
            $this->items[] = $javaScriptDomainModel;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getHeaderScripts(): string
    {
        return $this->prepareHtmlOutput(JavaScriptRegionEnum::$HEADER);
    }

    /**
     * @return string
     */
    public function getFooterScripts(): string
    {
        return $this->prepareHtmlOutput(JavaScriptRegionEnum::$FOOTER);
    }

    /**
     * @return JavaScriptDomainModel[]
     */
    public function getReadyScripts(): array
    {
        $returnedValue = [];
        foreach ($this->getScripts(JavaScriptRegionEnum::$READY) as $script) {
            $returnedValue[$script->getScript()] = $script;
        }

        return array_values($returnedValue);
    }

    /**
     * @param JavaScriptRegionEnum $region
     *
     * @return JavaScriptDomainModel[]
     */
    private function getScripts(JavaScriptRegionEnum $region): array
    {
        $scripts = [];
        $isDocumentReadyScript = $region === JavaScriptRegionEnum::$READY;
        $items = $region === JavaScriptRegionEnum::$READY
            ? $this->getItemsReady()
            : $this->getItems();

        /** @var JavaScriptDomainModel $script */
        foreach ($items ?? [] as $script) {
            $scriptFile = join(
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
                . static::JAVASCRIPT_EXTENSION;

            if ($isDocumentReadyScript) {
                $scripts[] = $script;
            } else {
                $isFileExists = file_exists($scriptFile);
                if ($script->getRegion() === $region && $isFileExists) {
                    $scripts[] = $script;
                } elseif (DEPLOY_DEVELOP && !$isFileExists) {
                    $this->addScript(
                        (new JavaScriptDomainModel())
                            ->setScript('console.log("The file ' . $scriptFile . ' could not be loaded.");')
                            ->setRegion(JavaScriptRegionEnum::$READY)
                    );
                } else {
                    // NOP
                }
            }
        }

        return $scripts;
    }

    /**
     * Generate HTML output for included scripts.
     *
     * @param JavaScriptRegionEnum $region
     *
     * @return string
     */
    private function prepareHtmlOutput(JavaScriptRegionEnum $region): string
    {
        $htmlOutput = '';
        foreach ($this->getScripts($region) ?? [] as $script) {
            $htmlOutput .= sprintf(
                SpecialCharsEnum::$TAB->value
                . '<script type="text/javascript" id="js-%s" src="%s" %s></script>'
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
                . JavaScriptDataProvider::JAVASCRIPT_EXTENSION
                . (
                $script->isCacheEnabled()
                    ? (SpecialCharsEnum::$QUESTION_MARK->value . md5(random_int(10, 10000)))
                    : ''
                ),
                $this->prepareDataAttributes($script->getParams())
            );
        }

        return $htmlOutput;
    }

    /**
     * @param DataAttributeDomainModel[] $params
     *
     * @return string
     */
    private function prepareDataAttributes(array $params = []): string
    {
        $attributes = '';
        foreach ($params as $param) {
            $attributes .= sprintf(
                'data-%s="%s" ',
                strtolower($param->getKey()),
                $param->isObfuscated()
                    ? base64_encode($param->getValue())
                    : $param->getValue()
            );
        }

        return rtrim($attributes);
    }
}
