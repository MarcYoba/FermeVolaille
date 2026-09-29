<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260808101503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vaccination (id INT AUTO_INCREMENT NOT NULL, vaccin VARCHAR(255) NOT NULL, date_prevue DATETIME NOT NULL, date_realisee DATETIME DEFAULT NULL, responsable VARCHAR(255) DEFAULT NULL, dose VARCHAR(100) DEFAULT NULL, voie_administration VARCHAR(150) DEFAULT NULL, statut VARCHAR(50) NOT NULL, bande_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_1B09999911999B4A (bande_id), INDEX IDX_1B099999A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE vaccination ADD CONSTRAINT FK_1B09999911999B4A FOREIGN KEY (bande_id) REFERENCES bandes (id)');
        $this->addSql('ALTER TABLE vaccination ADD CONSTRAINT FK_1B099999A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE aliment ADD CONSTRAINT FK_70FF972BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE bandes ADD CONSTRAINT FK_150D0DA718981132 FOREIGN KEY (ferme_id) REFERENCES fermes (id)');
        $this->addSql('ALTER TABLE bandes ADD CONSTRAINT FK_150D0DA76DC28240 FOREIGN KEY (batiments_id) REFERENCES batiments (id)');
        $this->addSql('ALTER TABLE bandes ADD CONSTRAINT FK_150D0DA7A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE batiments ADD CONSTRAINT FK_124D7990A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE batiments ADD CONSTRAINT FK_124D79905582E9C0 FOREIGN KEY (bloc_id) REFERENCES bloc (id)');
        $this->addSql('ALTER TABLE bloc ADD CONSTRAINT FK_C778955AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE cout_sanitaire ADD CONSTRAINT FK_7B8B4874A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE cout_sanitaire ADD CONSTRAINT FK_7B8B4874CC72D953 FOREIGN KEY (sortie_id) REFERENCES sortie (id)');
        $this->addSql('ALTER TABLE entree ADD CONSTRAINT FK_598377A6A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE entree ADD CONSTRAINT FK_598377A6670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE entree ADD CONSTRAINT FK_598377A6A8CBA5F7 FOREIGN KEY (lot_id) REFERENCES lot (id)');
        $this->addSql('ALTER TABLE fermes ADD CONSTRAINT FK_6E023AD9A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE fournisseur ADD CONSTRAINT FK_369ECA32A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291BAB0D61F7 FOREIGN KEY (medicament_id) REFERENCES medicament (id)');
        $this->addSql('ALTER TABLE magasin ADD CONSTRAINT FK_54AF5F27F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE magasin ADD CONSTRAINT FK_54AF5F27A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE magasin_dedier ADD CONSTRAINT FK_9E5FC1DAD6F6891B FOREIGN KEY (batiment_id) REFERENCES batiments (id)');
        $this->addSql('ALTER TABLE magasin_dedier ADD CONSTRAINT FK_9E5FC1DAF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE magasin_dedier ADD CONSTRAINT FK_9E5FC1DAA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE medicament ADD CONSTRAINT FK_9A9C723AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE mouvement_stock ADD CONSTRAINT FK_61E2C8EB415B9F11 FOREIGN KEY (aliment_id) REFERENCES aliment (id)');
        $this->addSql('ALTER TABLE mouvement_stock ADD CONSTRAINT FK_61E2C8EB11999B4A FOREIGN KEY (bande_id) REFERENCES bandes (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE mouvement_stock ADD CONSTRAINT FK_61E2C8EBA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE pesees ADD CONSTRAINT FK_D22ED8211999B4A FOREIGN KEY (bande_id) REFERENCES bandes (id)');
        $this->addSql('ALTER TABLE pesees ADD CONSTRAINT FK_D22ED82A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2A8CBA5F7 FOREIGN KEY (lot_id) REFERENCES lot (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2DDA344B6 FOREIGN KEY (traitement_id) REFERENCES traitement (id)');
        $this->addSql('ALTER TABLE suivi ADD CONSTRAINT FK_2EBCCA8FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE suivi ADD CONSTRAINT FK_2EBCCA8F11999B4A FOREIGN KEY (bande_id) REFERENCES bandes (id)');
        $this->addSql('ALTER TABLE traitement ADD CONSTRAINT FK_2A356D27A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vaccination DROP FOREIGN KEY FK_1B09999911999B4A');
        $this->addSql('ALTER TABLE vaccination DROP FOREIGN KEY FK_1B099999A76ED395');
        $this->addSql('DROP TABLE vaccination');
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A98456F347EFB');
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A98456A76ED395');
        $this->addSql('ALTER TABLE aliment DROP FOREIGN KEY FK_70FF972BA76ED395');
        $this->addSql('ALTER TABLE bandes DROP FOREIGN KEY FK_150D0DA718981132');
        $this->addSql('ALTER TABLE bandes DROP FOREIGN KEY FK_150D0DA76DC28240');
        $this->addSql('ALTER TABLE bandes DROP FOREIGN KEY FK_150D0DA7A76ED395');
        $this->addSql('ALTER TABLE batiments DROP FOREIGN KEY FK_124D7990A76ED395');
        $this->addSql('ALTER TABLE batiments DROP FOREIGN KEY FK_124D79905582E9C0');
        $this->addSql('ALTER TABLE bloc DROP FOREIGN KEY FK_C778955AA76ED395');
        $this->addSql('ALTER TABLE cout_sanitaire DROP FOREIGN KEY FK_7B8B4874A76ED395');
        $this->addSql('ALTER TABLE cout_sanitaire DROP FOREIGN KEY FK_7B8B4874CC72D953');
        $this->addSql('ALTER TABLE entree DROP FOREIGN KEY FK_598377A6A76ED395');
        $this->addSql('ALTER TABLE entree DROP FOREIGN KEY FK_598377A6670C757F');
        $this->addSql('ALTER TABLE entree DROP FOREIGN KEY FK_598377A6A8CBA5F7');
        $this->addSql('ALTER TABLE fermes DROP FOREIGN KEY FK_6E023AD9A76ED395');
        $this->addSql('ALTER TABLE fournisseur DROP FOREIGN KEY FK_369ECA32A76ED395');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291BA76ED395');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291BAB0D61F7');
        $this->addSql('ALTER TABLE magasin DROP FOREIGN KEY FK_54AF5F27F347EFB');
        $this->addSql('ALTER TABLE magasin DROP FOREIGN KEY FK_54AF5F27A76ED395');
        $this->addSql('ALTER TABLE magasin_dedier DROP FOREIGN KEY FK_9E5FC1DAD6F6891B');
        $this->addSql('ALTER TABLE magasin_dedier DROP FOREIGN KEY FK_9E5FC1DAF347EFB');
        $this->addSql('ALTER TABLE magasin_dedier DROP FOREIGN KEY FK_9E5FC1DAA76ED395');
        $this->addSql('ALTER TABLE medicament DROP FOREIGN KEY FK_9A9C723AA76ED395');
        $this->addSql('ALTER TABLE mouvement_stock DROP FOREIGN KEY FK_61E2C8EB415B9F11');
        $this->addSql('ALTER TABLE mouvement_stock DROP FOREIGN KEY FK_61E2C8EB11999B4A');
        $this->addSql('ALTER TABLE mouvement_stock DROP FOREIGN KEY FK_61E2C8EBA76ED395');
        $this->addSql('ALTER TABLE pesees DROP FOREIGN KEY FK_D22ED8211999B4A');
        $this->addSql('ALTER TABLE pesees DROP FOREIGN KEY FK_D22ED82A76ED395');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27A76ED395');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F2A76ED395');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F2A8CBA5F7');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F2DDA344B6');
        $this->addSql('ALTER TABLE suivi DROP FOREIGN KEY FK_2EBCCA8FA76ED395');
        $this->addSql('ALTER TABLE suivi DROP FOREIGN KEY FK_2EBCCA8F11999B4A');
        $this->addSql('ALTER TABLE traitement DROP FOREIGN KEY FK_2A356D27A76ED395');
    }
}
