<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190715144351 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, image_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, token VARCHAR(255) DEFAULT NULL, date_token DATETIME NOT NULL, token_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_C4E0A61F68011AFE (image_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, image_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, UNIQUE INDEX UNIQ_D34A04AD68011AFE (image_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, player_id_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_F5299398C036E511 (player_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_product (order_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_2530ADE68D9F6D38 (order_id), INDEX IDX_2530ADE64584665A (product_id), PRIMARY KEY(order_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, src VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, equipe_id_id INT DEFAULT NULL, image_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_98197A65254808DD (equipe_id_id), UNIQUE INDEX UNIQ_98197A6568011AFE (image_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F68011AFE FOREIGN KEY (image_id_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD68011AFE FOREIGN KEY (image_id_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398C036E511 FOREIGN KEY (player_id_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE68D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE64584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65254808DD FOREIGN KEY (equipe_id_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A6568011AFE FOREIGN KEY (image_id_id) REFERENCES image (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65254808DD');
        $this->addSql('ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE64584665A');
        $this->addSql('ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE68D9F6D38');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F68011AFE');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD68011AFE');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A6568011AFE');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398C036E511');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_product');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE player');
    }
}
