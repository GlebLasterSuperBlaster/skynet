<?php

/**
 * Class db Connect to db
 */
class db
{
    function getConnection()
    {
        try {
            $dbh = new PDO('mysql:dbname=skynet;host=127.0.0.1;charset=utf8', 'root', '');
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $dbh;
    }

    /**
     *
     * @param int $id user
     * @return array of tarifs
     */
    function selectAllTarifs(int $id) :array
    {
        $sth = $this->getConnection()->prepare("SELECT tar.ID, tar.title, tar.price, tar.link, tar.speed, 
                                                            tar.pay_period, tar.tarif_group_id
                                                            FROM `users` dep
                                                            JOIN `services` emp ON dep.ID=emp.user_id
                                                            JOIN `tarifs` tar ON emp.tarif_id=tar.tarif_group_id
                                                            WHERE emp.user_id = ?");
        $sth->execute([$id]);
        $value =$sth->fetchAll(PDO::FETCH_ASSOC);
        return $value;
    }


    /**
     * @param int $id servise
     * @param int $user_id user
     * @param int $tarif_id tarif
     */
    function insertServise(int $id, int $user_id, int $tarif_id)
    {
        $sth = $this->getConnection()->prepare("INSERT INTO `services` SET `id` = :id, `user_id` = :user_id,
                                                          `tarif_id` = :tarif_id, `payday` = timestamp(now())");
        $value = $sth->execute(array('id' => $id, 'user_id' => $user_id, 'tarif_id' => $tarif_id));
    }

}

