CREATE TABLE `snif` (
    `snif_id` int(11) NOT NULL AUTO_INCREMENT,
    `snif_time` varchar(255) NULL,
    `snif_code` varchar(255) NULL,
    `snif_size` varchar(255) NULL,
    `snif_type` varchar(255) NULL,
    `snif_base64` TEXT CHARACTER SET ascii NULL,
    PRIMARY KEY (snif_id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;