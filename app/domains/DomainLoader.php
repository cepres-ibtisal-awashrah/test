<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

require_once APPPATH . 'enums/' . DomainElementEnum::class . EXT;

/**
 * Domain class loader
 *
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright Copyright 2003-2021 Gurock Software GmbH. All rights reserved.
 * @package   Domain
 *
 * @property DomainElementEnum $DomainPropertyEnum
 */
final class DomainLoader
{
    private const PLURAL_CHARACTER = 's';

    /**
     * @param string $domainElementName
     * @param bool   $returnDomainElement
     *
     * @return IDomainModel|null
     */
    public static function model(string $domainElementName, bool $returnDomainElement = false): ?IDomainModel
    {
        $domainElement = null;
        if (
            self::tryToLoadDomainElement(
                DomainElementEnum::$MODEL,
                $domainElementName . EXT
            )
            && $returnDomainElement
        ) {
            $domainElement = self::load($domainElementName);
        }

        return $domainElement;
    }

    /**
     * @param string $domainElementName
     * @param bool   $returnDomainElement
     *
     * @return IDomainModel|null
     */
    public static function dataprovider(
        string $domainElementName,
        bool $returnDomainElement = false
    ): ?IDomainDataProvider {
        $domainElement = null;
        if (
            self::tryToLoadDomainElement(
                DomainElementEnum::$DATAPROVIDER,
                $domainElementName . EXT
            )
            && $returnDomainElement
        ) {
            $domainElement = self::load($domainElementName);
        }

        return $domainElement;
    }

    /**
     * @param string        $domainElementName
     *
     * @return IDomainModel|IDomainDataProvider|null
     */
    public static function load(string $domainElementName)
    {
        return new $domainElementName() ?? null;
    }

    /**
     * @param DomainElementEnum $domainElement
     * @param string            $fileName
     *
     * @return bool
     */
    private static function tryToLoadDomainElement(DomainElementEnum $domainElement, string $fileName): bool
    {
        $domainFile = APPPATH
            . 'domains/'
            . strtolower($domainElement)
            . self::PLURAL_CHARACTER
            . '/'
            . $fileName;

        $isDomainElementLoaded = false;
        if (file_exists($domainFile)) {
            require_once $domainFile;
            $isDomainElementLoaded = true;
        }

        return $isDomainElementLoaded;
    }
}
