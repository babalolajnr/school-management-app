<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1024">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Performance Report | {{ "$student->first_name $student->last_name" }}</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('TAssets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/radiant_logo-removebg-preview.png') }}" type="image/x-icon">
</head>

<body class="flex justify-center poppins">
    <div class="w-[29.7cm] shadow-xl flex flex-col space-y-6 pb-3">
        <div class="pt-3 bg-yellow-200">
            <div class="flex justify-center space-x-10 px-2">
                <div class="h-40 w-40 bg-cover rounded-full shrink-0"
                    style="background-image: url('{{ asset('images/radiant_logo.jpeg') }}')"></div>
                <div class="text-center">
                    <h1 class="text-4xl font-bold">RADIANT MINDS SCHOOL</h1>
                    <h1 class="text-2xl font-bold">الضياء تربية ناجحة لإدراك السعادتين</h1>
                    <h3 class="font-semibold text-2xl">Creche, Nursery & Primary</h3>
                    <div class="font-semibold">
                        Block 20 Road 1, Ajebo Road Housing Estate, Kemta, Idi-Aba, Abeokuta
                    </div>
                    <div class="font-semibold flex justify-between">
                        <span>
                            <i class="fas fa-phone"></i>
                            08172951965
                        </span>
                        <span>
                            <i class="fab fa-whatsapp"></i>
                            08147971373
                        </span>
                        <span>
                            <i class="fas fa-envelope"></i>
                            radiantmindsschool@gmail.com
                        </span>
                    </div>
                </div>
                @if ($student->image)
                    <div class="h-40 w-40 rounded-full shrink-0"
                        style="background-image: url('{{ asset($student->image) }}')"></div>
                @else
                    <img class="h-40 w-40 rounded-full border-2 border-black shrink-0"
                        src='{{ asset('images/user1.svg') }}'>
                @endif
            </div>
            <div class="text-center text-xl font-bold uppercase">
                {{ $period->term->name }} STUDENT'S PERFORMANCE REPORT
            </div>
        </div>
        <div class="px-5 flex flex-wrap">
            <div class="w-full flex space-x-1">
                <label for="" class="font-bold">Name</label>
                <input type="text"
                    value="{{ Str::upper($student->last_name) }} {{ Str::ucfirst($student->first_name) }}" disabled
                    class="grow bg-transparent border-b text-center border-black">
            </div>
            <div class="flex w-full mt-2 space-x-3">
                <div class="flex grow space-x-1">
                    <label for="" class="font-bold">Class</label>
                    <input type="text" disabled value="{{ $classroom }}"
                        class="bg-transparent border-b border-black grow text-center">
                </div>
                <div class="flex grow space-x-1">
                    <label for="" class="font-bold">Session</label>
                    <input type="text" value="{{ $period->academicSession->name }}" disabled
                        class="bg-transparent border-b border-black grow text-center">
                </div>
                <div class="flex grow space-x-1">
                    <label for="" class="font-bold">Admission</label>
                    <input type="text" value="{{ $student->admission_no }}" disabled
                        class="bg-transparent border-b border-black grow text-center">
                </div>
            </div>
            <div class="flex mt-1 justify-between w-full space-x-3">
                <div class="flex grow space-x-1">
                    <label for="" class="font-bold">DOB</label>
                    <input type="text" value="{{ $student->date_of_birth }}" disabled
                        class="bg-transparent border-b border-black grow text-center">
                </div>
                <div class="flex grow space-x-1">
                    <label for="" class="font-bold">Age</label>
                    <input type="text" value="{{ $age }}" disabled
                        class="bg-transparent border-b border-black grow text-center">
                </div>
                <div class="flex grow space-x-1">
                    <label for="" class="font-bold">Gender</label>
                    <input type="text" value="{{ $student->sex }}" disabled
                        class="bg-transparent border-b border-black text-center grow">
                </div>
            </div>
        </div>
        <div class="flex px-5">
            <div class="">
                <table class="table-auto border border-black h-full">
                    <thead class="">
                        <th class="border border-black bg-[#052F57] text-yellow-400">Subjects</th>
                        <th class="border border-black">C.A(40)</th>
                        <th class="border border-black">Exam(60)</th>
                        <th class="border border-black">Total(100)</th>
                        <th class="border border-black">Highest Score</th>
                        <th class="border border-black">Lowest Score</th>
                        <th class="border border-black">Class Average</th>
                        <th class="border border-black">Grade</th>
                    </thead>
                    @foreach ($results as $key => $result)
                        <tr class="text-center">
                            <td class="border border-black font-semibold px-3">{{ $key }}</td>
                            @if ($result == null)
                                <td class="border border-black"></td>
                                <td class="border border-black"></td>
                                <td class="border border-black"></td>
                                <td class="border border-black"></td>
                                <td class="border border-black"></td>
                                <td class="border border-black"></td>
                                <td class="border border-black"></td>
                            @else
                                <td class="border border-black">{{ $result->ca }}</td>
                                <td class="border border-black">{{ $result->exam }}</td>
                                <td class="border border-black">{{ $result->total }}</td>
                                <td class="border border-black">{{ $maxScores[$result->subject->name] }}</td>
                                <td class="border border-black">{{ $minScores[$result->subject->name] }}</td>
                                <td class="border border-black">
                                    {{ round($averageScores[$result->subject->name], 2) }}</td>
                                <td class="border border-black">
                                    @if (round($result->total) <= 39)
                                        F
                                    @endif
                                    @if (round($result->total) > 39 && round($result->total) <= 49)
                                        D
                                    @endif
                                    @if (round($result->total) > 49 && round($result->total) <= 59)
                                        C
                                    @endif
                                    @if (round($result->total) > 59 && round($result->total) <= 69)
                                        B
                                    @endif
                                    @if (round($result->total) > 69 && round($result->total) <= 100)
                                        A
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="flex flex-col space-y-4 grow ml-3">
                <table class="w-full">
                    <thead>
                        <th class="border border-black bg-[#052F57] text-yellow-400" colspan="2">Performance Summary
                        </th>
                    </thead>
                    <tr class="text-center">
                        <td class="border border-black font-semibold">Total Obtained</td>
                        <td class="border border-black">{{ $totalObtained }}</td>
                    </tr>
                    <tr class="text-center">
                        <td class="border border-black font-semibold">Total Obtainable</td>
                        <td class="border border-black">{{ $totalObtainable }}</td>
                    </tr>
                    <tr class="text-center">
                        <td class="border border-black font-semibold">%tage</td>
                        <td class="border border-black">{{ round($percentage, 2) }}%</td>
                    </tr>
                    <tr class="text-center">
                        <td class="border border-black font-semibold">Grade</td>
                        <td class="border border-black">
                            @if (round($percentage) <= 39)
                                F
                            @elseif(round($percentage) > 39 && round($percentage) <= 49)
                                D
                            @elseif(round($percentage) > 49 && round($percentage) <= 59)
                                C
                            @elseif(round($percentage) > 59 && round($percentage) <= 69)
                                B
                            @elseif(round($percentage) > 69 && round($percentage) <= 100)
                                A
                            @else
                            @endif
                        </td>
                    </tr>
                </table>
                <table class="w-full">
                    <thead>
                        <th class="border border-black bg-[#052F57] text-yellow-400" colspan="3">Grade Scale</th>
                    </thead>
                    <tr class="text-center">
                        <td class="border border-black font-bold">A</td>
                        <td class="border border-black font-semibold">70-100%</td>
                        <td class="border border-black">Excellent</td>
                    </tr>
                    <tr class="text-center">
                        <td class="border border-black font-bold">B</td>
                        <td class="border border-black font-semibold">60-69%</td>
                        <td class="border border-black">Very Good</td>
                    </tr>
                    <tr class="text-center">
                        <td class="border border-black font-bold">C</td>
                        <td class="border border-black font-semibold">50-59%</td>
                        <td class="border border-black">Good</td>
                    </tr>
                    <tr class="text-center">
                        <td class="border border-black font-bold">D</td>
                        <td class="border border-black font-semibold">40-49%</td>
                        <td class="border border-black">Average</td>
                    </tr>
                    <tr class="text-center">
                        <td class="border border-black font-bold">F</td>
                        <td class="border border-black font-semibold">0-39%</td>
                        <td class="border border-black">Fail</td>
                    </tr>
                </table>
                <table class="w-full">
                    <thead>
                        <th class="border border-black bg-[#052F57] text-yellow-400" colspan="2">Attendance Summary
                        </th>
                    </thead>
                    <tr class="text-center">
                        <td class="border border-black font-semibold">No of Times School opened</td>
                        <td class="border border-black">{{ $period->no_times_school_opened }}</td>
                    </tr>
                    <tr class="text-center">
                        <td class="border border-black font-semibold">No of times present</td>
                        <td class="border border-black">
                            @if (is_null($no_of_times_present))
                                null
                            @else
                                {{ $no_of_times_present->value }}
                            @endif
                        </td>
                    </tr>
                    <tr class="text-center">
                        <td class="border border-black font-semibold">No of times Absent</td>
                        <td class="border border-black">
                            @if (is_null($no_of_times_present))
                                null
                            @else
                                {{ $period->no_times_school_opened - $no_of_times_present->value }}
                            @endif
                        </td>
                    </tr>
                </table>
                <table class="w-full">
                    <thead>
                        <th class="border border-black bg-[#052F57] text-yellow-400" colspan="2">Next Term Begins</th>
                    </thead>
                    <tr class="text-center">
                        <td class="border border-black font-semibold">{{ $nextTermBegins }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="flex px-5 space-x-4">
            <table class="table-auto border border-black grow h-full">
                <thead class="bg-[#052F57] text-yellow-400">
                    <th class=" border border-black">Psychomotor Domain</th>
                    <th class=" border border-black">5</th>
                    <th class=" border border-black">4</th>
                    <th class=" border border-black">3</th>
                    <th class=" border border-black">2</th>
                    <th class=" border border-black">1</th>
                </thead>
                <tbody>

                    @foreach ($pdTypes as $pdType)
                        <tr class="text-center">
                            <td class="border border-black font-semibold">{{ $pdType->name }}</td>
                            <td class=" border border-black">
                                @if (array_key_exists($pdType->name, $pds) && $pds[$pdType->name] == '5')
                                    <i class="fas fa-check"></i>
                                @endif
                            </td>
                            <td class=" border border-black">
                                @if (array_key_exists($pdType->name, $pds) && $pds[$pdType->name] == '4')
                                    <i class="fas fa-check"></i>
                                @endif
                            </td>
                            <td class=" border border-black">
                                @if (array_key_exists($pdType->name, $pds) && $pds[$pdType->name] == '3')
                                    <i class="fas fa-check"></i>
                                @endif
                            </td>
                            <td class=" border border-black">
                                @if (array_key_exists($pdType->name, $pds) && $pds[$pdType->name] == '2')
                                    <i class="fas fa-check"></i>
                                @endif
                            </td>
                            <td class=" border border-black">
                                @if (array_key_exists($pdType->name, $pds) && $pds[$pdType->name] == '1')
                                    <i class="fas fa-check"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
            <table class="table-auto border border-black grow">
                <thead class="bg-[#052F57] text-yellow-400">
                    <th class=" border border-black">Affective Domain</th>
                    <th class=" border border-black">5</th>
                    <th class=" border border-black">4</th>
                    <th class=" border border-black">3</th>
                    <th class=" border border-black">2</th>
                    <th class=" border border-black">1</th>
                </thead>
                <tbody>
                    @foreach ($adTypes as $adType)
                        <tr class="text-center">
                            <td class="border border-black font-semibold">{{ $adType->name }}</td>
                            <td class=" border border-black">
                                @if (array_key_exists($adType->name, $ads) && $ads[$adType->name] == '5')
                                    <i class="fas fa-check"></i>
                                @endif
                            </td>
                            <td class=" border border-black">
                                @if (array_key_exists($adType->name, $ads) && $ads[$adType->name] == '4')
                                    <i class="fas fa-check"></i>
                                @endif
                            </td>
                            <td class=" border border-black">
                                @if (array_key_exists($adType->name, $ads) && $ads[$adType->name] == '3')
                                    <i class="fas fa-check"></i>
                                @endif
                            </td>
                            <td class=" border border-black">
                                @if (array_key_exists($adType->name, $ads) && $ads[$adType->name] == '2')
                                    <i class="fas fa-check"></i>
                                @endif
                            </td>
                            <td class=" border border-black">
                                @if (array_key_exists($adType->name, $ads) && $ads[$adType->name] == '1')
                                    <i class="fas fa-check"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex flex-col px-5 space-y-4">
            <div class="border border-black flex space-x-3 px-4 h-20">
                <div class="flex space-x-2 items-center basis-10/12">
                    <span class="font-bold min-w-fit">Class Teacher's Remark</span>
                    <span class="text-sm">
                        @if ($teacherRemark)
                            {{ $teacherRemark->remark }}
                        @endif
                    </span>
                </div>
                <div class="flex space-x-2 items-center">
                    <span class="font-bold min-w-fit">Sign</span>
                    @if ($teacherRemark)
                        <span class="">
                            <img src="{{ asset($teacherRemark->teacher?->signature) }}" class="w-20 h-10"
                                alt="teacher's signature">
                        </span>
                    @endif
                </div>
            </div>
            <div class="border border-black flex space-x-3 px-4 h-20">
                <div class="flex space-x-2 items-center basis-10/12">
                    <span class="font-bold min-w-fit">HOS's Remark</span>
                    <span class="text-sm">
                        @if (round($percentage) <= 39)
                            This is not a result to be proud of. I expect we can work on this to improve
                            significantly next term.
                        @endif
                        @if (round($percentage) > 39 && round($percentage) <= 44)
                            You aren't failing, you are trying and that is the most important step towards success.
                        @endif
                        @if (round($percentage) > 44 && round($percentage) <= 49)
                            Average performance. You have the capacity to be better. Go for it!
                        @endif
                        @if (round($percentage) > 49 && round($percentage) <= 59)
                            Well done. Put in more effort and it will be better.
                        @endif
                        @if (round($percentage) > 59 && round($percentage) <= 69)
                            Great! Reach for higher.
                        @endif
                        @if (round($percentage) > 69 && round($percentage) <= 79)
                            This is a result to be proud of. Do not rest on your oars.
                        @endif
                        @if (round($percentage) > 79 && round($percentage) <= 89)
                            What an excellent performance. Maa Sha Allah.
                        @endif
                        @if (round($percentage) > 89)
                            Awesome performance. You are a star.
                        @endif
                    </span>
                </div>
                <div class="flex space-x-2 items-center">
                    <span class="font-bold min-w-fit">Sign</span>
                    <span>
                        @if (App\Models\User::getHOS())
                            <img src="{{ asset(App\Models\User::getHOS()->signature) }}" class="w-20 h-10"
                                alt="Hos's signature">
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
