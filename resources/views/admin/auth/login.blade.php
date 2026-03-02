<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Sanjung Delights</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0D0D0D] min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-serif font-bold text-[#C9A84C]">Sanjung Delights</h1>
            <p class="text-gray-500 text-sm mt-2">Admin Panel</p>
        </div>

        {{-- Login Card --}}
        <div class="bg-[#111] border border-white/5 rounded-lg shadow-2xl p-8">
            @if($errors->any())
                <div class="mb-4 bg-red-900/30 border border-red-500/30 text-red-400 rounded-lg p-3 text-sm">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="text-gray-300 text-sm font-medium block mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full bg-[#1A1A1A] border border-white/10 text-white rounded-sm px-4 py-3
                                  focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none transition-colors duration-200">
                </div>
                <div>
                    <label class="text-gray-300 text-sm font-medium block mb-2">Password</label>
                    <input type="password" name="password" required
                           class="w-full bg-[#1A1A1A] border border-white/10 text-white rounded-sm px-4 py-3
                                  focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none transition-colors duration-200">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="rounded border-gray-600 bg-[#1A1A1A] text-[#C9A84C] focus:ring-[#C9A84C]">
                    <label for="remember" class="text-sm text-gray-400">Remember me</label>
                </div>
                <button type="submit"
                        class="w-full bg-[#C9A84C] hover:bg-[#B8973B] text-black font-bold py-3 px-8
                               uppercase tracking-widest text-sm rounded-sm transition-colors duration-200">
                    Sign In
                </button>
            </form>
        </div>
    </div>
</body>
</html>
