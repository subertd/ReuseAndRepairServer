<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 6:07 PM
 */

namespace ReuseAndRepair\Models;


/**
 * Class OrganizationFactory
 * @package ReuseAndRepair\Models
 *
 * Creates an instance of an organization, setting its fields as appropriate
 */
class OrganizationFactory {

    const ID = "id";
    const NAME = "name";
    const PHONE_NUMBER = "phoneNumber";
    const PHYSICAL_ADDRESS = "physicalAddress";
    const WEBSITE_URL = "websiteUrl";

    /**
     * Returns a new instance of an organization, setting its fields from
     * the parameters
     *
     * @param array $params the parameters
     * @return Organization the new instance
     * @throws ModelException if the parameters are missing one or more required
     * fields
     */
    public static function getInstance(array $params) {

        /** @var Organization $organization */
        $organization = new Organization();

        if (empty($params[self::NAME])
            || empty($params[self::PHONE_NUMBER])
            || empty($params[self::WEBSITE_URL])
            || empty($params[self::PHYSICAL_ADDRESS]))
        {
            throw new ModelException("Missing Parameters");
        }

        if (!empty($params[self::ID])
            && is_numeric(($id = $params[self::ID]))
            && (( (float) $params[self::ID]) % 1 == 0)
        ) {
            $organization->setId( (int) $params[self::ID]);
        }

        $organization->setName($params[self::NAME]);
        $organization->setPhoneNumber($params[self::PHONE_NUMBER]);
        $organization->setWebsiteUrl($params[self::WEBSITE_URL]);
        $organization->setPhysicalAddress($params[self::PHYSICAL_ADDRESS]);

        return $organization;
    }
}