<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * Http status code enum.
 *
 * @package Enum
 * @author  Sebastian Karpeta <sebastian@assembla.com>
 */
class HttpStatusCodeEnum extends Enum
{
    /**
     * 1xx informational response
     */

    /** @var int $CONTINUE */
    public static $CONTINUE = 100;

    /** @var int $SWITCHING_PROTOCOLS */
    public static $SWITCHING_PROTOCOLS = 101;

    /** @var int $PROCESSING */
    public static $PROCESSING = 102;

    /** @var int $EARLY_HINTS */
    public static $EARLY_HINTS = 103;

    /**
     * 2xx success
     */

    /** @var int $OK */
    public static $OK = 200;

    /** @var int $CREATED */
    public static $CREATED = 201;

    /** @var int $ACCEPTED */
    public static $ACCEPTED = 202;

    /** @var int $NON_AUTHORITATIVE_INFORMATION */
    public static $NON_AUTHORITATIVE_INFORMATION = 203;

    /** @var int $NO_CONTENT */
    public static $NO_CONTENT = 204;

    /** @var int $PARTIAL_CONTENT */
    public static $PARTIAL_CONTENT  = 206;

    /** @var int $MULTI_STATUS */
    public static $MULTI_STATUS = 207;

    /** @var int $ALREADY_REPORTED */
    public static $ALREADY_REPORTED = 208;

    /** @var int $IM_USED */
    public static $IM_USED = 226;

    /**
     * 3xx redirection
     */

    /** @var int $MULTIPLE_CHOICES */
    public static $MULTIPLE_CHOICES = 300;

    /** @var int $MOVED_PERMANENTLY */
    public static $MOVED_PERMANENTLY = 301;

    /** @var int $MOVED_TEMPORARILY */
    public static $MOVED_TEMPORARILY = 302;

    /** @var int $SEE_OTHER */
    public static $SEE_OTHER = 303;

    /** @var int $NOT_MODIFIED */
    public static $NOT_MODIFIED = 304;

    /** @var int $USE_PROXY */
    public static $USE_PROXY = 305;

    /** @var int $SWITCH_PROXY */
    public static $SWITCH_PROXY = 306;

    /** @var int $TEMPORARY_REDIRECT */
    public static $TEMPORARY_REDIRECT = 307;

    /** @var int $PERMANENT_REDIRECT */
    public static $PERMANENT_REDIRECT = 308;

    /**
     * 4xx client errors
     */

    /** @var int $BAD_REQUEST */
    public static $BAD_REQUEST = 400;

    /** @var int $UNAUTHORIZED */
    public static $UNAUTHORIZED = 401;

    /** @var int $PAYMENT_REQUIRED */
    public static $PAYMENT_REQUIRED = 402;

    /** @var int $FORBIDDEN */
    public static $FORBIDDEN = 403;

    /** @var int $NOT_FOUND */
    public static $NOT_FOUND = 404;

    /** @var int $METHOD_NOT_ALLOWED */
    public static $METHOD_NOT_ALLOWED = 405;

    /** @var int $NOT_ACCEPTABLE */
    public static $NOT_ACCEPTABLE = 406;

    /** @var int $PROXY_AUTHENTICATION_REQUIRED */
    public static $PROXY_AUTHENTICATION_REQUIRED = 407;

    /** @var int $REQUEST_TIMEOUT */
    public static $REQUEST_TIMEOUT = 408;

    /** @var int $CONFLICT */
    public static $CONFLICT = 409;

    /** @var int $GONE */
    public static $GONE = 410;

    /** @var int $LENGTH_REQUIRED */
    public static $LENGTH_REQUIRED = 411;

    /** @var int $PRECONDITION_FAILED */
    public static $PRECONDITION_FAILED = 412;

    /** @var int $PAYLOAD_TOO_LARGE */
    public static $PAYLOAD_TOO_LARGE = 413;

    /** @var int $URI_TOO_LONG */
    public static $URI_TOO_LONG = 414;

    /** @var int $UNSUPPORTED_MEDIA_TYPE */
    public static $UNSUPPORTED_MEDIA_TYPE = 415;

    /** @var int $RANGE_NOT_SATISFIABLE */
    public static $RANGE_NOT_SATISFIABLE = 416;

    /** @var int $EXPECTATION_FAILED */
    public static $EXPECTATION_FAILED = 417;

    /** @var int $IM_A_TEAPOT */
    public static $IM_A_TEAPOT = 418;

    /** @var int $MISDIRECTED_REQUEST */
    public static $MISDIRECTED_REQUEST = 421;

    /** @var int $UNPROCESSABLE_ENTITY */
    public static $UNPROCESSABLE_ENTITY = 422;

    /** @var int $LOCKED */
    public static $LOCKED = 423;

    /** @var int $FAILED_DEPENDENCY */
    public static $FAILED_DEPENDENCY = 424;

    /** @var int $TOO_EARLY */
    public static $TOO_EARLY = 425;

    /** @var int $UPGRADE_REQUIRED */
    public static $UPGRADE_REQUIRED = 426;

    /** @var int $PRECONDITION_REQUIRED */
    public static $PRECONDITION_REQUIRED = 428;

    /** @var int $TOO_MANY_REQUESTS */
    public static $TOO_MANY_REQUESTS = 429;

    /** @var int $REQUEST_HEADER_FIELDS_TOO_LARGE */
    public static $REQUEST_HEADER_FIELDS_TOO_LARGE = 431;

    /** @var int $UNAVAILABLE_FOR_LEGAL_REASONS */
    public static $UNAVAILABLE_FOR_LEGAL_REASONS = 451;

    /**
     * 5xx server errors
     */

    /** @var int $INTERNAL_SERVER_ERROR */
    public static $INTERNAL_SERVER_ERROR = 500;

    /** @var int $NOT_IMPLEMENTED */
    public static $NOT_IMPLEMENTED = 501;

    /** @var int $BAD_GATEWAY */
    public static $BAD_GATEWAY = 502;

    /** @var int $SERVICE_UNAVAILABLE */
    public static $SERVICE_UNAVAILABLE = 503;

    /** @var int $GATEWAY_TIMEOUT */
    public static $GATEWAY_TIMEOUT = 504;

    /** @var int $HTTP_VERSION_NOT_SUPPORTED */
    public static $HTTP_VERSION_NOT_SUPPORTED = 505;

    /** @var int $VARIANT_ALSO_NEGOTIATES */
    public static $VARIANT_ALSO_NEGOTIATES = 506;

    /** @var int $INSUFFICIENT_STORAGE */
    public static $INSUFFICIENT_STORAGE = 507;

    /** @var int $LOOP_DETECTED */
    public static $LOOP_DETECTED = 508;

    /** @var int $NOT_EXTENDED */
    public static $NOT_EXTENDED = 510;

    /** @var int $NETWORK_AUTHENTICATION_REQUIRED */
    public static $NETWORK_AUTHENTICATION_REQUIRED = 511;

    /**
     * Get all 1xx Informational response statuses
     *
     * @return static[]
     * @throws ReflectionException
     */
    public static function getInformationalResponseStatuses(): array
    {
        return static::generateCollection(
            [
                static::$CONTINUE,
                static::$SWITCHING_PROTOCOLS,
                static::$PROCESSING,
                static::$EARLY_HINTS
            ]
        );
    }

    /**
     * Get all 2xx success statuses
     *
     * @return static[]
     * @throws ReflectionException
     */
    public static function getSuccessStatuses(): array
    {
        return static::generateCollection(
            [
                static::$OK,
                static::$CREATED,
                static::$ACCEPTED,
                static::$NON_AUTHORITATIVE_INFORMATION,
                static::$NO_CONTENT,
                static::$PARTIAL_CONTENT,
                static::$MULTI_STATUS,
                static::$ALREADY_REPORTED,
                static::$IM_USED
            ]
        );
    }

    /**
     * Get all 2xx success status codes
     *
     * @return static[]
     * @throws ReflectionException
     */
    public static function getSuccessStatusCodes(): array
    {
        $codes = [];

        foreach (static::getSuccessStatuses() as $status) {
            $codes[] = $status->value;
        }

        return $codes;
    }

    /**
     * Get all 3xx redirection statuses
     *
     * @return static[]
     *
     * @throws ReflectionException
     */
    public static function getRedirectionStatuses(): array
    {
        return static::generateCollection(
            [
                static::$MULTIPLE_CHOICES,
                static::$MOVED_PERMANENTLY,
                static::$MOVED_TEMPORARILY,
                static::$SEE_OTHER,
                static::$NOT_MODIFIED,
                static::$USE_PROXY,
                static::$SWITCH_PROXY,
                static::$TEMPORARY_REDIRECT,
                static::$PERMANENT_REDIRECT
            ]
        );
    }

    /**
     * Get all 4xx client error statuses
     *
     * @return static[]
     *
     * @throws ReflectionException
     */
    public static function getClientErrorStatuses(): array
    {
        return static::generateCollection(
            [
                static::$BAD_REQUEST,
                static::$UNAUTHORIZED,
                static::$PAYMENT_REQUIRED,
                static::$FORBIDDEN,
                static::$NOT_FOUND,
                static::$METHOD_NOT_ALLOWED,
                static::$NOT_ACCEPTABLE,
                static::$PROXY_AUTHENTICATION_REQUIRED,
                static::$REQUEST_TIMEOUT,
                static::$CONFLICT,
                static::$GONE,
                static::$LENGTH_REQUIRED,
                static::$PRECONDITION_FAILED,
                static::$PAYLOAD_TOO_LARGE,
                static::$URI_TOO_LONG,
                static::$UNSUPPORTED_MEDIA_TYPE,
                static::$RANGE_NOT_SATISFIABLE,
                static::$EXPECTATION_FAILED,
                static::$IM_A_TEAPOT,
                static::$MISDIRECTED_REQUEST,
                static::$UNPROCESSABLE_ENTITY,
                static::$LOCKED,
                static::$FAILED_DEPENDENCY,
                static::$TOO_EARLY,
                static::$UPGRADE_REQUIRED,
                static::$PRECONDITION_REQUIRED,
                static::$TOO_MANY_REQUESTS,
                static::$REQUEST_HEADER_FIELDS_TOO_LARGE,
                static::$UNAVAILABLE_FOR_LEGAL_REASONS,
            ]
        );
    }

    /**
     * Get all 5xx client error statuses
     *
     * @return static[]
     *
     * @throws ReflectionException
     */
    public static function getServerErrorStatuses(): array
    {
        return static::generateCollection(
            [
                static::$INTERNAL_SERVER_ERROR,
                static::$NOT_IMPLEMENTED,
                static::$BAD_GATEWAY,
                static::$SERVICE_UNAVAILABLE,
                static::$GATEWAY_TIMEOUT,
                static::$HTTP_VERSION_NOT_SUPPORTED,
                static::$VARIANT_ALSO_NEGOTIATES,
                static::$INSUFFICIENT_STORAGE,
                static::$LOOP_DETECTED,
                static::$NOT_EXTENDED,
                static::$NETWORK_AUTHENTICATION_REQUIRED
            ]
        );
    }
}

HttpStatusCodeEnum::construct();
