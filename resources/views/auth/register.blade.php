<x-guest-layout>

    <div class="flex gap-5">
        <a class="px-4 py-2 text-lg font-semibold tracking-widest text-center text-white transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md cursor-pointer dark:bg-gray-200 dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
           href="{{ route('teacher.registration') }}">Teacher Registration</a>
        <a class="px-4 py-2 text-lg font-semibold tracking-widest text-center text-white transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md cursor-pointer dark:bg-gray-200 dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
           href="{{ route('student.registration') }}">Student Registration
        </a>
    </div>
    
</x-guest-layout>
