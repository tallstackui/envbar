@props([
    'color' => null,
    'blue' => null,
    'purple' => null,
    'green' => null,
    'red' => null,
    'yellow' => null,
    'amber' => null,
    'orange' => null,
    'indigo' => null,
    'gray' => null
])

@php
    $color = $color ?? 'blue';
    if ($blue) $color = 'blue';
    if ($purple) $color = 'purple';
    if ($green) $color = 'green';
    if ($red) $color = 'red';
    if ($yellow) $color = 'yellow';
    if ($amber) $color = 'amber';
    if ($orange) $color = 'orange';
    if ($indigo) $color = 'indigo';
    if ($gray) $color = 'gray';
@endphp

<svg xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet" {{ $attributes->class([
    'eb-text-blue-700' => $color === 'blue',
    'eb-text-purple-700' => $color === 'purple',
    'eb-text-green-700' => $color === 'green',
    'eb-text-red-700' => $color === 'red',
    'eb-text-yellow-700' => $color === 'yellow',
    'eb-text-amber-700' => $color === 'amber',
    'eb-text-orange-700' => $color === 'orange',
    'eb-text-indigo-700' => $color === 'indigo',
    'eb-text-gray-700' => $color === 'gray',
]) }}>
    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
        <path d="M1115 4604 c-11 -2 -45 -9 -75 -15 -30 -6 -97 -31 -149 -56 -79 -38 -109 -59 -177 -127 -68 -69 -89 -98 -127 -177 -59 -123 -72 -181 -71 -314 2 -166 50 -297 160 -431 67 -81 197 -168 307 -203 l37 -13 0 -707 0 -707 -72 -28 c-194 -76 -339 -230 -405 -431 -21 -65 -26 -100 -27 -190 -1 -133 12 -191 71 -314 38 -79 59 -108 127 -177 69 -68 98 -89 177 -127 123 -59 181 -72 314 -71 88 1 125 6 187 26 157 52 280 143 367 273 59 89 88 162 108 275 28 155 -13 345 -103 480 -80 119 -223 227 -356 270 l-38 12 0 58 c0 118 70 264 168 350 55 49 166 104 240 119 36 8 341 11 960 11 991 0 963 -1 1081 58 113 57 211 174 253 301 18 57 21 97 26 293 l4 226 60 22 c322 117 506 462 427 798 -6 26 -31 89 -56 141 -38 79 -59 108 -127 177 -69 68 -98 89 -177 127 -121 58 -180 72 -309 72 -187 -1 -340 -65 -476 -200 -133 -132 -198 -289 -198 -480 0 -158 43 -287 138 -412 76 -100 208 -193 329 -233 l38 -12 -3 -216 c-3 -211 -4 -218 -27 -251 -13 -18 -42 -42 -65 -52 -39 -18 -85 -19 -946 -19 -713 -1 -921 -4 -980 -14 -96 -17 -221 -66 -299 -116 l-61 -40 0 354 0 353 61 23 c184 67 328 208 399 390 144 373 -58 781 -445 899 -67 21 -226 36 -270 25z m160 -349 c157 -41 257 -169 257 -330 0 -80 -18 -138 -63 -199 -63 -89 -160 -137 -274 -138 -162 0 -290 100 -331 261 -44 176 65 356 246 405 71 19 94 19 165 1z m37 -2741 c91 -32 170 -112 204 -206 20 -55 20 -171 0 -226 -55 -152 -224 -253 -373 -223 -203 40 -327 224 -279 412 52 203 253 312 448 243z"/>
    </g>
</svg>
