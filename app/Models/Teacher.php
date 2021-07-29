<?php

namespace App\Models;

use App\Models\Assign;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Teacher extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $guard = 'teacher';

    protected $fillable = [
        'name',
        'dob',
        'gender',
        'phone',
        'address',
        'email',
        'password',
        'status'
    ];

    protected $hidden = ['password', 'remember_token'];

    // cast geder to string
    public function getGenderAttribute($value)
    {
        return $value ? "Nam" : "Nữ";
    }

    // convert Y-m-d to d-m-Y when get dob Attribute
    public function getDobAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d', $value)
                      ->format('d-m-Y');
    }

    // convert d-m-Y to Y-m-d when set dob Attribute
    public function setDobAttribute($value)
    {
        $this->attributes['dob'] = Carbon::createFromFormat('d-m-Y', $value)
                                          ->format('Y-m-d');
    }

    /**
     * list assign (type: object) of teacher
     * @return [type] [description]
     */
    public function assigns()
    {
        return $this->hasMany(Assign::class, 'id_teacher');
    }

    /**
     * check if teacher has assign by status if staus exist else check all
     * @return boolean [description]
     */
    public function hasAssign($status = null) : bool
    {
        if ($status === null) {
            return $this->countAssign() > 0 ? true : false;
        }

        return $this->countAssign($status) > 0 ? true : false;
    }

    /**
     * get list of assign active
     * @return [type] [description]
     */
    public function assignsActive()
    {
        return $this->getAssign(1);
    }

    /**
     * get list of assign Inactive
     * @return [type] [description]
     */
    public function assignsInactive()
    {
        return $this->getAssign(0);
    }

    /**
     * get list of assign moved for other teacher
     * @return [type] [description]
     */
    public function assignsMoved()
    {
        return $this->getAssign(2);
    }

    /**
     * get list of assign done
     * @return [type] [description]
     */
    public function assignsDone()
    {
        return $this->getAssign(3);
    }

    /**
     * count number of assign by status if status exist else count all
     * @param  [type] $status [description]
     * @return [type]         [description]
     */
    public function countAssign($status = null) : int
    {
        // count all
        if ($status === null) {
            return count($this->assigns);
        }

        // count by status
        return count($this->assigns->where('status', $status));
    }

    /**
     * get assign of teacher by status if status exist else get all
     * @param  [type] $status [description]
     * @return [type]         [description]
     */
    public function getAssign($status = null)
    {
        // get all
        if ($status === null) {
            return $this->assigns;
        }

        // get by status
        return $this->assigns->where('status', $status);
    }
}
