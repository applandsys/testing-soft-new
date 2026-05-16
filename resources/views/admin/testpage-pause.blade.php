@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xxxl-12 col-xl-12 col-12 leftside-section">

                <div class="box-body px-0">
                    <h5 class="fw-500 text-primary-light m-0">Test Items</h5>
                </div>

                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-12">

                                <table class="table table-striped align-middle" id="testing-table">
                                    @foreach($test_items as $index => $item)
                                        <tr class="test-row" style="{{ $index === 0 ? '' : 'display:none' }}">
                                            <th width="auto">{{ $item->name }}</th>

                                            <td width="auto" style="width: 55%">
                                                <div class="progress" style="height:22px;">
                                                    <div class="progress-bar bg-success progress-bar-striped"
                                                         role="progressbar"
                                                         style="width:0%"
                                                         aria-valuenow="0"
                                                         aria-valuemin="0"
                                                         aria-valuemax="100">

                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-end d-flex justify-content-end">
                                                <button class="btn btn-primary run-test flex-btn" data-index="{{ $index }}">
                                                    {{ $item->name }} Check
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>

                                {{--                                <div id="result_show" class="text-center mt-4" style="display:none;">--}}
                                {{--                                    <a href="{{ asset('result_file/positive.pdf') }}"--}}
                                {{--                                       class="btn btn-success"--}}
                                {{--                                       target="_blank">--}}
                                {{--                                        RESULT PRINT PDF--}}
                                {{--                                    </a>--}}
                                {{--                                </div>--}}

                                {{--                                <div id="result_show" class="text-center mt-4" style="display:none;">--}}
                                {{--                                    <a href="{{ route('test.report', request()->route('group')) }}"--}}
                                {{--                                       class="btn btn-success"--}}
                                {{--                                       target="_blank">--}}
                                {{--                                        DOWNLOAD RESULT PDF--}}
                                {{--                                    </a>--}}
                                {{--                                </div>--}}
                                <div id="result_loader" class="text-center mt-4" style="display:none;">
                                    <h5 class="mb-3 text-primary">Generating Report...</h5>

                                    <div class="progress" style="height:25px;">
                                        <div id="finalProgress"
                                             class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                                             style="width:0%">
                                            0%
                                        </div>
                                    </div>
                                </div>

                                <div id="result_show" class="mt-4" style="display:none;">
                                    <iframe
                                        id="pdfFrame"
                                        width="100%"
                                        height="600"
                                        style="border:1px solid #ccc;">
                                    </iframe>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const duration =  Math.floor(Math.random() * (50000 - 10000 + 1)) + 10000;

            // Sounds
            const runningSound = new Audio("{{ asset('sound/beep.mp3') }}");
            runningSound.loop = true;

            const successSound = new Audio("{{ asset('sound/okay.mp3') }}");

            const rows = document.querySelectorAll('.test-row');

            document.querySelectorAll('.run-test').forEach((btn, index) => {

                btn.addEventListener('click', function () {

                    const row = rows[index];
                    const bar = row.querySelector('.progress-bar');

                    btn.disabled = true;
                    bar.classList.add('progress-bar-animated');

                    let progress = 0;

                    // ▶️ Start sound
                    runningSound.currentTime = 0;
                    runningSound.play();

                    const isZirconium = index === 17; // 18th item (0-based index)

                    const timer = setInterval(() => {

                        // 🚫 Special case: Zirconium pause at 50%
                        if (isZirconium && progress >= 50) {
                            clearInterval(timer);

                            // Stop sound
                            runningSound.pause();
                            runningSound.currentTime = 0;

                            // Make bar red & static
                            bar.classList.remove('bg-success');
                            bar.classList.add('bg-danger');
                            bar.classList.remove('progress-bar-animated');

                            bar.style.width = '50%';
                            bar.innerText = 'Paused at 50%';

                            btn.disabled = true;
                            return; // ⛔ stop everything
                        }

                        progress++;
                        bar.style.width = progress + '%';
                        bar.innerText = '';
                        bar.setAttribute('aria-valuenow', progress);

                        if (progress >= 100) {
                            clearInterval(timer);

                            runningSound.pause();
                            runningSound.currentTime = 0;
                            successSound.play();

                            if (rows[index + 1]) {
                                rows[index + 1].style.display = '';
                            } else {
                                // FINAL REPORT LOGIC (unchanged)
                                document.getElementById('result_loader').style.display = 'block';

                                let finalProgress = document.getElementById('finalProgress');
                                let timeLeft = 120;

                                let interval = setInterval(() => {
                                    let percent = Math.floor(((120 - timeLeft) / 120) * 100);

                                    finalProgress.style.width = percent + '%';
                                    finalProgress.innerText = percent + '%';

                                    timeLeft--;

                                    if (timeLeft <= 0) {
                                        clearInterval(interval);

                                        finalProgress.style.width = '100%';
                                        finalProgress.innerText = '100%';

                                        document.getElementById('result_loader').style.display = 'none';

                                        const iframe = document.getElementById('pdfFrame');
                                        iframe.src = "{{ route('test.report', request()->route('group')) }}";
                                        document.getElementById('result_show').style.display = 'block';
                                    }
                                }, 1000);
                            }
                        }
                    }, duration / 100);
                });

            });

        });
    </script>

@endsection
