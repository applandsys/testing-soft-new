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

                              <div id="result_show" class="mt-4 mx-4" style="display:none;">
                                   <div class="card mx-4 bg-white">
                                        <div class="card-body p-4 bg-white">
                                      <iframe
                                            id="reportFrame"
                                            src="{{ route('test.report', ['group' => 1]) }}"
                                            style="width:100%; height:80vh; border:none; border-radius:10px;"
                                            loading="lazy">
                                        </iframe>
                                      </div>
                                  </div>
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

            const rows = document.querySelectorAll('.test-row');
            const buttons = document.querySelectorAll('.run-test');

            const runningSound = new Audio("{{ asset('sound/beep.mp3') }}");
            runningSound.loop = true;

            const successSound = new Audio("{{ asset('sound/okay.mp3') }}");

            buttons.forEach((btn, index) => {

                btn.addEventListener('click', function () {

                    const row = rows[index];
                    const bar = row.querySelector('.progress-bar');

                    btn.disabled = true;
                    bar.classList.add('progress-bar-animated');

                    let progress = 0;
                    const stopAt = index === 3 ? 50 : 100;

                    runningSound.currentTime = 0;
                    runningSound.play();

                    const timer = setInterval(() => {

                        progress++;

                        // 🔒 HARD STOP (prevents overflow)
                        if (progress > stopAt) return;

                        bar.style.width = progress + '%';
                        bar.setAttribute('aria-valuenow', progress);
                        bar.innerText = progress + '%';

                        // ✅ FIRST 3 → COMPLETE
                        if (index < 3 && progress === 100) {
                            clearInterval(timer);

                            runningSound.pause();
                            runningSound.currentTime = 0;
                            successSound.play();

                            bar.classList.remove('progress-bar-animated');
                            bar.innerText = 'Completed';

                            // Show next row
                            if (rows[index + 1]) {
                                rows[index + 1].style.display = '';
                            }
                        }

                        // ❌ 4TH → FAIL AT 50%
                        if (index === 3 && progress === 50) {
                            clearInterval(timer);

                            runningSound.pause();
                            runningSound.currentTime = 0;

                            bar.classList.remove('bg-success');
                            bar.classList.add('bg-danger');
                            bar.classList.remove('progress-bar-animated');

                            bar.innerText = '50% Failed';

                            // 🔒 Disable everything permanently
                            buttons.forEach(b => b.disabled = true);
                        }

                    }, 80);
                });
            });
        });
    </script>
@endsection
