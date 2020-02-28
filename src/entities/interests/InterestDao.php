<?php

namespace Oportunista\entities\interests;

use Oportunista\Connection;
use \PDO;

class InterestDao
{
    private $connect;
    
    public function __construct()
    {
        $this->connect = Connection::connect();
    }

    public function checkInterests($userId, $opportunityId)
    {

        $sql = "SELECT * FROM interests WHERE userId = :userId AND opportunityId = :opportunityId";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':userId', $userId);
        $stmt->bindValue(':opportunityId', $opportunityId);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            return false;
        } else {
            return true;
        }
    }

    public function insertInterests(Interest $interest)
    {

        if ($this->checkInterests($interest->getUserId(), $interest->getOpportunityId())) {
            return "You have already expressed interest in this opportunity";
        }

        $this->connect->beginTransaction();

        $sql = "INSERT INTO interests (opportunityData, opportunityId, opportunityVersion, userId) 
                values(:opportunityData, :opportunityId, :opportunityVersion, :userId)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':opportunityData', $interest->getOpportunityData());
        $stmt->bindValue(':opportunityId', $interest->getOpportunityId());
        $stmt->bindValue(':opportunityVersion', $interest->getOpportunityVersion());
        $stmt->bindValue(':userId', $interest->getUserId());

        $result = $stmt->execute();

        if ($result != 1) {
            $this->connect->rollback();
            return "Could not process transaction";
        }

        $this->connect->commit();
        return true;
    }

    public function deleteInterests($opportunityId, $userId)
    {
        if (! $this->checkInterests($userId, $opportunityId)) {
            return "You do not have expressed interest in this opportunity";
        }

        $sql = "DELETE FROM interests WHERE opportunityId = :opportunityId AND userId = :userId";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':opportunityId', $opportunityId, PDO::PARAM_INT);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->rowCount();
        
        if ($result == 1) {
            return true;
        } else {
            return "Could not process transaction";
        }
    }

    public function getInterests($userId)
    {

        $sql = "SELECT 
                    opportunityId, 
                    userId, 
                    opportunityData, 
                    created, 
                    lastUpdate, 
                    opportunityVersion FROM 
                    interests WHERE 
                    userId = :userId";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function howManyInterestsByOpportunityId($opportunityId)
    {

        $sql = "SELECT userId FROM interests WHERE opportunityId = :opportunityId";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':opportunityId', $opportunityId);
        $stmt->execute();

        $row = $stmt->rowCount();
        return $row;
    }

    public function getUsersInterestsByOpportunity($opportunityId)
    {
        if ($this->howManyInterestsByOpportunityId($opportunityId) <= 0) {
            return false;
        }

        $sql = "SELECT u.username, 
            p.user_id, p.name, p.surname, p.image_id, 
            s.university_id FROM users u JOIN
        profiles p ON u.id = p.user_id JOIN
        students s ON p.user_id = s.user_id JOIN
        interests i ON p.user_id = i.userId WHERE
        i.opportunityId = :opportunityId";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':opportunityId', $opportunityId);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }
}
