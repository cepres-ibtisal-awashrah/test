<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'domains/models/' . BaseDomainModel::class . EXT;

/**
 * ApplicationConfigDomainModel
 * @package   DomainModel
 * @author    Sebastian Karpeta sebastian@assembla.com
 * @copyright Copyright 2003-2021 Gurock Software GmbH. All rights reserved.
 */
class ApplicationDispatcherDomainModel extends BaseDomainModel
{
    const DEFAULT_SEPARATOR = 'SLASH';

    /** @var string $controller */
    private $controller;

    /** @var string $method */
    private $method;

    /** @var array $pathElements */
    private $pathElements = [];

    /** @var SpecialCharsEnum $separator */
    private $separator;

    public function __construct()
    {
        $this->setSeparator(
            SpecialCharsEnum::parse(static::DEFAULT_SEPARATOR)
        );
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     *
     * @return ApplicationDispatcherDomainModel
     */
    public function setController(string $controller): ApplicationDispatcherDomainModel
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return ApplicationDispatcherDomainModel
     */
    public function setMethod(string $method): ApplicationDispatcherDomainModel
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return SpecialCharsEnum
     */
    public function getSeparator(): SpecialCharsEnum
    {
        return $this->separator;
    }

    /**
     * @param SpecialCharsEnum $separator
     *
     * @return ApplicationDispatcherDomainModel
     */
    public function setSeparator(SpecialCharsEnum $separator): ApplicationDispatcherDomainModel
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * Generating current route path
     *
     * @param bool $includeDefaultRoute
     *
     * @return string
     */
    public function getRoutePath(bool $includeDefaultRoute = true): string
    {
        $defaultRoutesElements =
            $includeDefaultRoute
                ? [
                    $this->getController(),
                    $this->getMethod(),
                ]
                : [];

        return implode(
            $this->getSeparator()->value,
            array_merge(
                $defaultRoutesElements,
                $this->getPathElements()
            )
        );
    }

    /**
     * @return array
     */
    public function getPathElements(): array
    {
        return $this->pathElements;
    }

    /**
     * @param string $pathElement Add path element to existing array with paths.
     * @param bool   $forceAdd    Cleaning path element array and add only one element from $pathElement variable.
     *
     * @return ApplicationDispatcherDomainModel
     */
    public function addPathElement(string $pathElement, bool $forceAdd = false): ApplicationDispatcherDomainModel
    {
        if ($forceAdd) {
            $this->pathElements = [];
        }
        $this->pathElements[] = $pathElement;

        return $this;
    }

    /**
     * @param array $pathElements
     *
     * @return ApplicationDispatcherDomainModel
     */
    public function addPathElements(array $pathElements): ApplicationDispatcherDomainModel
    {
        foreach ($pathElements as $element) {
            $this->addPathElement($element);
        }

        return $this;
    }
}
