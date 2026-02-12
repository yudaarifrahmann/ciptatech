<?php
namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('division')->latest()->get();
        return view('superadmin.users.index', compact('users'));
    }

    public function create()
    {
        $divisions = Division::where('is_active', 1)
                            ->orderBy('name')
                            ->get();
        return view('superadmin.users.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        // Validasi sesuai dengan option di form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:PIC,supervisor,admin_divisi',
            'password' => 'required|min:8|confirmed',
            'division_id' => 'nullable|exists:divisions,id'
        ]);

        // Logika untuk role yang tidak perlu divisi
        // Note: Di database Anda hanya ada 'supervisor' dan 'superadmin', tidak ada 'admin_divisi'
        // Jadi kita perlu menyesuaikan
        
        if ($validated['role'] === 'supervisor') {
            // Supervisor tidak memerlukan divisi
            $validated['division_id'] = null;
        } elseif ($validated['role'] === 'admin_divisi') {
            // Admin divisi tetap memerlukan divisi
            // Tidak ada perubahan, biarkan division_id tetap
        } else {
            // PIC memerlukan divisi
            // Tidak ada perubahan
        }

        // Divisi wajib untuk PIC dan admin_divisi
        if (in_array($validated['role'], ['PIC', 'admin_divisi']) && empty($validated['division_id'])) {
            return back()->withErrors(['division_id' => 'Divisi wajib dipilih untuk ' . $validated['role']]);
        }

        // Convert admin_divisi ke role yang ada di database
        $roleForDatabase = $validated['role'];
        if ($roleForDatabase === 'admin_divisi') {
            // Anda perlu memutuskan apakah admin_divisi akan disimpan sebagai apa
            // Opsi 1: Simpan sebagai 'supervisor' dengan hak khusus
            // Opsi 2: Tambahkan role 'admin_divisi' ke database
            // Saya sarankan opsi 1 untuk saat ini
            $roleForDatabase = 'supervisor'; // Atau sesuaikan dengan kebutuhan
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $roleForDatabase,
            'division_id' => $validated['division_id'],
            'password' => Hash::make($validated['password']),
            'is_active' => 1
        ]);

        return redirect()->route('superadmin.users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        $divisions = Division::where('is_active', 1)
                            ->orderBy('name')
                            ->get();
        
        // Convert role dari database ke role untuk form
        $user->form_role = $user->role;
        // Jika role di database adalah supervisor tapi mungkin sebenarnya admin_divisi
        // Anda perlu logika untuk membedakan
        
        return view('superadmin.users.edit', compact('user', 'divisions'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:PIC,supervisor,admin_divisi',
            'division_id' => 'nullable|exists:divisions,id',
            'password' => 'nullable|min:8|confirmed'
        ]);

        // Logika untuk role yang tidak perlu divisi
        if ($validated['role'] === 'supervisor') {
            $validated['division_id'] = null;
        }

        // Divisi wajib untuk PIC dan admin_divisi
        if (in_array($validated['role'], ['PIC', 'admin_divisi']) && empty($validated['division_id'])) {
            return back()->withErrors(['division_id' => 'Divisi wajib dipilih untuk ' . $validated['role']]);
        }

        // Convert admin_divisi ke role yang ada di database
        $roleForDatabase = $validated['role'];
        if ($roleForDatabase === 'admin_divisi') {
            $roleForDatabase = 'supervisor'; // Atau sesuaikan dengan kebutuhan
        }

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $roleForDatabase,
            'division_id' => $validated['division_id'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('superadmin.users.index')
            ->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        // Cegah penghapusan diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }
        
        $user->delete();
        
        return redirect()->route('superadmin.users.index')
            ->with('success', 'User berhasil dihapus');
    }

    public function resetPassword(Request $request, User $user)
    {
        // Generate random password
        $newPassword = \Illuminate\Support\Str::random(12);
        
        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        // TODO: Send email dengan password baru ke user
        // Mail::send(new ResetPasswordMail($user, $newPassword));
        
        return back()->with('success', 'Password berhasil direset. Password baru: ' . $newPassword);
    }

    public function toggleStatus(User $user)
    {
        // Cegah menonaktifkan diri sendiri
        if ($user->id === auth()->id() && !$user->is_active) {
            return back()->with('error', 'Tidak dapat menonaktifkan akun sendiri');
        }
        
        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Status user berhasil $status");
    }
}