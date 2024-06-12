<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="doctrine_migration_versions")
 */
class Doctrine_migration_versions
{
    /**
     * @ORM\Column(type="string")
     */
    private $version;

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @ORM\Column(type="\DateTime")
     */
    private $executed_at;

    public function getExecuted_at(): \DateTime
    {
        return $this->executed_at;
    }

    public function setExecuted_at(\DateTime $executed_at): self
    {
        $this->executed_at = $executed_at;
        return $this;
    }

    /**
     * @ORM\Column(type="int")
     */
    private $execution_time;

    public function getExecution_time(): int
    {
        return $this->execution_time;
    }

    public function setExecution_time(int $execution_time): self
    {
        $this->execution_time = $execution_time;
        return $this;
    }

}
