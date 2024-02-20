<?php

namespace App\Console\Commands;

use App\Models\KuotaCuti;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class schedule_dum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule_dum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        // jika user karyawan dum dan join date nya adalah hari ini
        $user = User::select('id', 'name', 'join_date')->where('organization_id', 10)->where('active', 1)->whereMonth('join_date', $now->month)->whereDay('join_date', $now->day)->get();
        foreach ($user as $key => $value) {
            $cuti_quota = KuotaCuti::find($value->cuti_kuota->id);
            $cuti_quota->kuota_cuti = 12;
            $cuti_quota->save();
        }
    }
}
