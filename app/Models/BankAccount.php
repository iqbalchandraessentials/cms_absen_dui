<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $table = 'bank_account';

    protected $fillable = ['id_employee', 'account_number', 'bank_name', 'user_account_bank'];

}
