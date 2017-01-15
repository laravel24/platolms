<?php 

namespace App\Repositories;

class RoomRepository extends Repository
{

	/**
	 *
	 */
	public function __construct()
	{
		$this->table = 'rooms';
		$this->model = 'App\Models\Room';
	}

	/**
	 * Get the entity
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function getRoom($entityIdOrIds)
	{
		return $this->find($this->model, $entityIdOrIds);
	}

	/**
	 * Get a collection by a fields.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function getRoomsByIds(array $entityIds = null)
	{
		return $this->getRoom($entityIds);
	}

	/**
	 * Get a collection.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function getRooms(array $scopes = [])
	{
		return $this->findAllBy($this->model, $scopes);
	}

	/**
	 * Create an entity.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function createRoom(array $entityData)
	{
		return $this->create($this->table, $entityData);
	}

	/**
	 * Update the entity.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function updateRoom($entityId, array $entityData)
	{
		return $this->update($this->model, $entityId, $entityData);
	}

	/**
	 * Delete the entity.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function deleteRoom($entityId)
	{
		return $this->delete($this->model, $entityId);
	}

	/**
	 * Delete multiple entities.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function deleteRooms(array $entityIds)
	{
		$deletedRooms = [];
		foreach ($entityIds as $entityId)
		{
			$deletedRoom = $this->deleteRoom($entityId);
			array_push($deletedRooms, $deletedRoom);
		}

		return $deletedRooms;
	}

}
