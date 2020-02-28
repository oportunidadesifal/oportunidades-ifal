<?php

namespace Oportunista\entities\opportunities;

class InternshipDao extends OpportunityDao
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

        $sql = "INSERT INTO internships (id, 
                                        salary, 
                                        numberVacantJob, 
                                        weeklyWorkLoad, 
                                        benefits, 
                                        requirements, 
                                        location, 
                                        shift, 
                                        code, 
                                        companyId) 
                values (:id, 
                        :salary, 
                        :numberVacantJob, 
                        :weeklyWorkLoad, 
                        :benefits, 
                        :requirements, 
                        :location, 
                        :shift, 
                        :code, 
                        :companyId)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':id', $ultimoId);
        $stmt->bindValue(':salary', $opportunity->getSalary());
        $stmt->bindValue(':numberVacantJob', $opportunity->getNumberVacantJob());
        $stmt->bindValue(':weeklyWorkLoad', $opportunity->getWeeklyWorkLoad());
        $stmt->bindValue(':benefits', $opportunity->getBenefits());
        $stmt->bindValue(':requirements', $opportunity->getRequirements());
        $stmt->bindValue(':location', $opportunity->getLocation());
        $stmt->bindValue(':shift', $opportunity->getShift());
        $stmt->bindValue(':code', $opportunity->getCode());
        $stmt->bindValue(':companyId', $opportunity->getCompanyId());

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
                FROM internships i 
                JOIN opportunities o 
                ON i.id = o.id 
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

        $sql = "UPDATE internships SET 
                    salary = :salary, 
                    numberVacantJob = :numberVacantJob, 
                    weeklyWorkLoad = :weeklyWorkLoad, 
                    benefits = :benefits,
                    requirements = :requirements,
                    location = :location,
                    shift = :shift,
                    code = :code
                WHERE id = :id";

        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':salary', $opportunity->getSalary());
        $stmt->bindValue(':numberVacantJob', $opportunity->getNumberVacantJob());
        $stmt->bindValue(':weeklyWorkLoad', $opportunity->getWeeklyWorkLoad());
        $stmt->bindValue(':benefits', $opportunity->getBenefits());
        $stmt->bindValue(':requirements', $opportunity->getRequirements());
        $stmt->bindValue(':location', $opportunity->getLocation());
        $stmt->bindValue(':shift', $opportunity->getShift());
        $stmt->bindValue(':code', $opportunity->getCode());
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
