<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php
/**
 * Elasticsearch PHP client
 *
 * @link      https://github.com/elastic/elasticsearch-php/
 * @copyright Copyright (c) Elasticsearch B.V (https://www.elastic.co)
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license   https://www.gnu.org/licenses/lgpl-2.1.html GNU Lesser General Public License, Version 2.1 
 * 
 * Licensed to Elasticsearch B.V under one or more agreements.
 * Elasticsearch B.V licenses this file to you under the Apache 2.0 License or
 * the GNU Lesser General Public License, Version 2.1, at your option.
 * See the LICENSE file in the project root for more information.
 */
declare(strict_types = 1);

namespace Elasticsearch\Endpoints\Security;

use Elasticsearch\Common\Exceptions\RuntimeException;
use Elasticsearch\Endpoints\AbstractEndpoint;

/**
 * Class ClearApiKeyCache
 * Elasticsearch API name security.clear_api_key_cache
 *
 * NOTE: this file is autogenerated using util/GenerateEndpoints.php
 * and Elasticsearch 8.0.0-SNAPSHOT (ca2fb5c7ee55464068a6581480e9db6ebe569e6d)
 */
class ClearApiKeyCache extends AbstractEndpoint
{
    protected $ids;

    public function getURI(): string
    {
        $ids = $this->ids ?? null;

        if (isset($ids)) {
            return "/_security/api_key/$ids/_clear_cache";
        }
        throw new RuntimeException('Missing parameter for the endpoint security.clear_api_key_cache');
    }

    public function getParamWhitelist(): array
    {
        return [
            
        ];
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function setIds($ids): ClearApiKeyCache
    {
        if (isset($ids) !== true) {
            return $this;
        }
        if (is_array($ids) === true) {
            $ids = implode(",", $ids);
        }
        $this->ids = $ids;

        return $this;
    }
}
