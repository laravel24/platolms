<?php 

namespace App\Repositories;

class CampusRepository extends Repository
{

	/**
	 *
	 */
	public function __construct()
	{
		$this->table = 'campuses';
		$this->model = 'App\Models\Campus';
	}

	/**
	 * Get the entity
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function getCampus($entityIdOrIds)
	{
		return $this->find($this->model, $entityIdOrIds);
	}

	/**
	 * Get a collection by a fields.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function getCampusesByIds(array $entityIds = null)
	{
		return $this->getCampus($entityIds);
	}

	/**
	 * Get a collection.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function getCampuses(array $scopes = [])
	{
		return $this->findAllBy($this->model, $scopes);
	}

	/**
	 * Create an entity.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function createCampus(array $entityData)
	{
		return $this->create($this->table, $entityData);
	}

	/**
	 * Update the entity.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function updateCampus($entityId, array $entityData)
	{
		return $this->update($this->model, $entityId, $entityData);
	}

	/**
	 * Delete the entity.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function deleteCampus($entityId)
	{
		return $this->delete($this->model, $entityId);
	}

	/**
	 * Delete multiple entities.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function deleteCampuses(array $entityIds)
	{
		$deletedCampuses = [];
		foreach ($entityIds as $entityId)
		{
			$deletedCampus = $this->deleteCampus($entityId);
			array_push($deletedCampuses, $deletedCampus);
		}

		return $deletedCampuses;
	}

}
