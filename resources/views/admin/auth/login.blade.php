<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - DigiEdu PPDB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: "Plus Jakarta Sans", sans-serif; }</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 flex items-center justify-center p-4">
<div class="w-full max-w-md">
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center text-white font-bold text-3xl mx-auto mb-4">D</div>
        <h1 class="text-3xl font-extrabold text-white">DigiEdu<span class="text-blue-400">.</span></h1>
        <p class="text-slate-400 text-sm mt-1">Panel Admin PPDB</p>
    </div>
    <div class="bg-white rounded-3xl shadow-2xl p-8">
        <h2 class="text-xl font-extrabold text-slate-800 mb-1">Selamat Datang Kembali</h2>
        <p class="text-slate-500 text-sm mb-6">Masuk untuk mengelola sistem PPDB.</p>
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-5 text-sm font-semibold">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Email Admin</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@digiedu.sch.id"
                    class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Password</label>
                <input type="password" name="password" required placeholder="••••••••"
                    class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded">
                <label class="text-sm font-medium text-slate-600">Ingat saya</label>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white py-3.5 rounded-xl font-extrabold text-sm hover:from-blue-700 hover:to-blue-600 transition shadow-lg">
                Masuk ke Panel Admin
            </button>
        </form>
    </div>
    <p class="text-center text-slate-500 text-xs mt-6">© {{ date('Y') }} DigiEdu School.</p>
</div>
</body>
</html>