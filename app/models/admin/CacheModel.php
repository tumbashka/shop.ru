<?php

namespace app\models\admin;

use app\models\AppModel;
use tumba\Cache;

class CacheModel extends AppModel
{

    public function deleteCache(string $cacheKey): bool
    {
        $cache = Cache::getInstance();
        return $cache->delete($cacheKey);
    }
}