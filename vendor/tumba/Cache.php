<?php

namespace tumba;

class Cache
{
    use TSingleton;

    public function set($key, $data, $seconds = 3600): bool
    {
        $content['data'] = $data;
        $content['end_time'] = time() + $seconds;
        return (bool)file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content));
    }

    public function get($key)
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)) {
            $content = unserialize(file_get_contents($file));
            if (time() <= $content['end_time']) {
                return $content['data'];
            } else unlink($file);
        }
        return false;
    }

    public function delete(string $key): bool
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)) {
            return unlink($file);
        }
        return false;
    }


}