<?php

namespace App\Services;

use App\Exceptions\BusinessLogicException;
use App\Models\Team;
use App\Repositories\TeamRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class TeamService
{

    public function __construct(private TeamRepository $teamRepository)
    {
    }

    /**
     * @param array $data
     * @param int|null $limit
     * @return Collection|LengthAwarePaginator
     */
    public function getTeams(array $data = [], int $limit = null): Collection|LengthAwarePaginator
    {
        return $this->teamRepository->getTeams($data, $limit);
    }

    /**
     * @param array $data
     *
     * @return Model
     * @throws BusinessLogicException
     */
    public function createTeam(array $data): Model
    {
        $teams = Team::query()->without('school', 'color')->where('school_id', $data['school_id'])->where(
            'division_id',
            $data['division_id']
        )->get();

        if ($teams->isNotEmpty()) {
            if (count($teams) === 3) {
                throw new BusinessLogicException("Создано максимальное количество команд");
            }
            if (is_null($data['color_id'])) {
                throw new BusinessLogicException("Обязательно выберите цвет при создании 2-х одинаковых команд");
            }
            if ($teams->contains(function ($value, $key) use ($data) {
                return $value->color_id === (int)$data['color_id'];
            })) {
                throw new BusinessLogicException("Этот цвет уже выбран");
            }
        }

        $team = Team::query()->create($data);
        $team->loadMissing('division', 'league.city', 'color');

        return $team;
    }

    /**
     * @param int $teamId
     * @param array $data
     *
     * @return Model|Collection|null
     * @throws BusinessLogicException
     */
    public function updateTeam(int $teamId, array $data): Model|Collection|null
    {
        $team = Team::query()->without('color')->findOrFail($teamId);

        $teams = Team::query()->where('school_id', $team->school_id)->where('division_id', $team->division_id)->where(
            'id',
            '<>',
            $team->id
        )->get();

        if ($teams->isNotEmpty()) {
            if (empty($data['color_id'])) {
                throw new BusinessLogicException("Обязательно выберите цвет при создании 2-х одинаковых команд");
            }

            if ($teams->contains(function ($value, $key) use ($data) {
                return $value->color_id === (int)$data['color_id'];
            })) {
                throw new BusinessLogicException("Этот цвет уже выбран");
            }
        }

        $team->update($data);
        $team->loadMissing('division', 'league', 'color');

        return $team;
    }

    /**
     * @param int $teamId
     *
     * @return mixed
     */
    public function removeTeam(int $teamId): mixed
    {
        return Team::query()->where('id', $teamId)->delete();
    }
}
