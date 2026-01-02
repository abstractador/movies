<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen bg-slate-100 flex items-center justify-center">

<div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
    <h1 class="text-2xl font-bold text-center mb-6">Admin Login</h1>

    @error('email')
        <div class="mb-4 text-sm text-red-600 text-center">{{ $message }}</div>
    @enderror

    <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
        @csrf

        <input
            type="email"
            name="email"
            placeholder="Email"
            required
            class="w-full rounded-lg border px-4 py-3 focus:ring-2 focus:ring-indigo-500"
        />

        <input
            type="password"
            name="password"
            placeholder="Password"
            required
            class="w-full rounded-lg border px-4 py-3 focus:ring-2 focus:ring-indigo-500"
        />

        <button
            type="submit"
            class="w-full rounded-lg bg-indigo-600 py-3 text-white font-semibold hover:bg-indigo-500"
        >
            Sign In
        </button>
    </form>
</div>

</body>
</html>
