<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    // Internal Memo
    public function viewinternalmemo(User $user)
    {
        return $this->getPermission($user, 1);
    }
    public function editinternalmemo(User $user)
    {
        return $this->getPermission($user, 2);
    }
    public function createinternalmemo(User $user)
    {
        return $this->getPermission($user, 3);
    }
    // Location
    public function viewlocation(User $user)
    {
        return $this->getPermission($user, 4);
    }
    public function editlocation(User $user)
    {
        return $this->getPermission($user, 5);
    }
    public function createlocation(User $user)
    {
        return $this->getPermission($user, 6);
    }
    // schedule
    public function viewschedule(User $user)
    {
        return $this->getPermission($user, 7);
    }
    public function editschedule(User $user)
    {
        return $this->getPermission($user, 8);
    }
    public function createschedule(User $user)
    {
        return $this->getPermission($user, 9);
    }
    // business unit
    public function viewbusinessunit(User $user)
    {
        return $this->getPermission($user, 10);
    }
    public function editbusinessunit(User $user)
    {
        return $this->getPermission($user, 11);
    }
    public function createbusinessunit(User $user)
    {
        return $this->getPermission($user, 12);
    }
    // department
    public function viewdepartment(User $user)
    {
        return $this->getPermission($user, 13);
    }
    public function editdepartment(User $user)
    {
        return $this->getPermission($user, 14);
    }
    public function createdepartment(User $user)
    {
        return $this->getPermission($user, 15);
    }
    // division
    public function viewdivision(User $user)
    {
        return $this->getPermission($user, 16);
    }
    public function editdivision(User $user)
    {
        return $this->getPermission($user, 17);
    }
    public function createdivision(User $user)
    {
        return $this->getPermission($user, 18);
    }
    // employee
    public function viewemployee(User $user)
    {
        return $this->getPermission($user, 19);
    }
    public function editemployee(User $user)
    {
        return $this->getPermission($user, 20);
    }
    public function createemployee(User $user)
    {
        return $this->getPermission($user, 21);
    }
    // level
    public function viewlevel(User $user)
    {
        return $this->getPermission($user, 22);
    }
    public function editlevel(User $user)
    {
        return $this->getPermission($user, 23);
    }
    public function createlevel(User $user)
    {
        return $this->getPermission($user, 24);
    }
    // jobposition
    public function viewjobposition(User $user)
    {
        return $this->getPermission($user, 25);
    }
    public function editjobposition(User $user)
    {
        return $this->getPermission($user, 26);
    }
    public function createjobposition(User $user)
    {
        return $this->getPermission($user, 27);
    }
    // roster
    public function viewroster(User $user)
    {
        return $this->getPermission($user, 28);
    }
    public function editroster(User $user)
    {
        return $this->getPermission($user, 29);
    }
    public function createroster(User $user)
    {
        return $this->getPermission($user, 30);
    }
    // timeoff
    public function viewtimeoff(User $user)
    {
        return $this->getPermission($user, 31);
    }
    public function edittimeoff(User $user)
    {
        return $this->getPermission($user, 32);
    }
    public function createtimeoff(User $user)
    {
        return $this->getPermission($user, 33);
    }
    // reportattendance
    public function viewreportabsence(User $user)
    {
        return $this->getPermission($user, 34);
    }
    public function editreportabsence(User $user)
    {
        return $this->getPermission($user, 35);
    }
    // overtime
    public function viewovertime(User $user)
    {
        return $this->getPermission($user, 36);
    }
    public function editovertime(User $user)
    {
        return $this->getPermission($user, 37);
    }
    // reporttimeoff
    public function viewreporttimeoff(User $user)
    {
        return $this->getPermission($user, 38);
    }
    public function editreporttimeoff(User $user)
    {
        return $this->getPermission($user, 39);
    }
    // outofrange
    public function viewoutofrange(User $user)
    {
        return $this->getPermission($user, 40);
    }
    public function editoutofrange(User $user)
    {
        return $this->getPermission($user, 41);
    }
    // attendance
    public function viewattendance(User $user)
    {
        return $this->getPermission($user, 42);
    }
    public function editattendance(User $user)
    {
        return $this->getPermission($user, 43);
    }
    public function hakakses(User $user)
    {
        return $this->getPermission($user, 44);
    }
    public function exportdivision(User $user)
    {
        return $this->getPermission($user, 45);
    }
    public function exportdepartment(User $user)
    {
        return $this->getPermission($user, 46);
    }
    public function exportlocation(User $user)
    {
        return $this->getPermission($user, 47);
    }
    public function exportbusiness(User $user)
    {
        return $this->getPermission($user, 48);
    }
    public function exportschedule(User $user)
    {
        return $this->getPermission($user, 49);
    }
    public function exportemployee(User $user)
    {
        return $this->getPermission($user, 50);
    }
    public function exportlevel(User $user)
    {
        return $this->getPermission($user, 51);
    }
    public function exportattendance(User $user)
    {
        return $this->getPermission($user, 52);
    }
    public function exportreportovertime(User $user)
    {
        return $this->getPermission($user, 53);
    }
    public function exportreporttimeoff(User $user)
    {
        return $this->getPermission($user, 54);
    }
    public function exportreportoutofrange(User $user)
    {
        return $this->getPermission($user, 55);
    }
    public function exportreportattendance(User $user)
    {
        return $this->getPermission($user, 56);
    }
    public function approval_GA(User $user)
    {
        return $this->getPermission($user, 57);
    }
    public function superadmin_GA(User $user)
    {
        return $this->getPermission($user, 58);
    }

    protected function getPermission($user, $p_id)
    {
        foreach ($user->roles as $role) {
            foreach ($role->permissions as $permission) {
                if ($permission->id == $p_id) {
                    return true;
                }
            }
        }
        return false;
    }
}
