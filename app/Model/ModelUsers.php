<?php

namespace app\Model;

use app\Db;

/**
 * Class ModelUsers
 *
 * @package app\Model
 */
class ModelUsers
{
    /**
     * Объект для работы с базой
     *
     * @var object $db
     */
    private $db;

    /**
     * Название таблицы
     *
     * @var string
     */
    private $table = 'users';

    public function __construct()
    {
        $this->db = Db::init('crm');
    }

    /**
     * Возвращает пользователя по id
     *
     * @param integer $user_id
     * 
     * @return array
     */
    public function get(int $user_id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE user_id = ?', [$user_id]);

        return [
            'users' => [
                'data'  => $this->db->getResult(),
                'count' => $this->db->getRowCount()
            ]
        ];
    }
}
