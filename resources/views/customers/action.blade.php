@if (
    $customer->status === App\Enums\ApprovalStatus::MENUNGGU_APPROVAL->value &&
        auth()->user()->role === App\Enums\Role::SUPERVISI->value)
    <form action="{{ route('customers.approval', $customer->id) }}" method="POST" style="display: inline-block;">
        @csrf
        <button type="submit" class="btn btn-sm btn-success"
            onclick="return confirm('Apakah anda yakin ingin menyetujui pembukaan rekening ini?')">Approve</button>
    </form>
@endif
