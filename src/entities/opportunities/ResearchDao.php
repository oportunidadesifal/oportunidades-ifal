<?php

namespace Oportunista\entities\opportunities;

class ResearchDao extends OpportunityDao
{
    public function save(Opportunity $opportunity)
    {
        $this->connect->beginTransaction();
        
        $sql = "INSERT INTO opportunities (title, description, authorId, type, posterBackgroundId, posterIconId) 
                values (:title, :description, :authorId, :type, :posterBackgroundId, :posterIconId)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':title', $opportunity->getTitle());
        $stmt->bindValue(':description', $opportunity->getDescription());
        $stmt->bindValue(':authorId', $opportunity->getAuthorId());
        $stmt->bindValue(':type', $opportunity->getType());
        $stmt->bindValue(':posterBackgroundId', $opportunity->getPosterBackgroundId());
        $stmt->bindValue(':posterIconId', $opportunity->getPosterIconId());

        $resultado1 = $stmt->execute();
        $ultimoId = $this->connect->lastInsertId();

        $sql = "INSERT INTO researches (id, status, modality, startDate, duration, scholarship, members) 
        values (:id, :status, :modality, :startDate, :duration, :scholarship, :members)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':id', $ultimoId);
        $stmt->bindValue(':status', $opportunity->getStatus());
        $stmt->bindValue(':modality', $opportunity->getModality());
        $stmt->bindValue(':startDate', $opportunity->getStartDate());
        $stmt->bindValue(':duration', $opportunity->getDuration());
        $stmt->bindValue(':scholarship', $opportunity->getScholarship());
        $stmt->bindValue(':members', $opportunity->getMembers());

        $resultado = $stmt->execute();

        if ($resultado1 == true and $resultado == true) {
            $this->connect->commit();
            return true;
        }
        
        $this->connect->rollback();
        return "Could not process transaction";
    }

    public function get()
    {
        $sql = "SELECT * 
                FROM researches r 
                JOIN opportunities o 
                ON r.id = o.id 
                WHERE o.deleted = 0 
                ORDER BY o.created 
                DESC";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function update(Opportunity $opportunity)
    {
        $this->connect->beginTransaction();

        $sql = "UPDATE opportunities 
                SET 
                    title = :title, 
                    description = :description, 
                    version = version + 1, 
                    closed = :closed,
                    posterBackgroundId = :posterBackgroundId, 
                    posterIconId = :posterIconId 
                WHERE 
                    id = :id";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':title', $opportunity->getTitle());
        $stmt->bindValue(':description', $opportunity->getDescription());
        $stmt->bindValue(':closed', $opportunity->getClosed());
        $stmt->bindValue(':id', $opportunity->getId());
        $stmt->bindValue(':posterBackgroundId', $opportunity->getPosterBackgroundId());
        $stmt->bindValue(':posterIconId', $opportunity->getPosterIconId());
        $result = $stmt->execute();


        if ($result != true) {
            $this->connect->rollback();
            return "Could not process transaction";
        }

        $sql = "UPDATE researches SET 
                    status = :status, 
                    modality = :modality, 
                    startDate = :startDate, 
                    duration = :duration, 
                    scholarship = :scholarship,
                    members = :members
                WHERE id = :id";

        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':status', $opportunity->getStatus());
        $stmt->bindValue(':modality', $opportunity->getModality());
        $stmt->bindValue(':startDate', $opportunity->getStartDate());
        $stmt->bindValue(':duration', $opportunity->getDuration());
        $stmt->bindValue(':scholarship', $opportunity->getScholarship());
        $stmt->bindValue(':members', $opportunity->getMembers());
        $stmt->bindValue(':id', $opportunity->getId());
        $result = $stmt->execute();

        if ($result != true) {
            $this->connect->rollback();
            return "Could not process transaction";
        }

        $this->connect->commit();
        return true;
    }
}
