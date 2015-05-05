<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 6:07 PM
 */

namespace ReuseAndRepair\Models;


class OrganizationFactory {

    const ID = "id";
    const NAME = "name";
    const PHONE_NUMBER = "phoneNumber";
    const PHYSICAL_ADDRESS = "physicalAddress";
    const WEBSITE_URL = "websiteUrl";

    public static function getInstance(array $params) {

        /** @var Organization $organization */
        $organization = new Organization();

        if (empty($params[OrganizationFactory::NAME])
            || empty($params[OrganizationFactory::PHONE_NUMBER])
            || empty($params[OrganizationFactory::WEBSITE_URL])
            || empty($params[OrganizationFactory::PHYSICAL_ADDRESS]))
        {
            throw new ModelException("Missing Parameters");
        }

        if (!empty($params[OrganizationFactory::ID])
            && is_numeric(($id = $params[OrganizationFactory::ID])))
        {
            $organization->setId($id);
        }

        $organization->setName($params[
            OrganizationFactory::NAME]);

        $organization->setPhoneNumber($params[
            OrganizationFactory::PHONE_NUMBER]);

        $organization->setWebsiteUrl($params[
            OrganizationFactory::WEBSITE_URL]);

        $organization->setPhysicalAddress($params[
            OrganizationFactory::PHYSICAL_ADDRESS]);

        return $organization;
    }
}