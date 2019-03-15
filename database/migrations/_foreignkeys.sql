ALTER TABLE sales CHANGE user_id user_id INT UNSIGNED NOT NULL, CHANGE product_id product_id INT UNSIGNED  NOT NULL;
alter table `sales` add index `sales_product_id_index`(`product_id`);
alter table `sales` add constraint `sales_product_id_foreign` foreign key (`product_id`) references `products` (`id`) on delete cascade;
alter table `sales` add index `sales_user_id_index`(`user_id`);
alter table `sales` add constraint `sales_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete cascade;

ALTER TABLE actions CHANGE user_id user_id INT UNSIGNED NOT NULL, CHANGE product_id product_id INT UNSIGNED NOT NULL;
alter table `actions` add index `actions_product_id_index`(`product_id`);
alter table `actions` add constraint `actions_product_id_foreign` foreign key (`product_id`) references `products` (`id`) on delete cascade;
alter table `actions` add index `actions_user_id_index`(`user_id`);
alter table `actions` add constraint `actions_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete cascade;

ALTER TABLE variants CHANGE product_id product_id INT UNSIGNED  NOT NULL;
alter table `variants` add index `variants_product_id_index`(`product_id`);
alter table `variants` add constraint `variants_product_id_foreign` foreign key (`product_id`) references `products` (`id`) on delete cascade;

ALTER TABLE products CHANGE category_id category_id INT UNSIGNED NOT NULL;
alter table `products` add index `products_category_id_index`(`category_id`);
alter table `products` add constraint `products_category_id_foreign` foreign key (`category_id`) references `categories` (`id`) on delete cascade;
