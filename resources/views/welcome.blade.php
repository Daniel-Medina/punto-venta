<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <!-- component -->
<div class="container py-2 px-4 mt-4 mx-6">
    <div class="w-96 h-96 bg-gray-300 mx-auto py-6 px-6 rounded-lg shadow">
        <form autocomplete="off" method="POST" action="{{route('acceder')}}">
            @csrf
            <p class="font-bold text-black text-center my-4 text-4xl uppercase">Acceso</p>
            <div class="mb-4">
              <label class="block text-md mb-2 text-black font-bold" for="email">Email</label>
              <input class="w-full bg-drabya-gray appearance-none border p-4 font-light leading-tight focus:outline-none focus:shadow-outline rounded-lg h-10 {{$errors->has('email') ? 'border-red-500' : 'border-gray-500'}}" type="text" required name="email" id="" placeholder="Username">
              @error('email')
                  <small class="text-red-600">{{$message}}</small>
              @enderror
            </div>
            <div class="mb-4">
              <label class="block text-md mb-2 text-black font-bold" for="password">Contraseña</label>
              <input class="w-full bg-drabya-gray appearance-none border p-4 font-light leading-tight focus:outline-none focus:shadow-outline rounded-lg h-10 {{$errors->has('password') ? 'border-red-500' : 'border-gray-500'}}" type="password" required name="password" id="" placeholder="Password">
              @error('password')
                  <small class="text-red-600">{{$message}}</small>
              @enderror
            </div>
          
            <div class="flex items-center justify-between mb-5">
              <button type="submit" class="bg-indigo-800 hover:bg-blue-700 text-white font-light py-2 px-6 rounded focus:outline-none focus:shadow-outline" type="button">
                Acceder
              </button>
              <a class="inline-block align-baseline font-light text-sm text-indigo-600 hover:text-indigo-500" href="#">
                ¿Olvide mi coontraseña?
              </a>
            </div>

            <div class="flex">
                <input type="checkbox" name="recuerdame" class="mt-1 fixed">
                <p class="text-black ml-4">Recuerdame</p>
            </div>
            
        </form>
    </div>
</div>
</body>
</html>