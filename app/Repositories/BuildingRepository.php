<?php 

namespace App\Repositories;

class BuildingRepository extends Repository
{

	/**
	 *
	 */
	public function __construct()
	{
		$this->table = 'buildings';
		$this->model = 'App\Models\Building';
	}

	/**
	 * Get the entity
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function getBuilding($entityIdOrIds)
	{
		return $this->find($this->model, $entityIdOrIds);
	}

	/**
	 * Get a collection by a fields.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function getBuildingsByIds(array $entityIds = null)
	{
		return $this->getBuilding($entityIds);
	}

	/**
	 * Get a collection.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function getBuildings(array $scopes = [])
	{
		return $this->findAllBy($this->model, $scopes);
	}

	/**
	 * Create an entity.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function createBuilding(array $entityData)
	{
		return $this->create($this->table, $entityData);
	}

	/**
	 * Update the entity.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function updateBuilding($entityId, array $entityData)
	{
		return $this->update($this->model, $entityId, $entityData);
	}

	/**
	 * Delete the entity.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function deleteBuilding($entityId)
	{
		return $this->delete($this->model, $entityId);
	}

	/**
	 * Delete multiple entities.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function deleteBuildings(array $entityIds)
	{
		$deletedBuildings = [];
		foreach ($entityIds as $entityId)
		{
			$deletedBuilding = $this->deleteBuilding($entityId);
			array_push($deletedBuildings, $deletedBuilding);
		}

		return $deletedBuildings;
	}

}
