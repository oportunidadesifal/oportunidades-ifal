<?php

namespace Oportunista\entities\opportunities;

class MonitoringDao extends OpportunityDao
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

        $sql = "INSERT INTO monitoring (id, monitors, scholarship, numberOfMonitors, disciplineCode) 
        values (:id, :monitors, :scholarship, :numberOfMonitors, :disciplineCode)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':id', $ultimoId);
        $stmt->bindValue(':monitors', $opportunity->getMonitors());
        $stmt->bindValue(':scholarship', $opportunity->getScholarship());
        $stmt->bindValue(':numberOfMonitors', $opportunity->getNumberOfMonitors());
        $stmt->bindValue(':disciplineCode', $opportunity->getDisciplineCode());

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
                FROM monitoring m 
                JOIN opportunities o 
                ON m.id = o.id 
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

        $sql = "UPDATE monitoring SET 
                    monitors = :monitors, 
                    scholarship = :scholarship, 
                    numberOfMonitors = :numberOfMonitors, 
                    disciplineCode = :disciplineCode
                WHERE id = :id";

        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':monitors', $opportunity->getMonitors());
        $stmt->bindValue(':scholarship', $opportunity->getScholarship());
        $stmt->bindValue(':numberOfMonitors', $opportunity->getNumberOfMonitors());
        $stmt->bindValue(':disciplineCode', $opportunity->getDisciplineCode());
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
