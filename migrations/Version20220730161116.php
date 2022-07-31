<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220730161116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE badge (id INT AUTO_INCREMENT NOT NULL, nom LONGTEXT NOT NULL, image LONGTEXT NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE badge_user (badge_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_299D3A50F7A2C2FC (badge_id), INDEX IDX_299D3A50A76ED395 (user_id), PRIMARY KEY(badge_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, type_contact_id INT DEFAULT NULL, user_id INT DEFAULT NULL, phone VARCHAR(20) DEFAULT NULL, description LONGTEXT NOT NULL, INDEX IDX_4C62E638FAA2F36F (type_contact_id), UNIQUE INDEX UNIQ_4C62E638A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, speaker_id INT DEFAULT NULL, title LONGTEXT NOT NULL, description LONGTEXT NOT NULL, publish_date DATETIME NOT NULL, last_edit_date DATETIME NOT NULL, image LONGTEXT NOT NULL, is_public TINYINT(1) NOT NULL, INDEX IDX_169E6FB9D04A0F27 (speaker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_group (course_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_846B432D591CC992 (course_id), INDEX IDX_846B432DFE54D947 (group_id), PRIMARY KEY(course_id, group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_course_category (course_id INT NOT NULL, course_category_id INT NOT NULL, INDEX IDX_8EB34CC5591CC992 (course_id), INDEX IDX_8EB34CC56628AD36 (course_category_id), PRIMARY KEY(course_id, course_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_category (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT NOT NULL, color VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_part (id INT AUTO_INCREMENT NOT NULL, course_section_id INT DEFAULT NULL, title LONGTEXT NOT NULL, order_part INT NOT NULL, estimated_time TIME NOT NULL, INDEX IDX_81ADADC07C1ADF9 (course_section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_part_document (id INT AUTO_INCREMENT NOT NULL, link_video LONGTEXT DEFAULT NULL, content LONGTEXT NOT NULL, files LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_part_quiz (id INT AUTO_INCREMENT NOT NULL, quiz_id INT DEFAULT NULL, INDEX IDX_5C1BC4B3853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_section (id INT AUTO_INCREMENT NOT NULL, course_id INT DEFAULT NULL, nom LONGTEXT NOT NULL, course_order INT NOT NULL, INDEX IDX_25B07F03591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite_course (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, course_id INT DEFAULT NULL, add_date DATETIME NOT NULL, INDEX IDX_2A2B0343A76ED395 (user_id), INDEX IDX_2A2B0343591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, title LONGTEXT NOT NULL, description LONGTEXT NOT NULL, interaction LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, public TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, time_to_perform_all INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_part (id INT AUTO_INCREMENT NOT NULL, quiz_id INT DEFAULT NULL, skill_id INT DEFAULT NULL, question LONGTEXT NOT NULL, choice LONGTEXT NOT NULL, answer LONGTEXT NOT NULL, time_max_to_response INT DEFAULT NULL, quiz_order INT NOT NULL, INDEX IDX_83FE8C9D853CD175 (quiz_id), INDEX IDX_83FE8C9D5585C142 (skill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_part_perform (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, quiz_part_id INT DEFAULT NULL, time_to_response TIME NOT NULL, date DATE NOT NULL, score INT NOT NULL, INDEX IDX_8F4672B0A76ED395 (user_id), INDEX IDX_8F4672B05EB9E64C (quiz_part_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE read_later (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, course_id INT DEFAULT NULL, add_date DATETIME NOT NULL, position_order INT NOT NULL, INDEX IDX_B383CE9DA76ED395 (user_id), INDEX IDX_B383CE9D591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE received_notification (id INT AUTO_INCREMENT NOT NULL, notification_id INT DEFAULT NULL, user_id INT DEFAULT NULL, viewed TINYINT(1) NOT NULL, INDEX IDX_D27F8B86EF1A9D84 (notification_id), INDEX IDX_D27F8B86A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT DEFAULT NULL, xp_required_for_levels LONGTEXT NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_user_xp (id INT AUTO_INCREMENT NOT NULL, skill_id INT DEFAULT NULL, user_id INT DEFAULT NULL, xp INT NOT NULL, INDEX IDX_F498BAD15585C142 (skill_id), INDEX IDX_F498BAD1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speaker (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_7B85DB61A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speciality (id INT AUTO_INCREMENT NOT NULL, speaker_id INT DEFAULT NULL, name LONGTEXT NOT NULL, begin_at DATETIME NOT NULL, INDEX IDX_F3D7A08ED04A0F27 (speaker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, group_reference_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_B723AF33A76ED395 (user_id), INDEX IDX_B723AF33FA039490 (group_reference_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name LONGTEXT NOT NULL, firstname LONGTEXT NOT NULL, image LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE badge_user ADD CONSTRAINT FK_299D3A50F7A2C2FC FOREIGN KEY (badge_id) REFERENCES badge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE badge_user ADD CONSTRAINT FK_299D3A50A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638FAA2F36F FOREIGN KEY (type_contact_id) REFERENCES type_contact (id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9D04A0F27 FOREIGN KEY (speaker_id) REFERENCES speaker (id)');
        $this->addSql('ALTER TABLE course_group ADD CONSTRAINT FK_846B432D591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_group ADD CONSTRAINT FK_846B432DFE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_course_category ADD CONSTRAINT FK_8EB34CC5591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_course_category ADD CONSTRAINT FK_8EB34CC56628AD36 FOREIGN KEY (course_category_id) REFERENCES course_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_part ADD CONSTRAINT FK_81ADADC07C1ADF9 FOREIGN KEY (course_section_id) REFERENCES course_section (id)');
        $this->addSql('ALTER TABLE course_part_quiz ADD CONSTRAINT FK_5C1BC4B3853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE course_section ADD CONSTRAINT FK_25B07F03591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE favorite_course ADD CONSTRAINT FK_2A2B0343A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorite_course ADD CONSTRAINT FK_2A2B0343591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE quiz_part ADD CONSTRAINT FK_83FE8C9D853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE quiz_part ADD CONSTRAINT FK_83FE8C9D5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE quiz_part_perform ADD CONSTRAINT FK_8F4672B0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE quiz_part_perform ADD CONSTRAINT FK_8F4672B05EB9E64C FOREIGN KEY (quiz_part_id) REFERENCES quiz_part (id)');
        $this->addSql('ALTER TABLE read_later ADD CONSTRAINT FK_B383CE9DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE read_later ADD CONSTRAINT FK_B383CE9D591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE received_notification ADD CONSTRAINT FK_D27F8B86EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id)');
        $this->addSql('ALTER TABLE received_notification ADD CONSTRAINT FK_D27F8B86A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE skill_user_xp ADD CONSTRAINT FK_F498BAD15585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE skill_user_xp ADD CONSTRAINT FK_F498BAD1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE speaker ADD CONSTRAINT FK_7B85DB61A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE speciality ADD CONSTRAINT FK_F3D7A08ED04A0F27 FOREIGN KEY (speaker_id) REFERENCES speaker (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33FA039490 FOREIGN KEY (group_reference_id) REFERENCES `group` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE badge_user DROP FOREIGN KEY FK_299D3A50F7A2C2FC');
        $this->addSql('ALTER TABLE course_group DROP FOREIGN KEY FK_846B432D591CC992');
        $this->addSql('ALTER TABLE course_course_category DROP FOREIGN KEY FK_8EB34CC5591CC992');
        $this->addSql('ALTER TABLE course_section DROP FOREIGN KEY FK_25B07F03591CC992');
        $this->addSql('ALTER TABLE favorite_course DROP FOREIGN KEY FK_2A2B0343591CC992');
        $this->addSql('ALTER TABLE read_later DROP FOREIGN KEY FK_B383CE9D591CC992');
        $this->addSql('ALTER TABLE course_course_category DROP FOREIGN KEY FK_8EB34CC56628AD36');
        $this->addSql('ALTER TABLE course_part DROP FOREIGN KEY FK_81ADADC07C1ADF9');
        $this->addSql('ALTER TABLE course_group DROP FOREIGN KEY FK_846B432DFE54D947');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33FA039490');
        $this->addSql('ALTER TABLE received_notification DROP FOREIGN KEY FK_D27F8B86EF1A9D84');
        $this->addSql('ALTER TABLE course_part_quiz DROP FOREIGN KEY FK_5C1BC4B3853CD175');
        $this->addSql('ALTER TABLE quiz_part DROP FOREIGN KEY FK_83FE8C9D853CD175');
        $this->addSql('ALTER TABLE quiz_part_perform DROP FOREIGN KEY FK_8F4672B05EB9E64C');
        $this->addSql('ALTER TABLE quiz_part DROP FOREIGN KEY FK_83FE8C9D5585C142');
        $this->addSql('ALTER TABLE skill_user_xp DROP FOREIGN KEY FK_F498BAD15585C142');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9D04A0F27');
        $this->addSql('ALTER TABLE speciality DROP FOREIGN KEY FK_F3D7A08ED04A0F27');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638FAA2F36F');
        $this->addSql('ALTER TABLE badge_user DROP FOREIGN KEY FK_299D3A50A76ED395');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638A76ED395');
        $this->addSql('ALTER TABLE favorite_course DROP FOREIGN KEY FK_2A2B0343A76ED395');
        $this->addSql('ALTER TABLE quiz_part_perform DROP FOREIGN KEY FK_8F4672B0A76ED395');
        $this->addSql('ALTER TABLE read_later DROP FOREIGN KEY FK_B383CE9DA76ED395');
        $this->addSql('ALTER TABLE received_notification DROP FOREIGN KEY FK_D27F8B86A76ED395');
        $this->addSql('ALTER TABLE skill_user_xp DROP FOREIGN KEY FK_F498BAD1A76ED395');
        $this->addSql('ALTER TABLE speaker DROP FOREIGN KEY FK_7B85DB61A76ED395');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33A76ED395');
        $this->addSql('DROP TABLE badge');
        $this->addSql('DROP TABLE badge_user');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE course_group');
        $this->addSql('DROP TABLE course_course_category');
        $this->addSql('DROP TABLE course_category');
        $this->addSql('DROP TABLE course_part');
        $this->addSql('DROP TABLE course_part_document');
        $this->addSql('DROP TABLE course_part_quiz');
        $this->addSql('DROP TABLE course_section');
        $this->addSql('DROP TABLE favorite_course');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE quiz_part');
        $this->addSql('DROP TABLE quiz_part_perform');
        $this->addSql('DROP TABLE read_later');
        $this->addSql('DROP TABLE received_notification');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE skill_user_xp');
        $this->addSql('DROP TABLE speaker');
        $this->addSql('DROP TABLE speciality');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE type_contact');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
