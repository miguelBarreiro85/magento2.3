DELETE FROM `catalog_product_entity`;
ALTER TABLE `catalog_product_entity` AUTO_INCREMENT =1;
DELETE FROM url_rewrite WHERE entity_type='product';