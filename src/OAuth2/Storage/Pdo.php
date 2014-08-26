<?php

namespace Timezones\OAuth2\Storage;

class Pdo extends \OAuth2\Storage\Pdo
{
    public function checkPassword($user, $password)
    {
        return password_verify($password, $user['password']);
    }

    public function setUser($username, $password, $firstName = null, $lastName = null)
    {
        // do not store in plaintext
        $password = password_hash($password, PASSWORD_DEFAULT);

        // if it exists, update it.
        if ($this->getUser($username)) {
            $stmt = $this->db->prepare($sql = sprintf('UPDATE %s SET password=:password, first_name=:firstName, last_name=:lastName where username=:username', $this->config['user_table']));
        } else {
            $stmt = $this->db->prepare(sprintf('INSERT INTO %s (username, password, first_name, last_name) VALUES (:username, :password, :firstName, :lastName)', $this->config['user_table']));
        }
        return $stmt->execute(compact('username', 'password', 'firstName', 'lastName'));
    }

    public function getUser($username)
    {
        $stmt = $this->db->prepare($sql = sprintf('SELECT * from %s where username=:username', $this->config['user_table']));
        $stmt->execute(array('username' => $username));

        if (!$userInfo = $stmt->fetch()) {
            return false;
        }

        // the default behavior is to use "username" as the user_id
        return array_merge(array(
            'user_id' => $userInfo['id'],
        ), $userInfo);
    }

}
