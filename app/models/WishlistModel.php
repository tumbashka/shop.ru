<?php

namespace app\models;

use RedBeanPHP\R;

class WishlistModel extends AppModel
{
    public function getProduct($id)
    {
        return R::getCell("SELECT id FROM product WHERE status = 1 AND id = ?", [$id]);
    }

    public function addProductToWishlist($id)
    {
        $wishlist = self::getWishlistIDs();
        if (!$wishlist) {
            setcookie("wishlist", $id, time() + (3600 * 24 * 30), "/");
        } else {
            if (!in_array($id, $wishlist)) {
                $wishlist[] = $id;
                if (count($wishlist) > 6) {
                    array_shift($wishlist);
                }
                $wishlist = implode(',', $wishlist);
                setcookie("wishlist", $wishlist, time() + (3600 * 24 * 30), "/");
            }
        }
    }

    public function deleteProductFromWishlist($id)
    {
        $ids = self::getWishlistIDs();
        unset($ids[array_search($id, $ids)]);
        $ids = implode(',', $ids);
        setcookie("wishlist", $ids, time() + (3600 * 24 * 30), "/");
    }

    public function isWishlistProduct($id): bool
    {
        return in_array($id, self::getWishlistIDs());
    }

    public static function getWishlistIDs(): array
    {
        $wishlist = $_COOKIE['wishlist'] ?? '';
        if ($wishlist) {
            $wishlist = explode(',', $wishlist);
        }
        if (is_array($wishlist)) {
            $wishlist = array_slice($wishlist, 0, 6);
            $wishlist = array_map('intval', $wishlist);
            return $wishlist;
        }
        return [];
    }

    public function getWishlistProducts($lang): array
    {
        $ids = self::getWishlistIDs();
        if (!$ids) {
            return [];
        }
        $ids = implode(',', $ids);
        return R::getAll("SELECT p.*, pd.* FROM product AS p 
                    JOIN shop.product_description AS pd on p.id = pd.product_id
                    WHERE p.status = 1 AND p.id IN ({$ids}) AND pd.language_id = ?", [$lang['id']]);
    }
}