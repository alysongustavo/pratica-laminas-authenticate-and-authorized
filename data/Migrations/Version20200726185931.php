<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200726185931 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Structure Autentication';
    }

    public function up(Schema $schema) : void
    {
        // Criando tabela Usuario
        $tableUser = $schema->createTable('user');
        $tableUser->addColumn('id', 'integer', ['autoincrement' => true]);
        $tableUser->addColumn('name', 'string', ['notnull' => true, 'length' => 100]);
        $tableUser->addColumn('cpf', 'string', ['notnull' => true, 'length' => 20]);
        $tableUser->addColumn('email', 'string', ['notnull' => true, 'length' => 100, 'unique' => true]);
        $tableUser->addColumn('date_created', 'datetime', ['notnull'=>true]);
        $tableUser->addColumn('date_updated', 'datetime', ['notnull'=>true]);
        $tableUser->addColumn('pwd_reset_token', 'string', ['notnull'=>false, 'length'=>256]);
        $tableUser->addColumn('pwd_reset_token_creation_date', 'datetime', ['notnull'=>false]);
        $tableUser->addColumn('password', 'string', ['notnull' => true, 'length' => 255]);
        $tableUser->addColumn('status', 'integer', ['notnull' => true, 'default' => 1]);
        $tableUser->setPrimaryKey(['id']);
        $tableUser->addUniqueIndex(['name'], 'name_idx');
        $tableUser->addOption('engine' , 'InnoDB');

        // Create 'role' table
        $tableRole = $schema->createTable('role');
        $tableRole->addColumn('id', 'integer', ['autoincrement'=>true]);
        $tableRole->addColumn('name', 'string', ['notnull'=>true, 'length'=>128]);
        $tableRole->addColumn('description', 'text', ['notnull'=>true]);
        $tableRole->addColumn('layout', 'string', ['notnull'=>false, 'length'=>255]);
        $tableRole->addColumn('redirect', 'string', ['notnull'=>true, 'length'=>255]);
        $tableRole->addColumn('developer', 'boolean', ['notnull'=>false]);
        $tableRole->addColumn('date_created', 'datetime', ['notnull'=>true]);
        $tableRole->addColumn('date_updated', 'datetime', ['notnull'=>true]);
        $tableRole->setPrimaryKey(['id']);
        $tableRole->addUniqueIndex(['name'], 'name_idx');
        $tableRole->addColumn('parent_id', 'integer', ['notnull'=>false]);


        $tableRole->addOption('engine' , 'InnoDB');

        // Create 'resource' table
        $tablePermission = $schema->createTable('resource');
        $tablePermission->addColumn('id', 'integer', ['autoincrement'=>true]);
        $tablePermission->addColumn('name', 'string', ['notnull'=>true, 'length'=>128]);
        $tablePermission->addColumn('description', 'text', ['notnull'=>true]);
        $tablePermission->addColumn('date_created', 'datetime', ['notnull'=>true]);
        $tablePermission->addColumn('date_updated', 'datetime', ['notnull'=>true]);
        $tablePermission->setPrimaryKey(['id']);
        $tablePermission->addUniqueIndex(['name'], 'name_idx');
        $tablePermission->addOption('engine' , 'InnoDB');

        // Create 'privilege' table
        $tablePrivilege = $schema->createTable('privilege');
        $tablePrivilege->addColumn('id', 'integer', ['autoincrement'=>true]);
        $tablePrivilege->addColumn('permissions', 'text', ['notnull'=>false]);
        $tablePrivilege->addColumn('date_created', 'datetime', ['notnull'=>true]);
        $tablePrivilege->addColumn('date_updated', 'datetime', ['notnull'=>true]);
        $tablePrivilege->setPrimaryKey(['id']);
        $tablePrivilege->addColumn('resource_id', 'integer', ['notnull'=>true]);
        $tablePrivilege->addColumn('role_id', 'integer', ['notnull'=>true]);
        $tablePrivilege->addForeignKeyConstraint('resource', ['resource_id'], ['id'],
            ['onDelete'=>'CASCADE', 'onUpdate'=>'CASCADE'], 'resource_id_fk');
        $tablePrivilege->addForeignKeyConstraint('role', ['role_id'], ['id'],
            ['onDelete'=>'CASCADE', 'onUpdate'=>'CASCADE'], 'role_id_fk');
        $tablePrivilege->addOption('engine' , 'InnoDB');

        // Create 'user_role' table
        $table = $schema->createTable('user_role');
        $table->addColumn('user_id', 'integer', ['notnull'=>true]);
        $table->addColumn('role_id', 'integer', ['notnull'=>true]);
        $table->addForeignKeyConstraint('user', ['user_id'], ['id'],
            ['onDelete'=>'CASCADE', 'onUpdate'=>'CASCADE'], 'user_role_user_id_fk');
        $table->addForeignKeyConstraint('role', ['role_id'], ['id'],
            ['onDelete'=>'CASCADE', 'onUpdate'=>'CASCADE'], 'user_role_role_id_fk');
        $table->addOption('engine' , 'InnoDB');
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('user_role');
        $schema->dropTable('user');
        $schema->dropTable('privilege');
        $schema->dropTable('resource');
        $schema->dropTable('role');
    }
}
