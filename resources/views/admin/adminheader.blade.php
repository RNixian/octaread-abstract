<!-- resources/views/layouts/header.blade.php -->

<header>
    <nav class="bg-gray-800 p-4 text-white flex justify-between items-center">
        <div class="text-xl font-bold">
            My Laravel App
        </div>


    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="hover:bg-red-600 text-white font-bold py-2 px-6 rounded focus:outline-none focus:ring-2 focus:ring-green-300 inline-block">
            Log Out 
        </button>
    </form>


    </nav>
</header>
