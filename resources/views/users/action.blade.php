@if ($user->is_blocked)
    <form action="{{ route('users.unblock', $user->id) }}" method="POST" style="display: inline-block;">
        @csrf
        <button type="submit" class="btn btn-sm btn-primary"
            onclick="return confirm('Apakah anda yakin ingin membuka blokir pengguna ini?')">Unblock</button>
    </form>
@endif
