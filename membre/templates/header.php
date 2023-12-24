<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--icon-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha384-GLhlTQ8iN17SJLlFfZVfP5z01K4JPTNqDQ5a6jgl5Up3H+9TP5IotK2+Obr4u" crossorigin="anonymous" />
    <script src="./js/main.js" defer></script>
    <title>Membre</title>
</head>

<body>
    <!-- In your header.php or any appropriate template file -->
    <header class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo or Branding -->
            <div class="text-xl font-bold w-32 mt-1">
                <img src="../../img/logov.PNG" class="w-full h-auto" alt="Logo">
            </div>

            <!-- Navigation Links -->
            <nav class="space-x-4">
                <a href="../src/index.php" class="hover:text-gray-300">Home</a>
                <a href="#" class="hover:text-gray-300">Projects</a>
                <a href="#" class="hover:text-gray-300">Team</a>
                <!-- Add more links as needed -->
            </nav>

            <!-- User Information -->
            <div class="flex items-center">
                <span class="mr-2">Membre</span>
                <a href="../../logout.php" class="hover:text-gray-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="w-6 h-6 mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    Logout
                </a>
            </div>
        </div>
    </header>
</body>

</html>
