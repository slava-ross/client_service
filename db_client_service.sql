CREATE TABLE `natural` (
    `id` bigint(20) UNSIGNED NOT NULL,
    `fio` varchar(100) NOT NULL,
    `inn` char(12) NOT NULL,
    `birthdate` date NOT NULL,
    `pass_serial` char(4) NOT NULL,
    `pass_number` char(6) NOT NULL,
    `pass_issue` date NOT NULL
);

ALTER TABLE `natural`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `natural_inn_unique` (`inn`),
    ADD UNIQUE KEY `natural_passport_unique` (`pass_serial`,`pass_number`);

CREATE TABLE `legal` (
   `id` bigint(20) UNSIGNED NOT NULL,
   `chief_fio` varchar(100) NOT NULL,
   `chief_inn` char(12) NOT NULL,
   `name` varchar(100) NOT NULL,
   `address` varchar(255) NOT NULL,
   `legal_inn` char(12) NOT NULL,
   `ogrn` char(13) NOT NULL,
   `kpp` char(9) NOT NULL
);

ALTER TABLE `legal`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `legal_inn_kpp_unique` (`legal_inn`,`kpp`),
    ADD UNIQUE KEY `legal_ogrn_unique` (`ogrn`);

/******************************************************************************/

CREATE TABLE `credit` (
     `id` bigint(20) UNSIGNED NOT NULL,
     `open_date` date NOT NULL,
     `close_date` date NOT NULL,
     `term` TINYINT UNSIGNED NOT NULL,
     `payout_type` char(1) NOT NULL,
     `amount` decimal(13,4) NOT NULL
);

ALTER TABLE `credit`
    ADD PRIMARY KEY (`id`);

CREATE TABLE `deposit` (
                          `id` bigint(20) UNSIGNED NOT NULL,
                          `open_date` date NOT NULL,
                          `close_date` date NOT NULL,
                          `term` TINYINT UNSIGNED NOT NULL,
                          `rate` TINYINT UNSIGNED NOT NULL,
                          `reinvest` char(3) NOT NULL
);

ALTER TABLE `deposit`
    ADD PRIMARY KEY (`id`);

/******************************************************************************/

CREATE TABLE `product_customer` (
   `id` bigint(20) UNSIGNED NOT NULL,
   `deposit_id` bigint(20) UNSIGNED,
   `credit_id` bigint(20) UNSIGNED,
   `natural_id` bigint(20) UNSIGNED,
   `legal_id` bigint(20) UNSIGNED
);

ALTER TABLE `product_customer`
    ADD PRIMARY KEY (`id`),
    ADD KEY `product_customer_credit_id_foreign` (`credit_id`),
    ADD KEY `product_customer_deposit_id_foreign` (`deposit_id`),
    ADD KEY `customer_customer_natural_id_foreign` (`natural_id`),
    ADD KEY `customer_customer_legal_id_foreign` (`legal_id`);

ALTER TABLE `product_customer`
    ADD CONSTRAINT `product_customer_credit_id_foreign` FOREIGN KEY (`credit_id`) REFERENCES `credit` (`id`),
    ADD CONSTRAINT `product_customer_deposit_id_foreign` FOREIGN KEY (`deposit_id`) REFERENCES `deposit` (`id`),
    ADD CONSTRAINT `product_customer_natural_id_foreign` FOREIGN KEY (`natural_id`) REFERENCES `natural` (`id`),
    ADD CONSTRAINT `product_customer_legal_id_foreign` FOREIGN KEY (`legal_id`) REFERENCES `legal` (`id`);

/******************************************************************************

CREATE TABLE `product` (
   `id` bigint(20) UNSIGNED NOT NULL,
   `deposit_id` bigint(20) UNSIGNED,
   `credit_id` bigint(20) UNSIGNED
);

ALTER TABLE `product`
    ADD PRIMARY KEY (`id`),
    ADD KEY `product_credit_id_foreign` (`credit_id`),
    ADD KEY `product_deposit_id_foreign` (`deposit_id`);

ALTER TABLE `product`
    ADD CONSTRAINT `product_credit_id_foreign` FOREIGN KEY (`credit_id`) REFERENCES `credit` (`id`),
    ADD CONSTRAINT `product_deposit_id_foreign` FOREIGN KEY (`deposit_id`) REFERENCES `deposit` (`id`);

******************************************************************************

CREATE TABLE `customer` (
   `id` bigint(20) UNSIGNED NOT NULL,
   `natural_id` bigint(20) UNSIGNED,
   `legal_id` bigint(20) UNSIGNED
);

ALTER TABLE `customer`
    ADD PRIMARY KEY (`id`),
    ADD KEY `customer_natural_id_foreign` (`natural_id`),
    ADD KEY `customer_legal_id_foreign` (`legal_id`);

ALTER TABLE `customer`
    ADD CONSTRAINT `customer_natural_id_foreign` FOREIGN KEY (`natural_id`) REFERENCES `natural` (`id`),
    ADD CONSTRAINT `customer_legal_id_foreign` FOREIGN KEY (`legal_id`) REFERENCES `legal` (`id`);

******************************************************************************/

