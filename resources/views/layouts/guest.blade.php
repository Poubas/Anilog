<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- Guest Navigation -->
            <nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <a href="{{ url('/') }}">
                                    <svg width="1236.000000pt" height="1500.000000pt" viewBox="0 0 1236.000000 1500.000000"preserveAspectRatio="xMidYMid meet" class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200">
                                    <g transform="translate(0.000000,1500.000000) scale(0.100000,-0.100000)"
                                    fill="#FFFFFF" stroke="none">
                                        <path d="M5910 14334 c-257 -21 -491 -79 -728 -181 -57 -24 -419 -202 -805
                                        -395 l-702 -352 -165 3 c-113 2 -195 -2 -260 -13 -444 -72 -700 -339 -761
                                        -794 -18 -131 -6 -385 26 -572 26 -151 26 -157 10 -215 -20 -74 -102 -247
                                        -185 -390 -83 -145 -208 -342 -230 -363 -9 -9 -214 -445 -453 -969 l-436 -952
                                        -11 -508 c-5 -279 -10 -751 -10 -1048 0 -1042 33 -1501 135 -1880 19 -71 51
                                        -188 70 -260 19 -71 48 -195 65 -275 34 -164 66 -266 120 -390 132 -300 389
                                        -603 749 -880 46 -36 95 -74 109 -86 l25 -21 -93 -149 c-135 -215 -281 -433
                                        -375 -559 -87 -116 -193 -225 -219 -225 -9 0 -25 18 -36 40 -47 93 -209 266
                                        -391 420 -219 184 -378 275 -482 275 -72 0 -88 -16 -116 -113 -66 -226 -55
                                        -376 59 -842 79 -321 203 -579 411 -857 93 -123 259 -290 321 -323 l48 -25 36
                                        20 c137 73 737 674 1519 1519 l227 246 42 -26 c320 -196 945 -407 1588 -535
                                        109 -21 201 -39 204 -39 19 0 -125 -219 -182 -277 -51 -51 -71 -53 -170 -19
                                        -38 12 -121 36 -184 52 -98 24 -136 28 -256 28 -137 1 -142 0 -199 -29 -82
                                        -42 -116 -98 -122 -198 -6 -81 39 -362 82 -526 92 -346 387 -833 685 -1132
                                        121 -122 188 -161 273 -162 100 -1 161 48 351 282 216 265 318 462 651 1253
                                        75 178 168 388 206 467 57 120 72 142 86 136 47 -17 406 -109 548 -140 247
                                        -52 373 -68 540 -68 187 -1 241 12 435 103 80 37 172 76 205 85 224 65 649
                                        369 1235 884 155 136 165 147 210 223 24 40 44 75 46 77 1 2 65 -11 141 -27
                                        249 -56 348 -67 583 -66 200 0 222 2 313 26 176 48 285 126 347 248 103 204
                                        100 460 -8 625 -42 64 -136 159 -189 190 -18 11 -33 22 -33 26 0 3 21 14 48
                                        24 26 9 90 40 142 67 273 144 415 286 413 413 0 62 -19 100 -77 155 -63 60
                                        -75 68 -317 191 -308 157 -427 240 -358 251 30 4 1062 1549 1148 1718 154 302
                                        182 551 84 732 -41 76 -136 157 -250 216 -349 179 -594 161 -898 -65 -116 -86
                                        -370 -341 -606 -608 -606 -684 -919 -1037 -966 -1089 l-53 -60 -37 45 c-235
                                        281 -628 461 -1096 500 -347 29 -834 -40 -1257 -176 -61 -20 -114 -34 -117
                                        -31 -14 14 68 470 128 708 117 469 230 769 464 1239 141 283 220 474 303 729
                                        275 844 448 1999 429 2860 -8 347 -35 563 -93 760 -51 169 -86 214 -324 412
                                        -470 391 -826 578 -1228 642 -96 16 -305 27 -382 20z m422 -402 c292 -76 523
                                        -245 701 -513 182 -275 349 -593 412 -783 61 -186 78 -316 72 -556 -10 -374
                                        -89 -751 -363 -1720 -190 -672 -326 -1096 -763 -2380 -219 -644 -213 -614
                                        -208 -1115 3 -396 7 -445 39 -488 18 -24 110 -44 232 -53 l106 -7 0 65 c0 36
                                        3 99 6 141 l7 76 71 30 c397 163 931 221 1341 145 276 -52 581 -187 814 -362
                                        l75 -55 -127 -123 c-170 -165 -157 -158 -241 -134 -174 50 -307 65 -566 64
                                        -277 -1 -416 -17 -665 -78 -136 -34 -351 -103 -448 -145 l-48 -21 20 -39 c32
                                        -62 104 -118 183 -142 68 -21 76 -21 361 -10 589 24 987 -34 1301 -191 394
                                        -196 654 -565 743 -1053 23 -123 23 -402 0 -505 -9 -41 -36 -115 -61 -165 -25
                                        -49 -48 -102 -53 -117 -9 -29 -117 -124 -413 -361 -589 -473 -866 -631 -1176
                                        -669 -120 -14 -277 -2 -634 52 -391 58 -518 72 -695 73 -142 2 -165 0 -200
                                        -18 -30 -15 -39 -25 -38 -42 3 -28 -152 -498 -257 -778 -265 -707 -494 -1113
                                        -653 -1156 -36 -9 -47 -8 -85 10 -147 72 -311 329 -458 721 -54 143 -165 491
                                        -159 498 1 1 31 -15 66 -36 123 -75 333 -185 377 -199 108 -32 193 -3 287 98
                                        57 62 115 153 253 401 34 62 98 161 141 220 90 122 121 183 121 233 0 75 -48
                                        126 -170 184 -118 55 -279 99 -674 187 -535 117 -740 175 -1026 287 -348 136
                                        -802 397 -1165 670 -114 86 -348 324 -441 447 -350 467 -576 1094 -679 1885
                                        -36 275 -47 450 -52 852 -8 617 26 1119 112 1649 l25 152 229 528 c508 1171
                                        561 1289 573 1285 60 -17 1459 -282 2203 -416 576 -104 820 -144 960 -156 66
                                        -5 156 -14 200 -19 157 -18 279 -22 340 -11 57 10 105 35 112 57 23 69 -1139
                                        394 -2513 703 -464 105 -802 173 -977 198 l-123 18 97 293 c54 162 99 295 101
                                        297 2 1 64 -13 138 -32 174 -44 301 -63 422 -63 l98 0 -31 -50 c-63 -103 -87
                                        -227 -55 -288 67 -128 266 -176 736 -176 253 0 363 13 474 55 157 60 163 151
                                        20 295 -90 89 -163 134 -220 134 -62 0 -68 -13 -55 -116 6 -48 9 -89 7 -91 -9
                                        -10 -139 -23 -226 -23 -142 0 -210 27 -210 82 0 31 71 95 179 162 105 65 371
                                        200 546 276 130 57 165 83 198 145 43 84 18 175 -63 229 l-39 26 -151 -66
                                        c-83 -37 -153 -65 -155 -62 -2 2 1 22 7 44 7 21 12 86 12 144 -1 206 -93 468
                                        -268 763 l-44 75 156 77 c87 42 171 87 187 100 44 33 902 399 1008 429 76 22
                                        183 45 282 60 17 2 109 3 205 1 156 -3 188 -6 292 -33z m-2292 -892 c36 -39
                                        101 -173 134 -277 37 -120 49 -201 44 -321 -4 -127 -30 -195 -98 -261 -110
                                        -107 -339 -119 -615 -34 -78 24 -115 43 -84 43 26 0 179 79 256 132 140 97
                                        246 237 287 379 17 59 23 152 17 275 -5 102 9 117 59 64z m7280 -4729 c109
                                        -42 208 -140 252 -251 19 -47 22 -74 22 -180 0 -109 -4 -136 -28 -210 -37
                                        -112 -110 -258 -191 -379 -99 -149 -246 -319 -541 -626 -663 -692 -859 -898
                                        -862 -906 -5 -13 195 -141 321 -205 173 -88 380 -154 488 -154 48 0 140 -41
                                        185 -82 57 -52 94 -128 94 -190 0 -89 -41 -147 -135 -190 -44 -20 -65 -23
                                        -185 -22 -145 0 -234 17 -435 83 -54 18 -91 25 -94 19 -2 -5 80 -94 182 -196
                                        236 -238 302 -316 379 -452 66 -115 86 -254 49 -335 -36 -80 -126 -140 -247
                                        -165 -81 -18 -279 -15 -394 4 -198 34 -376 107 -367 151 2 11 15 67 28 125 31
                                        142 34 457 5 589 -54 247 -173 491 -342 698 -173 213 -441 436 -622 517 -23
                                        10 -42 22 -42 26 0 5 46 48 103 96 447 385 980 886 1316 1237 348 364 545 599
                                        692 827 93 145 128 186 162 194 45 9 154 -2 207 -23z m-8345 -4843 l183 -113
                                        -72 -79 c-286 -319 -844 -883 -1086 -1099 -245 -219 -417 -337 -491 -337 -168
                                        0 -453 648 -569 1293 -34 189 -25 232 42 204 76 -33 173 -129 609 -602 91 -99
                                        185 -193 208 -209 l42 -30 35 19 c89 48 411 423 823 958 45 59 85 107 88 107
                                        2 0 87 -51 188 -112z"/>
                                        <path d="M5977 12509 c-443 -48 -768 -482 -872 -1167 -6 -36 -3 -46 18 -72 14
                                        -16 54 -80 89 -141 96 -168 115 -182 338 -257 375 -124 579 -166 810 -166 177
                                        0 250 14 365 70 126 62 219 154 373 372 161 228 219 385 209 567 -6 122 -31
                                        198 -96 298 -130 197 -372 343 -726 437 -202 54 -374 74 -508 59z m722 -386
                                        c105 -138 221 -414 252 -597 19 -111 8 -249 -26 -324 -49 -109 -132 -169 -276
                                        -198 -164 -33 -402 3 -719 109 l-185 62 70 2 c218 8 376 42 521 114 80 39 114
                                        62 163 114 143 149 171 320 101 615 -33 137 -36 170 -19 187 20 20 63 -11 118
                                        -84z"/>
                                        <path d="M5180 9026 c-36 -19 -102 -71 -172 -135 -4 -3 -54 -236 -112 -516
                                        -308 -1499 -411 -1921 -527 -2165 -37 -78 -53 -97 -182 -224 -78 -76 -198
                                        -184 -266 -240 -68 -55 -129 -105 -135 -111 -64 -57 -96 -151 -76 -225 28
                                        -104 160 -180 356 -205 l51 -6 57 -114 c66 -134 143 -225 221 -261 62 -30 108
                                        -30 182 -2 79 29 208 158 280 281 29 49 54 94 56 100 2 7 43 -26 91 -71 141
                                        -135 209 -151 289 -68 23 24 84 113 136 199 l94 157 -5 62 c-9 105 -53 182
                                        -248 428 -152 192 -156 199 -141 263 15 65 126 343 306 767 377 885 532 1284
                                        570 1465 19 95 19 210 0 266 -32 88 -109 135 -210 127 -84 -7 -104 -27 -132
                                        -133 -13 -50 -77 -259 -143 -465 -134 -424 -172 -548 -194 -637 -18 -67 -55
                                        -157 -136 -328 -278 -586 -359 -925 -280 -1177 28 -89 63 -143 160 -248 109
                                        -118 125 -141 166 -225 27 -56 34 -81 34 -131 0 -53 -4 -68 -32 -109 -18 -26
                                        -47 -56 -64 -66 l-30 -19 -71 108 c-88 132 -130 181 -190 221 -48 32 -98 40
                                        -133 21 -31 -16 -67 -88 -94 -187 -41 -146 -75 -228 -113 -272 -80 -94 -146
                                        -26 -162 166 -7 83 -11 98 -34 121 -29 29 -35 29 -262 21 -102 -4 -113 -2
                                        -153 21 -103 58 -47 141 165 245 83 41 272 118 347 142 16 5 33 16 38 24 18
                                        33 383 1194 543 1731 240 801 317 1109 319 1275 1 78 -2 96 -20 120 -28 38
                                        -82 41 -144 9z"/>
                                        <path d="M7292 6609 c-38 -11 -37 -13 10 -146 51 -142 136 -250 212 -272 99
                                        -27 246 74 246 169 0 75 -67 149 -195 217 -63 33 -79 37 -155 40 -47 1 -100
                                        -2 -118 -8z"/>
                                        <path d="M7732 5215 c-66 -29 -144 -108 -226 -229 -30 -45 -34 -96 -8 -119 46
                                        -42 224 -87 344 -87 l36 0 4 68 c4 87 -6 225 -21 279 -13 47 -45 89 -76 97
                                        -11 3 -35 -1 -53 -9z"/>
                                        <path d="M7050 4444 c-77 -36 -131 -83 -165 -145 -28 -53 -28 -54 -17 -141 7
                                        -56 19 -104 34 -131 20 -36 28 -42 60 -45 44 -4 79 13 175 85 92 70 123 126
                                        123 223 0 48 -6 78 -22 110 -38 75 -94 88 -188 44z"/>
                                        <path d="M6990 3808 c-40 -22 -57 -83 -43 -164 19 -107 74 -148 198 -147 69 0
                                        124 20 160 59 62 67 0 157 -158 229 -68 31 -125 39 -157 23z"/>
                                        <path d="M7336 3189 c-16 -12 -35 -38 -43 -57 -14 -33 -13 -37 20 -106 64
                                        -133 131 -197 190 -182 67 16 85 164 33 269 -33 68 -60 88 -124 95 -38 3 -53
                                        0 -76 -19z"/>
                                        </g>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Settings Dropdown -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                                        Log in
                                    </a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                            Register
                                        </a>
                                    @endif
                                @endauth
                            @endif
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-400 dark:border-indigo-600 text-start text-base font-medium text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/50 focus:outline-none focus:text-indigo-800 dark:focus:text-indigo-200 focus:bg-indigo-100 dark:focus:bg-indigo-900 focus:border-indigo-700 dark:focus:border-indigo-300 transition duration-150 ease-in-out">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
                    <div>
                        <a href="/">
                            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                        </a>
                    </div>

                    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
