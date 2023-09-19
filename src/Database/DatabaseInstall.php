<?php

declare(strict_types=1);

namespace Timo\Cms\Database;

class DatabaseInstall
{
    public function __construct(private Database $db, private array $modelClassnames = [])
    {
    }

    public function reinstall()
    {
        $this->drop();
        $this->batchExecute($this->modelClassnames, 'createTable');
    }

    public function drop()
    {
        $this->batchExecute(array_reverse($this->modelClassnames), 'dropTable');
    }

    private function batchExecute(array $classNames, string $methodName)
    {
        $this->db->transaction(function (Database $db) use ($classNames, $methodName) {
            foreach ($classNames as $className) {
                $statements = ($className . '::' . $methodName)();
                if (is_string($statements)) {
                    $statements = [$statements];
                }
                foreach ($statements as $sql) {
                    $db->execute($sql);
                }
            }
        });
    }
}
