<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190715145538 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F68011AFE');
        $this->addSql('DROP INDEX UNIQ_C4E0A61F68011AFE ON team');
        $this->addSql('ALTER TABLE team CHANGE image_id_id image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C4E0A61F3DA5256D ON team (image_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD68011AFE');
        $this->addSql('DROP INDEX UNIQ_D34A04AD68011AFE ON product');
        $this->addSql('ALTER TABLE product CHANGE image_id_id image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD3DA5256D ON product (image_id)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398C036E511');
        $this->addSql('DROP INDEX IDX_F5299398C036E511 ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE player_id_id player_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939899E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('CREATE INDEX IDX_F529939899E6F5DF ON `order` (player_id)');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65254808DD');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A6568011AFE');
        $this->addSql('DROP INDEX IDX_98197A65254808DD ON player');
        $this->addSql('DROP INDEX UNIQ_98197A6568011AFE ON player');
        $this->addSql('ALTER TABLE player ADD equipe_id INT DEFAULT NULL, ADD image_id INT DEFAULT NULL, DROP equipe_id_id, DROP image_id_id');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A656D861B89 FOREIGN KEY (equipe_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A653DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_98197A656D861B89 ON player (equipe_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98197A653DA5256D ON player (image_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939899E6F5DF');
        $this->addSql('DROP INDEX IDX_F529939899E6F5DF ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE player_id player_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398C036E511 FOREIGN KEY (player_id_id) REFERENCES player (id)');
        $this->addSql('CREATE INDEX IDX_F5299398C036E511 ON `order` (player_id_id)');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A656D861B89');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A653DA5256D');
        $this->addSql('DROP INDEX IDX_98197A656D861B89 ON player');
        $this->addSql('DROP INDEX UNIQ_98197A653DA5256D ON player');
        $this->addSql('ALTER TABLE player ADD equipe_id_id INT DEFAULT NULL, ADD image_id_id INT DEFAULT NULL, DROP equipe_id, DROP image_id');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65254808DD FOREIGN KEY (equipe_id_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A6568011AFE FOREIGN KEY (image_id_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_98197A65254808DD ON player (equipe_id_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98197A6568011AFE ON player (image_id_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD3DA5256D');
        $this->addSql('DROP INDEX UNIQ_D34A04AD3DA5256D ON product');
        $this->addSql('ALTER TABLE product CHANGE image_id image_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD68011AFE FOREIGN KEY (image_id_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD68011AFE ON product (image_id_id)');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F3DA5256D');
        $this->addSql('DROP INDEX UNIQ_C4E0A61F3DA5256D ON team');
        $this->addSql('ALTER TABLE team CHANGE image_id image_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F68011AFE FOREIGN KEY (image_id_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C4E0A61F68011AFE ON team (image_id_id)');
    }
}
