<?php

use Phinx\Migration\AbstractMigration;

class CreateOauthTables extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->execute(
            'CREATE TABLE IF NOT EXISTS oauth_clients (
                client_id TEXT,
                client_secret TEXT,
                redirect_uri TEXT
            )'
        );

        $this->execute(
            'CREATE TABLE IF NOT EXISTS oauth_access_tokens (
                access_token TEXT,
                client_id TEXT,
                user_id TEXT,
                expires TIMESTAMP,
                scope TEXT
            )'
        );

        $this->execute(
            'CREATE TABLE IF NOT EXISTS oauth_authorization_codes (
                authorization_code TEXT,
                client_id TEXT,
                user_id TEXT,
                redirect_uri TEXT,
                expires TIMESTAMP,
                scope TEXT
            )'
        );

        $this->execute(
            'CREATE TABLE IF NOT EXISTS oauth_refresh_tokens (
                refresh_token TEXT,
                client_id TEXT,
                user_id TEXT,
                expires TIMESTAMP,
                scope TEXT
            )'
        );

        $this->execute(
            'CREATE TABLE IF NOT EXISTS oauth_users (
                username TEXT,
                password TEXT,
                first_name TEXT,
                last_name TEXT
            )'
        );

        $this->execute(
            'CREATE TABLE IF NOT EXISTS oauth_scopes (
                scope TEXT,
                is_default BOOLEAN
            )'
        );

        // add test data
        $this->execute(
            'INSERT INTO oauth_clients (
                client_id, client_secret
            ) VALUES ("timezonesapp", "mF17G2hy")'
        );

        $this->execute(sprintf(
            'INSERT INTO oauth_users (username, password)
            VALUES ("demo", "%s")',
            password_hash("D0o2@7zv", PASSWORD_DEFAULT, [
                'cost' => 12,
            ])
        ));

        $this->execute(
            'INSERT INTO oauth_scopes (scope, is_default)
            VALUES ("timezones", 1)'
        );

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DROP TABLE oauth_clients');
        $this->execute('DROP TABLE oauth_access_tokens');
        $this->execute('DROP TABLE oauth_authorization_codes');
        $this->execute('DROP TABLE oauth_refresh_tokens');
        $this->execute('DROP TABLE oauth_users');
    }
}
