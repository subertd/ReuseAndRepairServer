SELECT
  i.`item_id`,
  c.`category_name`,
  o.`organization_id`,
  o.`organization_name`,
  o.`phone_number` AS organization_phone_number,
  o.`website_url` AS organization_website_url,
  o.`physical_address` AS organization_physical_address

FROM
  `cs419-g15`.`Item` i

# using left joins will eliminate categories with no items
# and organizations that do not reuse/rebuild any items
# while preserving items with no organizations that reuse/rebuild them
# this seems appropriate

# supply the category name for each item's category reference
LEFT JOIN `cs419-g15`.`Category` c ON i.`category_id` = c.`category_id`

# get all the relationships between items and organizations
LEFT JOIN `cs419-g15`.`Organization_Item` oi ON oi.`item_id` = i.`item_id`
LEFT JOIN `cs419-g15`.`Organization` o ON o.`organization_id` = oi.`organization_id`;
