<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Uji komite etik | {{ $title ?? 'Laravel App' }}</title>
    <link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/commons/f/fa/Logo-UNUJA.png">
</head>
<body>
  <x-Navbar></x-Navbar>

    <div class="flex flex-col md:flex-row">
      <x-Sidebar></x-Sidebar>
    
      <main class="flex-1 p-8 md:pt-24 pt-22 md:p-6 md:pl-58 overflow-x-auto">
        <h1 class="text-3xl font-bold mb-4">{{ $title }}</h1>

      {{ $slot }}

      </main>
      
    </div>
  </body>
</html>