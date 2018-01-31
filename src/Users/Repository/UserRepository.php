<?php

namespace App\Users\Repository;

use App\Users\Entity\User;
use Doctrine\DBAL\Connection;

/**
 * User repository.
 */
class UserRepository
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Returns a collection of users.
     *
     * @param int $limit
     *   The number of users to return.
     * @param int $offset
     *   The number of users to skip.
     * @param array $orderBy
     *   Optionally, the order by info, in the $column => $direction format.
     *
     * @return A collection of users, keyed by user id.
     */
    public function getAll()
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('u.*')
            ->from('Users', 'u');

        $statement = $queryBuilder->execute();
        $usersData = $statement->fetchAll();
        $userEntityList = null;
        foreach ($usersData as $userData) {
            $userEntityList[$userData['id']] = new User($userData['id'], $userData['tokenFacebook']);
        }

        return $userEntityList;
    }

    /**
     * Returns an User object.
     *
     * @param $id
     *   The id of the user to return.
     *
     * @return array A collection of users, keyed by user id.
     */
    public function getById($id)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('u.*')
            ->from('users', 'u')
            ->where('id = ?')
            ->setParameter(0, $id);
        $statement = $queryBuilder->execute();
        $userData = $statement->fetchAll();

        return new User($userData[0]['id'], $userData[0]['tokenFacebook']);
    }






  /*  public function delete($id)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->delete('users')
            ->where('id = :id')
            ->setParameter(':id', $id);

        $statement = $queryBuilder->execute();
    }

    public function update($parameters)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->update('users')
            ->where('id = :id')
            ->setParameter(':id', $parameters['id']);

        if ($parameters['tokenFacebook']) {
            $queryBuilder
                ->set('tokenFacebook', ':tokenFacebook')
                ->setParameter(':tokenFacebook', $parameters['tokenFacebook']);
        }

        $statement = $queryBuilder->execute();
    }

    public function insert($parameters)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->insert('users')
            ->values(
                array(
                    'id' => ':id',
                    'tokenFacebook' => ':tokenFacebook',
                )
            )
            ->setParameter(':id', $parameters['id'])
            ->setParameter(':tokenFacebook', $parameters['tokenFacebook']);
        $statement = $queryBuilder->execute();
    }*/
}