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

    const ID = "organizationId";
    const NAME = "organizationName";
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

        if (empty($params[self::NAME]))
        {
            throw new ModelException("Missing Parameter " . self::NAME);
        }

        if (!empty($params[self::ID])
            && is_numeric(($id = $params[self::ID]))
            && (( (float) $params[self::ID]) % 1 == 0)
        ) {
            $organization->setId( (int) $params[self::ID]);
        }

        $organization->setName($params[self::NAME]);
        $organization->setPhoneNumber(isset($params[self::PHONE_NUMBER]) ? $params[self::PHONE_NUMBER] : "");
        $organization->setWebsiteUrl(isset($params[self::WEBSITE_URL]) ? $params[self::WEBSITE_URL] : "");
        $organization->setPhysicalAddress(isset($params[self::PHYSICAL_ADDRESS]) ? $params[self::PHYSICAL_ADDRESS] : "");

        return $organization;
    }
}