<?php

namespace App\Http\Controllers;

use App\Enums\BlockedStatus;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class UserController extends Controller
{
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            return $this->getUser();
        }

        $html = $builder->columns([
            Column::make('name')->title('Nama'),
            Column::make('email')->title('Email'),
            Column::make('role')->title('Role'),
            Column::make('office_id')->title('Kantor')
                ->data('office.name')
                ->name('office.name'),
            Column::make('is_blocked')->title('Status Blokir')
                ->render('function() {
                    return data ? `<span class="badge bg-danger">' . BlockedStatus::TERBLOKIR->label() . '</span>` 
                        : `<span class="badge bg-success">' . BlockedStatus::TIDAK_TERBLOKIR->label() . '</span>`;
                }')
                ->responsivePriority(-1),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->responsivePriority(-1),
        ])->parameters([
            'pageLength' => 10,
            'responsive' => true,
            'autoWidth' => false,
        ]);

        return view('users.index', compact('html'));
    }

    public function getUser()
    {
        $relationships = User::relationshipNames();
        $user = User::with($relationships)->get();

        return DataTables::of($user)
            ->addColumn('action', function ($user) {
                return view('users.action', compact('user'));
            })
            ->make(true);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserRequest $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validated();
            User::create($validatedData);

            DB::commit();

            return redirect()->route('users.index')->with('success', 'Data pengguna berhasil didaftarkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat pendaftaran pengguna. Silakan coba lagi.');
        }
    }

    public function unblock($id)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            $user->failed_login_attempts = 0;
            $user->is_blocked = FALSE;
            $user->save();

            DB::commit();

            return redirect()->route('users.index')->with('success', 'Akses pengguna berhasil dibuka.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->route('users.index')->with('error', 'Terjadi kesalahan saat membuka akses pengguna.');
        }
    }
}
