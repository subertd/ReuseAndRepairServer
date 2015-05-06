<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/5/2015
 * Time: 12:34 PM
 */

namespace ReuseAndRepair\Models;


class ItemFactory {

    const ID = "itemId";
    const NAME = "itemName";
    const CATEGORY_REF = "categoryRef";

    /**
     * Returns a new instance of an item, setting its fields from the parameters
     *
     * @param array $params the parameters
     * @return Item the new instance
     * @throws ModelException if the parameters are missing one or more
     * required fields
     */
    public static function getInstance(array $params) {

        /** @var Item $item */
        $item = new Item();

        if (empty($params[self::NAME])
            || empty($params[self::CATEGORY_REF])
            || !is_numeric($params[self::CATEGORY_REF])
            || !( ( ( (float) $params[self::CATEGORY_REF]) % 1) == 0)
        ) {
            print_r($params);
            throw new ModelException("Missing Parameters");
        }

        if (!empty($params[self::ID])
            && is_numeric(($id = $params[self::ID]))
            && (( (float) $params[self::ID]) % 1 == 0)
        ) {
            $item->setId( (int) $params[self::ID]);
        }

        $item->setName($params[self::NAME]);
        $item->setCategoryRef( (int) $params[self::CATEGORY_REF]);

        return $item;
    }
}