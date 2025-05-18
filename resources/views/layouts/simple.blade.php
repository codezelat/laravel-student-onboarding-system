<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SITC Diploma Registration')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />

    {{-- Custom Styles from the example --}}
    <style>
        body {
            /* Smoother gradient, adjust colors slightly if needed */
            background-image: linear-gradient(to bottom, theme('colors.slate.50'), theme('colors.gray.100'), theme('colors.slate.100'));
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        /* Keep the focus style if you like it */
        /* input:focus, select:focus, textarea:focus {
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.25);
        } */
        .form-outer-container {
            /* Animation applied to the main content block */
            animation: fadeIn 0.6s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Style for the main heading underline */
        .heading-underline {
            position: relative;
            display: inline-block; /* Needed for underline positioning */
        }
        .heading-underline:after {
            content: "";
            position: absolute;
            bottom: -10px; /* Adjusted position */
            left: 50%;
            transform: translateX(-50%);
            width: 70px; /* Adjusted width */
            height: 3px;
            background: linear-gradient(to right, theme('colors.blue.500'), theme('colors.blue.400')); /* Use theme colors */
            border-radius: 3px;
        }
         /* Ensure icons inside inputs are vertically centered */
         .input-icon-wrapper .absolute svg {
            top: 50%;
            transform: translateY(-50%);
        }
        /* Style for the file upload preview */
        #file-name-display {
            background-color: theme('colors.gray.100');
            border: 1px solid theme('colors.gray.200');
            padding: 0.5rem 0.75rem;
            border-radius: theme('borderRadius.lg');
            margin-top: 0.5rem;
            font-size: theme('fontSize.sm');
            color: theme('colors.gray.700');
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        #file-name-display svg {
            flex-shrink: 0;
        }
    </style>
     @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Keep Vite if you are using it alongside CDNs --}}
</head>
<body class="min-h-screen py-8 sm:py-12 px-4">

    <div class="form-outer-container max-w-5xl mx-auto">

        <div class="flex flex-col items-center mb-8">
            <img src="{{ asset('images/sitc-logo.png') }}" alt="SITC Logo" class="h-16 md:h-20 mb-5">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 text-center heading-underline mb-5">@yield('page_heading')</h1>
            {{-- Academic Year Badge --}}
            <div class="inline-flex items-center mt-3 text-blue-700 bg-blue-100 px-3 py-1 rounded-full">
                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-xs font-medium">Academic Year 2025</span>
            </div>
        </div>


        <main>
            @yield('content')
        </main>

    </div>{{-- Flowbite JS - Place at the end --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
     @stack('scripts') {{-- Add a stack for page-specific scripts --}}
</body>
</html>