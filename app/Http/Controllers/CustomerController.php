<?php

namespace App\Http\Controllers;

use App\Enums\ApprovalStatus;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\User;
use App\Notifications\CustomerApprovedNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class CustomerController extends Controller
{
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            return $this->getCustomer();
        }

        $html = $builder->columns([
            Column::make('name')->title('Nama'),
            Column::make('place_of_birth')->title('Tempat Lahir'),
            Column::make('birth_date')->title('Tanggal Lahir')
                ->width(150),
            Column::make('gender')->title('Jenis Kelamin'),
            Column::make('occupation_id')->title('Pekerjaan')
                ->data('occupation.name')
                ->name('occupation.name'),
            Column::make('province_id')->title('Provinsi')
                ->data('province.name')
                ->name('province.name'),
            Column::make('regency_id')->title('Kabupaten/Kota')
                ->data('regency.name')
                ->name('regency.name'),
            Column::make('district_id')->title('Kecamatan')
                ->data('district.name')
                ->name('district.name'),
            Column::make('village_id')->title('Kelurahan')
                ->data('village.name')
                ->name('village.name'),
            Column::make('deposit')->title('Nominal Setor')
                ->width(150)
                ->render("function () {
                    return 'Rp ' + parseFloat(data).toLocaleString('id-ID');
                }")
                ->responsivePriority(-1),
            Column::make('status')->title('Status')
                ->render('function() {
                    switch(data) {
                        case "' . ApprovalStatus::DISETUJUI->value . '":
                            return `<span class="badge bg-success">' . ApprovalStatus::DISETUJUI->label() . '</span>`;
                        default:
                            return `<span class="badge bg-warning">' . ApprovalStatus::MENUNGGU_APPROVAL->label() . '</span>`;
                    }
                }')
                ->responsivePriority(-1),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->responsivePriority(-1),
            Column::make('address')->title('Nama Jalan'),
            Column::make('rt')->title('RT'),
            Column::make('rw')->title('RW'),
            Column::make('user_id')->title('Dibuat oleh')
                ->data('creator.name')
                ->name('creator.name'),
            Column::make('user_id')->title('Diperbarui oleh')
                ->data('updater.name')
                ->name('updater.name'),
        ])->parameters([
            'pageLength' => 10,
            'responsive' => true,
            'autoWidth' => false,
        ]);

        return view('customers.index', compact('html'));
    }

    public function getCustomer()
    {
        $userOfficeId = Auth::user()->office_id;

        $relationships = Customer::relationshipNames();

        $customer = Customer::with($relationships)
            ->whereHas('creator', function ($query) use ($userOfficeId) {
                $query->where('office_id', $userOfficeId);
            })
            ->get();

        return DataTables::of($customer)
            ->addColumn('action', function ($customer) {
                return view('customers.action', compact('customer'));
            })
            ->make(true);
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(CustomerRequest $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validated();
            Customer::create($validatedData);

            DB::commit();

            return redirect()->route('customers.index')->with('success', 'Data nasabah berhasil didaftarkan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat pendaftaran nasabah. Silakan coba lagi.');
        }
    }

    public function approval($id)
    {
        DB::beginTransaction();

        try {
            $customer = Customer::findOrFail($id);
            $customer->status = ApprovalStatus::DISETUJUI;
            $customer->save();

            $createdByUser = User::findOrFail($customer->created_by);
            $createdByUser->notify(new CustomerApprovedNotification($customer, $createdByUser));

            DB::commit();

            return redirect()->route('customers.index')->with('success', 'Pendaftaran nasabah disetujui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->route('customers.index')->with('error', 'Terjadi kesalahan saat menyetujui pendaftaran nasabah.');
        }
    }
}
