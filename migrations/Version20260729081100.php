<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260729081100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE batiment (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE batiments ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE batiments ADD CONSTRAINT FK_124D7990A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_124D7990A76ED395 ON batiments (user_id)');
        $this->addSql('ALTER TABLE bloc ADD CONSTRAINT FK_C778955AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE fermes ADD CONSTRAINT FK_6E023AD9A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE magasin ADD CONSTRAINT FK_54AF5F27F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE magasin ADD CONSTRAINT FK_54AF5F27A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE batiment');
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A98456F347EFB');
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A98456A76ED395');
        $this->addSql('ALTER TABLE batiments DROP FOREIGN KEY FK_124D7990A76ED395');
        $this->addSql('DROP INDEX IDX_124D7990A76ED395 ON batiments');
        $this->addSql('ALTER TABLE batiments DROP user_id');
        $this->addSql('ALTER TABLE bloc DROP FOREIGN KEY FK_C778955AA76ED395');
        $this->addSql('ALTER TABLE fermes DROP FOREIGN KEY FK_6E023AD9A76ED395');
        $this->addSql('ALTER TABLE magasin DROP FOREIGN KEY FK_54AF5F27F347EFB');
        $this->addSql('ALTER TABLE magasin DROP FOREIGN KEY FK_54AF5F27A76ED395');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27A76ED395');
    }
}
