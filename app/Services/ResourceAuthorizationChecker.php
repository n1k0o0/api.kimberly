<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ResourceAuthorizationChecker
{
    const DEFAULT_RESOURCE_COLUMN = 'id';
    const DEFAULT_FOREIGN_COLUMN = 'user_id';
    /**
     * @var string
     */
    private string $table;
    /**
     * @var string
     */
    private string $resourceColumn;
    /**
     * @var string
     */
    private string $resourceId;
    /**
     * @var string
     */
    private string $foreignColumn;
    /**
     * @var string
     */
    private string $foreignId;

    /**
     * AuthorizeResource constructor.
     */
    protected function __construct()
    {
        $this->table = '';
        $this->resourceColumn = self::DEFAULT_RESOURCE_COLUMN;
        $this->resourceId = '';
        $this->foreignColumn = self::DEFAULT_FOREIGN_COLUMN;
        $this->foreignId = '';
    }

    /**
     * @return ResourceAuthorizationChecker
     */
    static function create(): self
    {
        return new self();
    }

    public function reset(): self
    {
        return new self();
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param string $table
     *
     * @return ResourceAuthorizationChecker
     */
    public function setTable(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @return string
     */
    public function getResourceColumn(): string
    {
        return $this->resourceColumn;
    }

    /**
     * @param string $resourceColumn
     *
     * @return ResourceAuthorizationChecker
     */
    public function setResourceColumn(string $resourceColumn): self
    {
        $this->resourceColumn = $resourceColumn;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getResourceId(): ?string
    {
        return $this->resourceId;
    }

    /**
     * @param string $resourceId
     *
     * @return ResourceAuthorizationChecker
     */
    public function setResourceId(string $resourceId): self
    {
        $this->resourceId = $resourceId;

        return $this;
    }

    /**
     * @return string
     */
    public function getForeignColumn(): string
    {
        return $this->foreignColumn;
    }

    /**
     * @param string $foreignColumn
     *
     * @return ResourceAuthorizationChecker
     */
    public function setForeignColumn(string $foreignColumn): self
    {
        $this->foreignColumn = $foreignColumn;

        return $this;
    }

    /**
     * @return string
     */
    public function getForeignId(): string
    {
        return $this->foreignId;
    }

    /**
     * @param string $foreignId
     *
     * @return ResourceAuthorizationChecker
     */
    public function setForeignId(string $foreignId): self
    {
        $this->foreignId = $foreignId;

        return $this;
    }

    /**
     * @param string $resourceId
     * @param int|string $resourceColumn
     *
     * @return $this
     */
    public function withResource(string $resourceId, string $resourceColumn=self::DEFAULT_RESOURCE_COLUMN): self
    {
        $this->resourceId= $resourceId;
        $this->resourceColumn = $resourceColumn;

        return $this;
    }

    /**
     * @param string $foreignId
     * @param string $foreignColumn
     *
     * @return $this
     */
    public function withForeign(string $foreignId, string $foreignColumn=self::DEFAULT_FOREIGN_COLUMN): self
    {
        $this->foreignId = $foreignId;
        $this->foreignColumn = $foreignColumn;

        return $this;
    }

    /**
     * @return bool
     */
    public function check(): bool
    {
        return DB::table($this->table)
            ->where($this->resourceColumn, $this->resourceId)
            ->where($this->foreignColumn, $this->foreignId)
            ->exists();
    }
}
