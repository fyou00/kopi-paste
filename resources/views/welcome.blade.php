<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Kopi Paste</title>
</head>

<body class="bg-black text-white">

  <!-- NAVBAR -->
  <nav class="w-full fixed top-0 left-0 bg-transparent z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between py-6 px-6">

      <!-- Logo -->
      <h1 class="text-3xl font-light italic">Kopi Paste</h1>

      <!-- Menu -->
      <ul class="flex space-x-10 text-lg">
        <li><a href="#" class="hover:text-yellow-400 duration-200">Home</a></li>
        <li><a href="#" class="hover:text-yellow-400 duration-200">Menu</a></li>
        <li><a href="#" class="hover:text-yellow-400 duration-200">About Us</a></li>
        <li><a href="#" class="hover:text-yellow-400 duration-200">Contact Us</a></li>
      </ul>

    </div>
  </nav>

  <!-- HERO SECTION -->
  <section class="h-screen w-full relative flex items-center">

    <!-- Background -->
    <div class="absolute inset-0 -z-10">
      <img 
        src="images/coffee_image.png" 
        class="w-full h-full object-cover brightness-50"
      />
    </div>

    <div class="max-w-7xl mx-auto px-6">
      <p class="text-xl mb-2">We've got your morning covered with</p>

      <h1 class="text-[130px] font-serif mb-6 leading-none">Coffee</h1>

      <p class="max-w-xl text-lg mb-6">
        It is best to start your day with a cup of coffee. Discover the best
        flavours coffee you will ever have. We provide the best for our customers.
      </p>

      <a 
        href="#"
        class="bg-yellow-500 text-black px-6 py-3 rounded-full font-semibold text-lg hover:bg-yellow-400 duration-200"
      >
        Lihat Menu
      </a>
    </div>
  </section>

</body>
</html>
