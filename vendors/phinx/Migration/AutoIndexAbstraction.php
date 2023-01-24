<?php

namespace Phinx\Migration;

use Phinx\Db\Table;

class AutoIndexAbstraction
{
    private const PREFIX_FOR_INDEX = 'ix';
    private const INDEX_SEPARATOR_CHAR = '_';

    private $table;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * @param string $columnName Column name where index will be added.
     */
    public function addIndexToColumn(string $columnName): void
    {
        $this
            ->table
            ->addIndex(
                $columnName,
                [
                    'unique' => false,
                    'name' => $this->getIndexNameByColumnName($columnName)
                ]
            )
            ->save();
    }

    /**
     * @param string $columnName Column name.
     */
    public function removeIndexFromColumn(string $columnName): void
    {
        $this
            ->table
            ->removeIndexByName(
                $this->getIndexNameByColumnName($columnName)
            )
            ->save();
    }

    /**
     * @param string $columnName Column name.
     *
     * @return bool
     */
    public function hasIndexByColumnName(string $columnName): bool
    {
        return $this
            ->table
            ->hasIndexByName(
                $this->getIndexNameByColumnName($columnName)
            );
    }

    /**
     * Preparing index name based on column name.
     *
     * @param string $columnName
     *
     * @return string
     */
    private function getIndexNameByColumnName(string $columnName)
    {
        return
            static::PREFIX_FOR_INDEX
            . static::INDEX_SEPARATOR_CHAR
            . str_replace(
                static::PREFIX_FOR_INDEX,
                '',
                $columnName
            );
    }
}
