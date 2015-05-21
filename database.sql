CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT '(DC2Type:array)', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, fullname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE fos_user_group (user_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_583D1F3EA76ED395 (user_id), INDEX IDX_583D1F3EFE54D947 (group_id), PRIMARY KEY(user_id, group_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE fos_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT '(DC2Type:array)', UNIQUE INDEX UNIQ_4B019DDB5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE bd_page (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, tags VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, owner_id INT NOT NULL, published_on DATETIME NOT NULL, created_on DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE elfinder_file (id INT AUTO_INCREMENT NOT NULL, parent_id INT NOT NULL, name VARCHAR(255) NOT NULL, content LONGBLOB NOT NULL, size INT NOT NULL, mtime INT NOT NULL, mime VARCHAR(255) NOT NULL, `read` VARCHAR(255) NOT NULL, `write` VARCHAR(255) NOT NULL, locked VARCHAR(255) NOT NULL, hidden VARCHAR(255) NOT NULL, width INT NOT NULL, height INT NOT NULL, INDEX parent_id (parent_id), UNIQUE INDEX parent_name (parent_id, name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE fos_user_group ADD CONSTRAINT FK_583D1F3EA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id);
ALTER TABLE fos_user_group ADD CONSTRAINT FK_583D1F3EFE54D947 FOREIGN KEY (group_id) REFERENCES fos_group (id);
