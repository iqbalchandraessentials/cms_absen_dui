<?php

namespace App\Http\Controllers\api;

use App\Exports\EmployeeExport;
use App\Helpers\ImageIntervention;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Imports\EmployeeImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function fetch(Request $request)
    {
        $users = User::find(Auth::id());
        $roles = $users->roles;
        if ($roles->isNotEmpty()) {
            $nama_role = $roles[0]->name;
        } else {
            $nama_role = 'USER';
        }
        $now = Carbon::now();
        $formattedDate = $now->format('Y-m-d');
        $user = $request->user();
        $shift = $users->getshifttoday(Auth::id(), $formattedDate);
        $data = $shift->original['data'];
        $name = $data->Shift->name;
        $attend = $users->narik_libur($now->month, $now->year);
        $jml_absen = 0;
        $hari_kerja = 0;

        $empty_clock_in = [];
        $empty_clock_out = [];

        foreach ($attend as $value) {
            if ($value['status'] == "weekday" || $value['status'] == "SatDay") {
                $hari_kerja++;

                if ($value['attendance']['clock_in'] != "") {
                    $jml_absen++;
                } else {
                    $empty_clock_in[] = $value['date'];
                }

                // if (Auth::user()->organization_id == 10) {
                //     if ($value['attendance']['actual_check_out'] == "-") {
                //         $empty_clock_out[] =  $value['date'];
                //     }
                // } else {
                if ($value['attendance']['clock_out'] == "") {
                    $empty_clock_out[] = $value['date'];
                }
                // }
            }
        };
        $persentase_absen = ($jml_absen / $hari_kerja) * 100;
        $user->roles = $nama_role;
        $user->jml_absen = $jml_absen;
        $user->hari_kerja = $hari_kerja;
        $user->empty_clock_in = $empty_clock_in;
        $user->empty_clock_out = $empty_clock_out;
        $user->persentase_absen = $persentase_absen . '%';
        $schedule_in = $data->Shift->schedule_in;
        $schedule_out = $data->Shift->schedule_out;
        $shift = (object) [
            'name' => $name,
            'schedule_in' => $schedule_in,
            'schedule_out' => $schedule_out,
        ];
        $user->sisa_cuti = $user->kuota_cuti($user->id);
        $user->shift = $shift;
        $user->location = $user->location;
        $user->division = $user->division;
        $user->organization = $user->organization;
        $user->department = $user->department;
        $user->job_position = $user->position;
        $user->currentTime = (string) Carbon::now();
        $user->makeHidden('schedule')->toArray();
        return ResponseFormatter::success($request->user(), 'Data profile user berhasil diambil');
    }

    public function loginpost(Request $request)
    {
        $credentials = request(['nik', 'password']);
        if (!Auth::attempt($credentials)) {
            return view('auth.Auth_wrong');
        }

        $user = User::where('nik', $request->nik)->first();
        if (!Hash::check($request->password, $user->password, [])) {
            throw new \Exception('Invalid Credentials');
        }

        $tokenResult = $user->createToken('authToken')->plainTextToken;

        Auth::login($user, true);

        $request->session()->put('token', $tokenResult);

        return redirect(route('home'));
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'nik' => 'required',
                'password' => 'required'
            ]);

            $credentials = request(['nik', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 500);
            }

            $user = User::where('nik', $request->nik)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            $user->location = $user->location;
            $user->division = $user->division;
            $user->organization = $user->organization;
            $user->department = $user->department;
            $user->slug = (object) [
                'location' => Str::slug($user->location->name),
                'division' => Str::slug($user->division->name),
                'organization' => Str::slug($user->organization->name),
                'department' => Str::slug($user->department->name),
            ];
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated');
        } catch (Exception $e) {
            // return $e;
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $e,
            ], 'Authentication Failed', 500);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function updateProfile(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $user->update($data);
        return ResponseFormatter::success($user, 'Profile Updated');
    }

    public function division()
    {
        $data = User::select('id', 'nik', 'name', 'photo_path')->where('active', 1)->where('division_id', (int) Auth::user()->division_id)->get();
        return ResponseFormatter::success($data, 'your team division');
    }

    public function export_excel()
    {
        $download = Excel::download(new EmployeeExport(), 'ReportEmployee.xlsx');
        return $download;
    }

    public function import_excel(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        try {
            Excel::import(new EmployeeImport, request()->file('file'));
            Session::flash('sukses', 'Sparepart has successfully import');
            // If the import was successful, you can set a success flash message.
            return redirect(route('employee.index'))->with('success', 'Data has been imported successfully!');
        } catch (\Exception $e) {
            // If an error occurred during the import, you can set an error flash message.
            return redirect(route('employee.index'))->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'nik' => 'required',
                'old_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ]);

            $user = User::where('nik', $request->nik)->first();

            if (!$user || !Hash::check($request->old_password, $user->password)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 500);
            }

            $user->password = Hash::make($request->new_password);
            $user->is_password_default = '1';
            $user->save();

            return ResponseFormatter::success([
                'message' => 'Password updated successfully'
            ], 'Password Updated');
        } catch (Exception $e) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $e,
            ], 'Update Password Failed', 500);
        }
    }

    public function resetToDefaultPassword(Request $request)
    {
        try {
            $request->validate([
                'nik' => 'required',
            ]);

            $user = User::where('nik', $request->nik)->first();
            if (!$user) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 500);
            }

            $nik = $user->nik;
            $defaultPassword = 'cendol' . $nik;
            $user->password = Hash::make($defaultPassword);
            $user->is_password_default = '0';
            $user->save();

            return ResponseFormatter::success([
                'message' => 'Password reset to default successfully'
            ], 'Password Reset');
        } catch (Exception $e) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $e,
            ], 'Reset Password Failed', 500);
        }
    }

    public function get_timezone(Request $request)
    {
        $latitude = $request->query('latitude');
        $longitude = $request->query('longitude');

        $process = new Process(['node', base_path('timezone.js'), $latitude, $longitude]);

        try {
            $process->mustRun();
            $output = $process->getOutput();

            $timezone = trim($output);

            $date = new \DateTime('now', new \DateTimeZone($timezone));
            $localDateTime = $date->format('Y-m-d H:i:s');

            return response()->json([
                'timezone' => $timezone,
                'current_local_time' => $localDateTime
            ]);
        } catch (ProcessFailedException $exception) {
            return response()->json(['error' => "Something went wrong."], 500);
        }
    }


    public function create_avatar(Request $request)
    {
        $name = $request->input('name');
        $initials = $this->getInitials($name);

        $img = Image::canvas(100, 100, '#013365');

        $img->text($initials, 50, 50, function ($font) {
            $font->file(public_path('fonts/Arial.ttf'));
            $font->size(50);
            $font->color('#FFF');
            $font->align('center');
            $font->valign('middle');
        });

        return $img->response('png');
    }

    private function getInitials($name)
    {
        $parts = explode(" ", $name);
        $initials = "";

        for ($i = 0; $i < count($parts); $i++) {
            if (isset($parts[$i][0])) {
                $initials .= strtoupper($parts[$i][0]);
            }

            if (strlen($initials) == 2) {
                break;
            }
        }

        return $initials;
    }

    public function getAllKaryawan(Request $request)
    {
        $query = User::with([
            'department',
            'division',
            'level',
            'location',
            'manager',
            'position',
            'organization',
            'todaysAttendance',
        ])->select(
            'id',
            'nik',
            'name',
            'department_id',
            'division_id',
            'location_id',
            'organization_id',
            'manager_id',
            'job_position',
            'mobile_phone',
            'email',
            'job_level_id',
            'approval_line_id',
            'grade',
            'photo_path'
        );

        if ($request->query('search')) {
            $query = $query->where('name', 'like', '%' . $request->query('search') . '%');
        }

        $user_id = Auth::user()->id;
        $approval_line_id = Auth::user()->approval_line_id;
        $department_id = Auth::user()->department_id;
        $division_id = Auth::user()->division_id;
        $is_boss = Auth::user()->is_boss;

        $query = $query->where('active', 1);

        if ($request->query('get_my_team') == "true") {
            $count = User::where('approval_line_id', $user_id)->count();

            $query = $query->where(function ($q) use ($approval_line_id, $user_id) {
                $q->where('approval_line_id', $approval_line_id)
                    ->orWhere('approval_line_id', $user_id);
            });

            if ($count > 1) {
                if ($is_boss == 1) {
                    $query;
                } else {
                    $query = $query->where('division_id', $division_id);
                }
            } else {
                $query = $query->where('department_id', $department_id);
            }
        }

        $data = $query->orderBy('name')->paginate(20);

        $data = ImageIntervention::userFormat($data);

        foreach ($data as $user) {
            $currentDate = now();
            $currentSchedule = $user->available_schedules($currentDate)->first();

            if ($currentSchedule && $currentSchedule->schedule && $currentSchedule->schedule->shift) {
                $currentShift = $currentSchedule->schedule->shift->first();
                $user->shift = [
                    'name' => $currentShift->name ?? null,
                    'schedule_in' => $currentShift->schedule_in ?? null,
                    'schedule_out' => $currentShift->schedule_out ?? null
                ];
            } else {
                $user->shift = [
                    'name' => null,
                    'schedule_in' => null,
                    'schedule_out' => null
                ];
            }

            $user->clock_in_time = $user->todaysAttendance->check_in ?? null;

            $user->clock_out_time = $user->todaysAttendance->check_out ?? null;
        }

        return response()->json(['data' => $data]);
    }
}
