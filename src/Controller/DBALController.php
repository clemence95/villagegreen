<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DBALController extends AbstractController
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    #[Route('/generate-entities', name: 'generate_entities')]
    public function generateEntities(): Response
    {
        $schemaManager = $this->connection->createSchemaManager();
        $tables = $schemaManager->listTables();

        foreach ($tables as $table) {
            $tableName = $table->getName();
            $columns = $table->getColumns();

            $entityCode = "<?php\n\nnamespace App\Entity;\n\nuse Doctrine\ORM\Mapping as ORM;\n\n/**\n * @ORM\Entity\n * @ORM\Table(name=\"$tableName\")\n */\nclass " . ucfirst($tableName) . "\n{\n";

            foreach ($columns as $column) {
                $fieldName = $column->getName();
                $fieldType = $column->getType()->getSQLDeclaration([], $this->connection->getDatabasePlatform());

                $entityCode .= "    /**\n     * @ORM\Column(type=\"$fieldType\")\n     */\n";
                $entityCode .= "    private $" . $fieldName . ";\n\n";
            }

            $entityCode .= "}\n";

            $filePath = sprintf('../src/Entity/%s.php', ucfirst($tableName));
            file_put_contents($filePath, $entityCode);
        }

        return new Response('Entities generated successfully.');
    }
}




