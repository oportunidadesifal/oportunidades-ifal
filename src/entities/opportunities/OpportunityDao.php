<?php

namespace Oportunista\entities\opportunities;

use Oportunista\Connection;
use \PDO;

class OpportunityDao
{
    protected $connect;
    protected $opportunity;
    
    public function __construct(Opportunity $opportunity = null)
    {
        $this->connect = Connection::connect();
        $this->opportunity = $opportunity;
    }

    public function getAll()
    {
        $resultados = array("Research", "Event", "Monitoring", "Internship");
        foreach ($resultados as $categoria) {
            $path = 'Oportunista\entities\opportunities\\'.$categoria.'Dao';
            $dao = new $path();
            $resultados[$categoria] = $dao->get();
        }
        return $resultados;
    }

    public function getOpportunityById($id)
    {

        $sql = "SELECT type FROM opportunities where id = :id AND deleted = 0";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':id', $id);
        $result = $stmt->execute();

        if (!$result) {
            return false;
        }

        $typeResult = $stmt->fetch(PDO::FETCH_ASSOC);
        $typeResult = $typeResult['type'];
        $class = 'Oportunista\entities\opportunities\\'.$typeResult;

        if ($typeResult == 'Research') {
            $typeResult = 'researches';
        }

        if ($typeResult == 'Internship') {
            $typeResult = 'internships';
        }

        if ($typeResult == 'Event') {
            $typeResult = 'events';
        }

        if ($typeResult == 'Monitoring') {
            $typeResult = 'monitoring';
        }

        $sql = "SELECT 
            o.id, 
            o.title, 
            o.description, 
            o.authorId, 
            o.type,
            o.closed, 
            o.created,
            o.lastUpdate,
            o.version,
            o.posterBackgroundId,
            o.posterIconId
         FROM ".$typeResult." x JOIN opportunities o ON x.id = o.id WHERE o.id = :id";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':id', $id);
        $result = $stmt->execute();

        if (!$result) {
            return false;
        }

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        #$opportunity = new $class($result, $result['type'], $result['authorId'], $result['id']);
        $opportunity =  new Opportunity($opportunity);
        return $opportunity;
    }

    public function getOpportunityPage($page)
    {
        $max = 10;
        $num = $page * 10;

        $sql = "SELECT 
            id, 
            title, 
            description, 
            authorId, 
            type,
            closed, 
            created,
            lastUpdate,
            version,
            posterBackgroundId,
            posterIconId
            FROM opportunities WHERE deleted = 0 ORDER BY created DESC LIMIT :num, :max";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':num', $num, PDO::PARAM_INT);
        $stmt->bindValue(':max', $max, PDO::PARAM_INT);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        if (! empty($result)) {
            $opportunities = [];
            foreach ($result as $opportunity) {
                $opportunities[] = new Opportunity($opportunity);
            }
            return $opportunities;
        }

        return false;
    }


    public function getOpportunityByUserId($id)
    {
        $sql = "SELECT
            id, 
            title, 
            description,
            authorId, 
            type,
            closed, 
            created,
            lastUpdate,
            version,
            posterBackgroundId,
            posterIconId
            FROM opportunities where authorId = :id AND deleted = 0";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        if (! empty($result)) {
            return $result;
        }

        return false;
    }

    public function getOpportunityByUserIdTrash($id)
    {
        $sql = "SELECT * FROM opportunities where authorId = :id AND deleted = 1";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        if (! empty($result)) {
            return $result;
        }

        return false;
    }

    public function deleteOpportunity($id, $user_id)
    {
        
        $this->connect->beginTransaction();

        $sql = "SELECT * FROM opportunities WHERE id = :id AND authorId = :authorId";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':authorId', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->rowCount();
        
        if ($result < 1) {
            return false;
        }

        $sql = "UPDATE opportunities SET deleted = 1 WHERE id = :id";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->rowCount();
        
        if ($result == 1) {
            $this->connect->commit();
            return true;
        } else {
            return false;
            $this->connect->rollback();
        }
    }
}
