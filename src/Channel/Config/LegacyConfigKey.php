<?php

namespace FluxIliasApi\Channel\Config;

use FluxIliasApi\Libs\FluxLegacyEnum\Adapter\Backed\LegacyStringBackedEnum;

/**
 * @method static static API_PROXY_MAP() api_proxy_map
 * @method static static ENABLE_API_PROXY() enable_api_proxy
 * @method static static ENABLE_LOG_CHANGES() enable_log_changes
 * @method static static ENABLE_PURGE_CHANGES() enable_purge_changes
 * @method static static ENABLE_REST_API() enable_rest_api
 * @method static static ENABLE_TRANSFER_CHANGES() enable_transfer_changes
 * @method static static ENABLE_WEB_PROXY() enable_web_proxy
 * @method static static KEEP_CHANGES_INSIDE_DAYS() keep_changes_inside_days
 * @method static static LAST_TRANSFERRED_CHANGE_TIME() last_transferred_change_time
 * @method static static PURGE_CHANGES_SCHEDULE() purge_changes_schedule
 * @method static static TRANSFER_CHANGES_POST_URL() transfer_changes_post_url
 * @method static static TRANSFER_CHANGES_SCHEDULE() transfer_changes_schedule
 * @method static static WEB_PROXY_IFRAME_HEIGHT_OFFSET() web_proxy_iframe_height_offset
 * @method static static WEB_PROXY_MAP() web_proxy_map
 */
class LegacyConfigKey extends LegacyStringBackedEnum
{

}
