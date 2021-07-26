<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1024">
    <title>Performance Report</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/radiant_logo-removebg-preview.png') }}" type="image/x-icon">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('TAssets/plugins/fontawesome-free/css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>
    <div class="p-3">
        <!--Logo and details of the company-->
        <div class="head d-flex justify-content-center p-3 pb-0">
            <div class="image">
                <img class="img" src="{{ asset('images/radiant_logo.jpeg') }}" alt="Radiant minds logo">
            </div>
            <div class="content text-center">
                <h1 class="fam">
                    <strong>RADIANT MINDS SCHOOL</strong>
                </h1>
                <img class="arabic" src="{{ asset('images/arabic-removebg-preview.png') }}" alt="Arabic text">
                <p class="h4 space"><strong>Creche, Nursery & Primary</strong></p>
                <p>
                    <strong>
                        <i class="fa fa-map-marker text-danger "></i>Block 20 Road 1, Ajebo Road Housing Estate, Kemta,
                        Idi-Aba, Abeokuta
                        <br>
                        <i class="fa fa-phone text-danger"></i>08172951965 &nbsp;&nbsp; <img class="icon"
                            src="{{ asset('images/whatsapp.png') }}" alt="">08147971373 &nbsp;&nbsp;
                        <img class="icon" src="{{ asset('images/gmail.png') }}" alt=""> radiantmindsschool@gmail.com
                    </strong>
                </p>
                <p class="h5"><strong class="text-uppercase"><u>{{ $period->term->name }} STUDENT'S PERFORMANCE
                            REPORT</u></strong></p>
            </div>
            <div class="passport">
            <img src="@if ($student->image) {{ asset($student->image) }} @else
                {{ asset('images/user1.svg') }} @endif" height="170" width="140" alt="Passport
                Photograph">
            </div>
        </div>

        <!--Student details-->
        <div class="sub-container">
            <div class="some">
                <div class="one">
                    <form action="" class="p-3">
                        <div class="stu-name mb-2">
                            <label for="name" class="fw-bold">NAME:</label>
                            <div class="name name-font border-bottom px-2 border-2 border-dark"><span
                                    class="px-3 fs-6"><span
                                        class="fw-bold">{{ Str::upper($student->last_name) }}</span>,
                                    {{ Str::ucfirst($student->first_name) }}</span>
                            </div>
                        </div>
                        <div class="sec mb-2 d-flex">
                            <div class="stu-class">
                                <label class="fw-bold" for="class">CLASS:</label>
                                <div class="class border-bottom px-2 border-2 border-dark"><span
                                        class="px-3 fs-6">{{ $classroom }}</span>
                                </div>
                            </div>
                            <div class="stu-sess">
                                <label class="fw-bold" for="session">SESSION:</label>
                                <div class="session border-bottom px-2 border-2 border-dark"><span
                                        class="px-3 fs-6">{{ $period->academicSession->name }}</span></div>
                            </div>
                            <div class="stu-add">
                                <label class="fw-bold" for="admission">ADMISSION:</label>
                                <div class="admission border-bottom px-2 border-2 border-dark"><span
                                        class="px-3 fs-6">{{ $student->admission_no }}</span></div>
                            </div>
                        </div>
                        <div class="thrd d-flex">
                            <div class="stu-dob">
                                <label class="fw-bold" for="dob">DOB:</label>
                                <div class="dob border-bottom px-2 border-2 border-dark"><span
                                        class="px-3 fs-6">{{ $student->date_of_birth }}</span></div>
                            </div>
                            <div class="stu-age">
                                <label class="fw-bold" for="age">AGE:</label>
                                <div class="age border-bottom px-2 border-2 border-dark"><span
                                        class="px-3 fs-6">{{ $age }}</span></div>
                            </div>
                            <div class="stu-gender">
                                <label class="fw-bold" for="gender">GENDER:</label>
                                <div class="gender border-bottom px-2 border-2 border-dark"><span
                                        class="px-3 fs-6">{{ $student->sex }}</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="two row">
            <div class="sub1 col-sm-8">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th class="heading stats" scope="col">SUBJECTS</th>
                            <th scope="col" class="stats"><span>C.A.(40)</span></th>
                            <th scope="col" class="stats"><span>Exam(60)</span></th>
                            <th scope="col" class="stats"><span>Total(100)</span></th>
                            <th scope="col" class="stats"><span>Highest<br>score</span></th>
                            <th scope="col" class="stats"><span>Lowest<br>score</span></th>
                            <th scope="col" class="stats"><span>Class<br>Average</span></th>
                            <th scope="col" class="stats"><span>Grade</span></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($results as $key => $result)
                            <tr>
                                <th scope="row">{{ $key }}</td>
                                    @if ($result == null)
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            @else
                                <td class="text-center">{{ $result->ca }}</td>
                                <td class="text-center">{{ $result->exam }}</td>
                                <td class="text-center">{{ $result->total }}</td>
                                <td class="text-center">{{ $maxScores[$result->subject->name] }}
                                <td class="text-center">{{ $minScores[$result->subject->name] }}
                                </td>
                                <td class="text-center">{{ round($averageScores[$result->subject->name], 2) }}
                                </td>
                                @if ($result->total <= 39)
                                    <td class="text-red-700 text-center">F</td>
                                @elseif($result->total >= 40 && $result->total <= 49) <td
                                        class="text-yellow-500 text-center">D
                                        </td>
                                    @elseif($result->total >= 50 && $result->total <= 59) <td
                                            class="text-green-300 text-center">C
                                            </td>
                                        @elseif($result->total >= 60 && $result->total <= 69) <td
                                                class="text-green-600 text-center">B</td>
                                            @elseif($result->total >= 70 && $result->total <= 100) <td
                                                    class="text-green-900 text-center">A</td>
                                                @else
                                                    <td></td>
                                @endif
                        @endif

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
            <div class="sub2 col-sm-4">
                <table class="table caption-top table-sm">
                    <thead>
                        <tr>
                            <td class="text-center heading" colspan="3">PERFORMANCE SUMMARY</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2" class="fw-bold">Total Obtained:</td>
                            <td>{{ $totalObtained }}</td>

                        </tr>
                        <tr>
                            <td colspan="2" class="fw-bold">Total Obtainable:</td>
                            <td>{{ $totalObtainable }}</td>

                        </tr>

                        <tr>
                            <td class="fw-bold">%TAGE</td>
                            <td colspan="2">{{ round($percentage, 2) }}</td>

                        </tr>
                        <tr>
                            <td class="fw-bold">GRADE</td>
                            @if (round($percentage) <= 39)
                                <td colspan='2' class="text-red-700">F</td>
                            @elseif(round($percentage) > 39 && round($percentage) <= 49) <td colspan='2' class="text-yellow-500">
                                    D</td>
                                @elseif(round($percentage) > 49 && round($percentage) <= 59) <td colspan='2'
                                        class="text-green-300">C
                                        </td>
                                    @elseif(round($percentage) > 59 && round($percentage) <= 69) <td colspan='2'
                                            class="text-green-600">B
                                            </td>
                                        @elseif(round($percentage) > 69 && round($percentage) <= 100) <td colspan='2'
                                                class="text-green-900">
                                                A</td>
                                            @else
                                                <td colspan='2'></td>
                            @endif
                        </tr>
                    </tbody>
                </table>


                <table class="table caption-top table-sm">
                    <thead>
                        <tr>
                            <td class="text-center heading" colspan="3">GRADE SCALE</td>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td class="fw-bold">A</td>
                            <td class="fw-bold">70-100%</td>
                            <td>EXCELLENT</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">B</td>
                            <td class="fw-bold">60-69%</td>
                            <td>VERY GOOD</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">C</td>
                            <td class="fw-bold">50-59%</td>
                            <td>GOOD</td>

                        </tr>
                        <tr>
                            <td class="fw-bold">D</td>
                            <td class="fw-bold">40-49%</td>
                            <td>AVERAGE</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">F</td>
                            <td class="fw-bold">0-39%</td>
                            <td>FAIL</td>
                        </tr>
                    </tbody>
                </table>


                <table class="table caption-top table-sm">

                    <tbody>
                        <tr>
                            <td class="text-center heading" colspan="2">ATTENDANCE SUMMARY</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">No of Times School opened</td>
                            <td>{{ $period->no_times_school_opened }}</td>

                        </tr>
                        <tr>
                            <td class="fw-bold">No of times present</td>
                            <td>
                                @if (is_null($no_of_times_present))
                                    null
                                @else
                                    {{ $no_of_times_present->value }}
                                @endif
                            </td>

                        </tr>
                        <tr>
                            <td class="fw-bold"> No of times Absent</td>
                            <td>
                                @if (is_null($no_of_times_present))
                                    null
                                @else
                                    {{ $period->no_times_school_opened - $no_of_times_present->value }}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>


                <table class="table caption-top table-sm">
                    <thead>
                        <tr>
                            <td class="text-center heading" colspan="1">NEXT TERM BEGINS</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center fw-bold">{{ $nextTermBegins }}</td>
                        </tr>

                    </tbody>
                </table>

            </div>
        </div>


        <div class="three mt-2 row">
            <div class="sub3 col-lg-6">
                <table class="table table-sm">
                    <thead>
                        <tr class="heading">
                            <th scope="col">PSYCHOMOTOR DOMAIN </th>
                            <th scope="col">5</th>
                            <th scope="col">4</th>
                            <th scope="col">3</th>
                            <th scope="col">2</th>
                            <th scope="col">1</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pdTypes as $pdType)
                            <tr>
                                <td class="fw-bold">{{ $pdType->name }}</td>
                                <td>
                                    @if (array_key_exists($pdType->name, $pds) && $pds[$pdType->name] == '5')
                                        <i class="fas fa-check"></i>
                                    @endif
                                </td>
                                <td>
                                    @if (array_key_exists($pdType->name, $pds) && $pds[$pdType->name] == '4')
                                        <i class="fas fa-check"></i>
                                    @endif
                                </td>
                                <td>
                                    @if (array_key_exists($pdType->name, $pds) && $pds[$pdType->name] == '3')
                                        <i class="fas fa-check"></i>
                                    @endif
                                </td>
                                <td>
                                    @if (array_key_exists($pdType->name, $pds) && $pds[$pdType->name] == '2')
                                        <i class="fas fa-check"></i>
                                    @endif
                                </td>
                                <td>
                                    @if (array_key_exists($pdType->name, $pds) && $pds[$pdType->name] == '1')
                                        <i class="fas fa-check"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="sub4 col-lg-6">
                <table class="table table-sm">
                    <thead>
                        <tr class="heading">
                            <th scope="col">AFFECTIVE DOMAIN </th>
                            <th scope="col">5</th>
                            <th scope="col">4</th>
                            <th scope="col">3</th>
                            <th scope="col">2</th>
                            <th scope="col">1</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adTypes as $adType)
                            <tr>
                                <td class="fw-bold">{{ $adType->name }}</td>
                                <td>
                                    @if (array_key_exists($adType->name, $ads) && $ads[$adType->name] == '5')
                                        <i class="fas fa-check"></i>
                                    @endif
                                </td>
                                <td>
                                    @if (array_key_exists($adType->name, $ads) && $ads[$adType->name] == '4')
                                        <i class="fas fa-check"></i>
                                    @endif
                                </td>
                                <td>
                                    @if (array_key_exists($adType->name, $ads) && $ads[$adType->name] == '3')
                                        <i class="fas fa-check"></i>
                                    @endif
                                </td>
                                <td>
                                    @if (array_key_exists($adType->name, $ads) && $ads[$adType->name] == '2')
                                        <i class="fas fa-check"></i>
                                    @endif
                                </td>
                                <td>
                                    @if (array_key_exists($adType->name, $ads) && $ads[$adType->name] == '1')
                                        <i class="fas fa-check"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="remark-container">
            <div class="border border-2 border-dark pb-0 p-3 remark mb-4">
                <div class="t-wrapper">
                    <div class="class-teacher-remark">
                        <label for="class-teachers-remark" class="fw-bold">Class Teacher's Remark</label>
                        <div class="remark-ct fst-italic ps-2">
                            @if ($teacherRemark)
                                {{ $teacherRemark->remark }}
                            @endif
                        </div>
                    </div>
                    <div class="class-teacher-sign">
                        <label for="class-teachers-sign" class="fw-bold">Sign</label>
                        <div class="sign">
                            @if ($teacherRemark)
                                <span class="ps-4">
                                    <img src="{{ asset($teacherRemark->teacher->signature) }}" height=20 width=60
                                        alt="teacher's signature">
                                </span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            <div class="remark2 mb-4">
                <div class="hod-wrapper border-dark pb-0 border border-2 p-3">
                    <div class="class-teacher-remark">
                        <label for="class-teachers-remark" class="fw-bold">HOS's Remark</label>
                        <div class="remark-hd fst-italic ps-2">
                            @if (round($percentage) <= 39)
                                Sadly, this result cannot allow you progress to the next grade level. I'm positive that
                                you will achieve greater performance if you settle through the class again in sha Allah.
                            @elseif(round($percentage) > 39 && round($percentage) <= 44) You have tried but this performance is
                                    not so encouraging. Let us concentrate on achieving a greater performance next year
                                in sha Allah. @elseif(round($percentage)> 44 && round($percentage) <= 49) Good. However, you are
                                        capable of achieving higher grades with more effort and support. Looking forward
                                    to a better result next year. @elseif(round($percentage)> 49 && round($percentage) <= 59) You
                                            have done very well this session but this performance will be better with
                                            greater effort. I look forward to better results next year.
                                        @elseif(round($percentage)> 59 && round($percentage) <= 69) You have worked very hard this
                                                year and I'm proud of your accomplishment. Let's have an even better
                                            result next year. You can do it. @elseif(round($percentage)> 69 && round($percentage)
                                                <= 79) This is an examplary result and I'm proud of you! Keep the
                                                Radiant Minds flag flying @elseif(round($percentage)> 79 && round($percentage) <=
                                                        89) Wow! What an awesome performance! Continue to break barriers
                                                    and soar high. @else Incredible! Your consistent effort and good
                                                        study habits have paid off. Bravo! See you at the top again next
                                                        year. @endif
                        </div>
                    </div>
                    <div class="class-teacher-sign ">
                        <label for="class-teachers-sign" class="fw-bold">Sign</label>
                        <div class="sign">
                            <span class="ps-4">
                                <img src="{{ asset(App\Models\User::getHOS()->signature) }}" height=20 width=60
                                    alt="Hos's signature">
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <footer class="heading p-3"></footer>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
