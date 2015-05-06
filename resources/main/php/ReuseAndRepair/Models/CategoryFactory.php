<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/5/2015
 * Time: 12:26 PM
 */

namespace ReuseAndRepair\Models;


/**
 * Class CategoryFactory
 * @package ReuseAndRepair\Models
 *
 * Creates an instance of a category, setting its fields as appropriate
 */
class CategoryFactory {

    const ID = "categoryId";
    const NAME = "categoryName";

    /**
     * Returns a new instance of a category, setting its fields from the
     * parameters
     *
     * @param array $params the parameters
     * @return Category the new instance
     * @throws ModelException if the parameters are missing from one or more
     * required fields
     */
    public static function getInstance(array $params) {

        /** @var Category category */
        $category = new Category();

        if (empty($params[self::NAME])) {
            throw new ModelException("Missing parameter: " . self::NAME);
        }

        if (!empty($params[self::ID])
            && is_numeric(($id = $params[self::ID]))
            && (( (float) $params[self::ID]) % 1 == 0)
        ) {
            $category->setId( (int) $params[self::ID]);
        }

        $category->setName($params[self::NAME]);

        return $category;
    }
}