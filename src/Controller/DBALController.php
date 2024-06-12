<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Types;
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
                $fieldType = $this->mapColumnType($column->getType()->getName());

                $entityCode .= "    /**\n     * @ORM\Column(type=\"$fieldType\")\n     */\n";
                $entityCode .= "    private $" . $fieldName . ";\n\n";

                // Generate getters and setters
                $camelCaseFieldName = ucfirst($fieldName);
                $entityCode .= "    public function get$camelCaseFieldName(): $fieldType\n    {\n        return \$this->$fieldName;\n    }\n\n";
                $entityCode .= "    public function set$camelCaseFieldName($fieldType \$$fieldName): self\n    {\n        \$this->$fieldName = \$$fieldName;\n        return \$this;\n    }\n\n";
            }

            $entityCode .= "}\n";

            $filePath = sprintf('../src/Entity/%s.php', ucfirst($tableName));
            file_put_contents($filePath, $entityCode);
        }

        return new Response('Entities generated successfully.');
    }

    private function mapColumnType(string $type): string
    {
        $typeMap = [
            Types::INTEGER => 'int',
            Types::STRING => 'string',
            Types::TEXT => 'string',
            Types::DATETIME_MUTABLE => '\DateTime',
            Types::DATE_MUTABLE => '\DateTime',
            Types::DECIMAL => 'float',
            Types::FLOAT => 'float',
            // Add more mappings as needed
        ];

        return $typeMap[$type] ?? 'string';
    }
}








