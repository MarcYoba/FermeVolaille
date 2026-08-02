<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260731140820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE bandes ADD matricule VARCHAR(255) NOT NULL, ADD souche VARCHAR(255) NOT NULL, ADD fournisseur VARCHAR(255) NOT NULL, ADD date_mise_place DATE NOT NULL, ADD poussins VARCHAR(255) NOT NULL, ADD prix VARCHAR(255) NOT NULL, ADD poids VARCHAR(255) NOT NULL, ADD date_abattage DATE NOT NULL, ADD status VARCHAR(255) NOT NULL, ADD createt_at DATE NOT NULL, ADD ferme_id INT DEFAULT NULL, ADD batiments_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bandes ADD CONSTRAINT FK_150D0DA718981132 FOREIGN KEY (ferme_id) REFERENCES fermes (id)');
        $this->addSql('ALTER TABLE bandes ADD CONSTRAINT FK_150D0DA76DC28240 FOREIGN KEY (batiments_id) REFERENCES batiments (id)');
        $this->addSql('ALTER TABLE bandes ADD CONSTRAINT FK_150D0DA7A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_150D0DA718981132 ON bandes (ferme_id)');
        $this->addSql('CREATE INDEX IDX_150D0DA76DC28240 ON bandes (batiments_id)');
        $this->addSql('CREATE INDEX IDX_150D0DA7A76ED395 ON bandes (user_id)');
        $this->addSql('ALTER TABLE batiments ADD CONSTRAINT FK_124D7990A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE batiments ADD CONSTRAINT FK_124D79905582E9C0 FOREIGN KEY (bloc_id) REFERENCES bloc (id)');
        $this->addSql('ALTER TABLE bloc ADD CONSTRAINT FK_C778955AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE fermes ADD CONSTRAINT FK_6E023AD9A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE magasin ADD CONSTRAINT FK_54AF5F27F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE magasin ADD CONSTRAINT FK_54AF5F27A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE magasin_dedier ADD CONSTRAINT FK_9E5FC1DAD6F6891B FOREIGN KEY (batiment_id) REFERENCES batiments (id)');
        $this->addSql('ALTER TABLE magasin_dedier ADD CONSTRAINT FK_9E5FC1DAF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE magasin_dedier ADD CONSTRAINT FK_9E5FC1DAA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A98456F347EFB');
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A98456A76ED395');
        $this->addSql('ALTER TABLE bandes DROP FOREIGN KEY FK_150D0DA718981132');
        $this->addSql('ALTER TABLE bandes DROP FOREIGN KEY FK_150D0DA76DC28240');
        $this->addSql('ALTER TABLE bandes DROP FOREIGN KEY FK_150D0DA7A76ED395');
        $this->addSql('DROP INDEX IDX_150D0DA718981132 ON bandes');
        $this->addSql('DROP INDEX IDX_150D0DA76DC28240 ON bandes');
        $this->addSql('DROP INDEX IDX_150D0DA7A76ED395 ON bandes');
        $this->addSql('ALTER TABLE bandes DROP matricule, DROP souche, DROP fournisseur, DROP date_mise_place, DROP poussins, DROP prix, DROP poids, DROP date_abattage, DROP status, DROP createt_at, DROP ferme_id, DROP batiments_id, DROP user_id');
        $this->addSql('ALTER TABLE batiments DROP FOREIGN KEY FK_124D7990A76ED395');
        $this->addSql('ALTER TABLE batiments DROP FOREIGN KEY FK_124D79905582E9C0');
        $this->addSql('ALTER TABLE bloc DROP FOREIGN KEY FK_C778955AA76ED395');
        $this->addSql('ALTER TABLE fermes DROP FOREIGN KEY FK_6E023AD9A76ED395');
        $this->addSql('ALTER TABLE magasin DROP FOREIGN KEY FK_54AF5F27F347EFB');
        $this->addSql('ALTER TABLE magasin DROP FOREIGN KEY FK_54AF5F27A76ED395');
        $this->addSql('ALTER TABLE magasin_dedier DROP FOREIGN KEY FK_9E5FC1DAD6F6891B');
        $this->addSql('ALTER TABLE magasin_dedier DROP FOREIGN KEY FK_9E5FC1DAF347EFB');
        $this->addSql('ALTER TABLE magasin_dedier DROP FOREIGN KEY FK_9E5FC1DAA76ED395');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27A76ED395');
    }
}
