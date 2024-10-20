<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar senha</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="login-container bg-white p-6 rounded-lg shadow-lg w-80">
        <h2 class="text-2xl font-bold text-center mb-6">Recuperar senha</h2>
        @if (session()->has('status'))
        {{session()->get('status')}}
        @endif
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- @php
            dump(session());
        @endphp --}}

        <form method="POST" action="{{route('password.email')}}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" class="form-control mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="mb-4">
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">Alterar Senha</button>
            </div>
        </form>
    </div>
</body>
</html>
