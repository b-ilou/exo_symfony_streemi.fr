<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241002145451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Complete the initial tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE language_media (language_id INT NOT NULL, media_id INT NOT NULL, INDEX IDX_1574A55D82F1BAF4 (language_id), INDEX IDX_1574A55DEA9FDD75 (media_id), PRIMARY KEY(language_id, media_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_categorie (media_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_6C1D65BAEA9FDD75 (media_id), INDEX IDX_6C1D65BABCF5E72D (categorie_id), PRIMARY KEY(media_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE watch_history_media (watch_history_id INT NOT NULL, media_id INT NOT NULL, INDEX IDX_279C548C4D8CCBCC (watch_history_id), INDEX IDX_279C548CEA9FDD75 (media_id), PRIMARY KEY(watch_history_id, media_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE language_media ADD CONSTRAINT FK_1574A55D82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE language_media ADD CONSTRAINT FK_1574A55DEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_categorie ADD CONSTRAINT FK_6C1D65BAEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_categorie ADD CONSTRAINT FK_6C1D65BABCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE watch_history_media ADD CONSTRAINT FK_279C548C4D8CCBCC FOREIGN KEY (watch_history_id) REFERENCES watch_history (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE watch_history_media ADD CONSTRAINT FK_279C548CEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE media_languages');
        $this->addSql('ALTER TABLE categorie_media MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON categorie_media');
        $this->addSql('ALTER TABLE categorie_media ADD categorie_id INT NOT NULL, ADD media_id INT NOT NULL, DROP id');
        $this->addSql('ALTER TABLE categorie_media ADD CONSTRAINT FK_9F544CDCBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_media ADD CONSTRAINT FK_9F544CDCEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_9F544CDCBCF5E72D ON categorie_media (categorie_id)');
        $this->addSql('CREATE INDEX IDX_9F544CDCEA9FDD75 ON categorie_media (media_id)');
        $this->addSql('ALTER TABLE categorie_media ADD PRIMARY KEY (categorie_id, media_id)');
        $this->addSql('ALTER TABLE episode ADD season_id INT NOT NULL');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id)');
        $this->addSql('CREATE INDEX IDX_DDAA1CDA4EC001D1 ON episode (season_id)');
        $this->addSql('ALTER TABLE language ADD language_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE language ADD CONSTRAINT FK_D4DB71B582F1BAF4 FOREIGN KEY (language_id) REFERENCES media (id)');
        $this->addSql('CREATE INDEX IDX_D4DB71B582F1BAF4 ON language (language_id)');
        $this->addSql('ALTER TABLE playlist_media ADD playlist_id INT DEFAULT NULL, ADD media_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE playlist_media ADD CONSTRAINT FK_C930B84F6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id)');
        $this->addSql('ALTER TABLE playlist_media ADD CONSTRAINT FK_C930B84FEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C930B84F6BBD148 ON playlist_media (playlist_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C930B84FEA9FDD75 ON playlist_media (media_id)');
        $this->addSql('ALTER TABLE season ADD serie_id INT NOT NULL');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT FK_F0E45BA9D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('CREATE INDEX IDX_F0E45BA9D94388BD ON season (serie_id)');
        $this->addSql('ALTER TABLE subscription ADD subscription_history_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3DCE0C437 FOREIGN KEY (subscription_history_id) REFERENCES subscription_history (id)');
        $this->addSql('CREATE INDEX IDX_A3C664D3DCE0C437 ON subscription (subscription_history_id)');
        $this->addSql('ALTER TABLE user ADD subscription_history_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649DCE0C437 FOREIGN KEY (subscription_history_id) REFERENCES subscription_history (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649DCE0C437 ON user (subscription_history_id)');
        $this->addSql('ALTER TABLE watch_history ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE watch_history ADD CONSTRAINT FK_DE44EFD8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DE44EFD8A76ED395 ON watch_history (user_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE media_languages (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE language_media DROP FOREIGN KEY FK_1574A55D82F1BAF4');
        $this->addSql('ALTER TABLE language_media DROP FOREIGN KEY FK_1574A55DEA9FDD75');
        $this->addSql('ALTER TABLE media_categorie DROP FOREIGN KEY FK_6C1D65BAEA9FDD75');
        $this->addSql('ALTER TABLE media_categorie DROP FOREIGN KEY FK_6C1D65BABCF5E72D');
        $this->addSql('ALTER TABLE watch_history_media DROP FOREIGN KEY FK_279C548C4D8CCBCC');
        $this->addSql('ALTER TABLE watch_history_media DROP FOREIGN KEY FK_279C548CEA9FDD75');
        $this->addSql('DROP TABLE language_media');
        $this->addSql('DROP TABLE media_categorie');
        $this->addSql('DROP TABLE watch_history_media');
        $this->addSql('ALTER TABLE categorie_media DROP FOREIGN KEY FK_9F544CDCBCF5E72D');
        $this->addSql('ALTER TABLE categorie_media DROP FOREIGN KEY FK_9F544CDCEA9FDD75');
        $this->addSql('DROP INDEX IDX_9F544CDCBCF5E72D ON categorie_media');
        $this->addSql('DROP INDEX IDX_9F544CDCEA9FDD75 ON categorie_media');
        $this->addSql('ALTER TABLE categorie_media ADD id INT AUTO_INCREMENT NOT NULL, DROP categorie_id, DROP media_id, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA4EC001D1');
        $this->addSql('DROP INDEX IDX_DDAA1CDA4EC001D1 ON episode');
        $this->addSql('ALTER TABLE episode DROP season_id');
        $this->addSql('ALTER TABLE language DROP FOREIGN KEY FK_D4DB71B582F1BAF4');
        $this->addSql('DROP INDEX IDX_D4DB71B582F1BAF4 ON language');
        $this->addSql('ALTER TABLE language DROP language_id');
        $this->addSql('ALTER TABLE playlist_media DROP FOREIGN KEY FK_C930B84F6BBD148');
        $this->addSql('ALTER TABLE playlist_media DROP FOREIGN KEY FK_C930B84FEA9FDD75');
        $this->addSql('DROP INDEX UNIQ_C930B84F6BBD148 ON playlist_media');
        $this->addSql('DROP INDEX UNIQ_C930B84FEA9FDD75 ON playlist_media');
        $this->addSql('ALTER TABLE playlist_media DROP playlist_id, DROP media_id');
        $this->addSql('ALTER TABLE season DROP FOREIGN KEY FK_F0E45BA9D94388BD');
        $this->addSql('DROP INDEX IDX_F0E45BA9D94388BD ON season');
        $this->addSql('ALTER TABLE season DROP serie_id');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D3DCE0C437');
        $this->addSql('DROP INDEX IDX_A3C664D3DCE0C437 ON subscription');
        $this->addSql('ALTER TABLE subscription DROP subscription_history_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649DCE0C437');
        $this->addSql('DROP INDEX IDX_8D93D649DCE0C437 ON user');
        $this->addSql('ALTER TABLE user DROP subscription_history_id');
        $this->addSql('ALTER TABLE watch_history DROP FOREIGN KEY FK_DE44EFD8A76ED395');
        $this->addSql('DROP INDEX UNIQ_DE44EFD8A76ED395 ON watch_history');
        $this->addSql('ALTER TABLE watch_history DROP user_id');
    }
}
