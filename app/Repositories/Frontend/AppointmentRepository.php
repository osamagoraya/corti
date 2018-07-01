<?php

namespace App\Repositories\Frontend;

use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;

/**
 * Class AppointmentRepository.
 */
class AppointmentRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Appointment::class;
    }

    public function findId($id)
    {
        $appointment = $this->model->find($id);

        return $appointment;

        throw new GeneralException(__('exceptions.backend.access.users.not_found'));
    }

   /* public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

        });
    }*/


    public function update($id, array $input, $image = false)
    {
        $appointment = $this->getById($id);

        return $appointment->save();
    }

}
