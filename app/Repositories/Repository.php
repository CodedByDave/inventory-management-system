<?php

namespace App\Repositories;

use Attribute;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

use function PHPSTORM_META\map;

abstract class Repository
{
    /**
     * base repo constructor
     */
    public function __construct(protected Model $model) {}

    // return model
    public function Model(): Model
    {
        return $this->model;
    }

    // start query
    public function query(): Builder
    {
        return $this->model->query();
    }

    // paginate data
    public function paginate(int $perPage = 15, array $columns = ['*'], array|string $relations = []): LengthAwarePaginator
    {
        return $this->model->with($relations)->paginate($perPage, $columns);
    }

    // find by id
    public function find(int $id, array $columns = ['*'], array|string $relations = []): ?Model
    {
        return $this->model->with($relations)->find($id, $columns);
    }

    // create record
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    // update record
    public function update(Model $model, array $data): bool
    {
        return $model->update($data);
    }

    // update or create record
    public function updateOrCreate(array $attributes, array $values = []): Model
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    // delete record
    public function delete(Model $model): bool
    {
        return $model->delete();
    }
}
