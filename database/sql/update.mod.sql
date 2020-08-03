ALTER TABLE `products` ADD `isopen_coupon` INT(1) NOT NULL DEFAULT '1' AFTER `pd_class`;
INSERT INTO `admin_menu` (`id`, `parent_id`, `order`, `title`, `icon`, `uri`, `permission`, `created_at`, `updated_at`) VALUES
(26, 8, 10, '待支付订单', 'fa-map-signs', 'pending_orders', NULL, '2020-07-23 09:50:10', '2020-07-23 09:50:29');
ALTER TABLE `products` ADD COLUMN `stock_alert` int(11) NOT NULL DEFAULT 0 COMMENT '库存预警' AFTER `in_stock`;

INSERT INTO `emailtpls`(`tpl_name`, `tpl_content`, `tpl_token`, `created_at`, `updated_at`) VALUES
('【{webname}】商品库存预警!', '<p><span style=\"\">尊敬的管理员：</span></p><p><span style=\"\">商品：<span style=\"\"><span style=\"\">【{product_name}】</span></span> 库存已不足</span><span style=\"\"><span style=\"\">【{stock_alert}】</span></span> ，剩余库存<span style=\"\"><span style=\"\">【{in_stock}】</span></span>，请及时添加上货。<p style=\"margin-left: 40px;\"><b>来自{webname} -{weburl}</b></p>', 'manual_send_stock_alert_mail', '2020-05-27 02:10:43', '2020-05-27 02:52:33');

INSERT INTO `admin_menu`(`parent_id`, `order`, `title`, `icon`, `uri`, `permission`, `created_at`, `updated_at`) VALUES
( 0, 19, '文章管理', 'fa-pencil', '/pages', NULL, '2020-05-23 21:18:43', '2020-05-23 21:18:59');

INSERT INTO `pays`( `pay_name`, `pay_check`, `pay_method`, `merchant_id`, `merchant_key`, `merchant_pem`, `pay_handleroute`, `pay_status`, `created_at`, `updated_at`) VALUES
('V免签支付宝', 'vzfb', 'dump', 'v免签通讯密钥', NULL, 'V免签地址 例如 https://vpay.qq.com/    结尾必须有/', 'pay/vpay', 1, '2020-05-01 13:15:56', '2020-05-01 13:18:29'),
('V免签微信', 'vwx', 'dump', 'V免签通讯密钥', NULL, 'V免签地址 例如 https://vpay.qq.com/    结尾必须有/', 'pay/vpay', 1, '2020-05-01 13:17:28', '2020-05-01 13:18:38');


ALTER TABLE `classifys` ADD COLUMN `passwd` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL AFTER `ord`;
ALTER TABLE `products` ADD COLUMN `passwd` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL AFTER `pd_info`;
ALTER TABLE `webset` ADD COLUMN `layerad` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL AFTER `notice`;

CREATE TABLE `pages`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '标题',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '内容',
  `status` int(1) NOT NULL COMMENT '状态1启用 2停用	',
  `tag` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '标识',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;
SET FOREIGN_KEY_CHECKS = 1;