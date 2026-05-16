@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xxxl-9 col-xl-12 col-12 leftside-section">
                <div class="box-body px-0">
                    <div>
                        <h5 class="fw-500 text-primary-light m-0">VITALS</h5>
                    </div>
                </div>
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xxxl-4 col-xl-4 col-lg-6">
                                <div class="row vitals">
                                    <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                                        <a class="box box-link-shadow rounded bg-light pull-up" href="javascript:void(0)">
                                            <div class="box-body py-20 ">
                                                <p class="fw-600 text-fade mb-20">Body Temp</p>
                                                <h3 class="fw-600 text-dark mb-5">36.5</h3>
                                                <p class="fw-600 text-fade m-0">&#8451</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                                        <a class="box box-link-shadow rounded bg-light pull-up" href="javascript:void(0)">
                                            <div class="box-body py-20">
                                                <p class="fw-600 text-fade mb-20">Pulse</p>
                                                <h3 class="fw-600 text-dark mb-5">85</h3>
                                                <p class="fw-600 text-fade m-0">bpm</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                                        <a class="box box-link-shadow rounded bg-success hover-white mb-sm-0 pull-up" href="javascript:void(0)">
                                            <div class="box-body py-20">
                                                <p class="fw-600 mb-20">Blood Pressure</p>
                                                <h3 class="fw-600  mb-5">80/70</h3>
                                                <p class="fw-600  m-0">mm/Hg</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                                        <a class="box box-link-shadow rounded bg-light mb-0 pull-up" href="javascript:void(0)">
                                            <div class="box-body py-20">
                                                <p class="fw-600 text-fade mb-20">Breathing Rate</p>
                                                <h3 class="fw-600 text-dark mb-5">15</h3>
                                                <p class="fw-600 text-fade m-0">breaths/m</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xxxl-8 col-xl-8 col-lg-6">
                                <div class="chart-section">
                                    <button class="waves-effect waves-light btn btn-success mb-5 rounded-0">Week</button>
                                    <button class="waves-effect waves-light btn btn-outline btn-light mb-5 rounded-0">Month</button>
                                    <div id="statistics"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="box-body px-0">
                            <div>
                                <h5 class="fw-500 text-primary-light m-0">MY REQUESTED REPORTS & TESTS</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <div class="box pull-up">
                                    <div class="box-body">
                                        <div class="d-flex align-items-center">
                                            <div class="me-15">
                                                <img src="https://medical-admin-template.multipurposethemes.com/images/svg-icon/flat-color-icons/SVG/news.svg" alt="" class="w-100">
                                            </div>
                                            <div>
                                                <h4 class="mb-0 fw-600 border-success bb-1 text-success">Full Body</h4>
                                                <p class="mt-10 mb-0">July 20, 2022</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="box pull-up">
                                    <div class="box-body">
                                        <div class="d-flex align-items-center">
                                            <div class="me-15">
                                                <img src="https://medical-admin-template.multipurposethemes.com/images/svg-icon/medical/x-ray.svg" alt="" class="w-100">
                                            </div>
                                            <div>
                                                <h4 class="mb-0 fw-600 border-success bb-1 text-success">X-Ray Scan</h4>
                                                <p class="mt-10 mb-0">April 30, 2022</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="box pull-up">
                                    <div class="box-body">
                                        <div class="d-flex align-items-center">
                                            <div class="me-15">
                                                <img src="https://medical-admin-template.multipurposethemes.com/images/svg-icon/medical/blood-test.svg" alt="" class="w-100">
                                            </div>
                                            <div>
                                                <h4 class="mb-0 fw-600 border-success bb-1 text-success">Blood Test</h4>
                                                <p class="mt-10 mb-0">Fabruary 02, 2022</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12">
                                <div class="row">
                                    <div class="col-xxxl-6 col-lg-6">
                                        <div class="box-body px-0">
                                            <div>
                                                <h5 class="fw-500 text-primary-light m-0 text-uppercase">Patient recent visits</h5>
                                            </div>
                                        </div>
                                        <div class="box box-body py-30">
                                            <div class="d-flex align-items-center bb-2 pb-20">
                                                <div class="me-15">
                                                    <img src="../images/avatar/avatar-1.png" class="avatar avatar-lg rounded-circle bg-primary-light" alt="">
                                                </div>
                                                <div class="d-flex flex-column flex-grow-1">
                                                    <p class="text-primary hover-primary mb-1 fs-16 fw-700">Dr. Jaylon Stanton</p>
                                                    <span class="text-fade">Physicion</span>
                                                </div>
                                                <div class="text-end fw-500">
                                                    <p class="text-fade mb-0">July 20, 2022</p>
                                                    <a href="doctor_list.html" class="bb-1 border-success text-success">View</a>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center bb-2 py-20">
                                                <div class="me-15">
                                                    <img src="../images/avatar/avatar-2.png" class="avatar avatar-lg rounded-circle bg-primary-light" alt="">
                                                </div>
                                                <div class="d-flex flex-column flex-grow-1">
                                                    <p class="text-primary hover-primary mb-1 fs-16 fw-700">Dr. Bruce Williams</p>
                                                    <span class="text-fade">Orthopaedist</span>
                                                </div>
                                                <div class="text-end fw-500">
                                                    <p class="text-fade mb-0">May 02, 2022</p>
                                                    <a href="doctor_list.html" class="bb-1 border-success text-success">View</a>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center bb-2 py-20">
                                                <div class="me-15">
                                                    <img src="../images/avatar/avatar-3.png" class="avatar avatar-lg rounded-circle bg-primary-light" alt="">
                                                </div>
                                                <div class="d-flex flex-column flex-grow-1">
                                                    <p class="text-primary hover-primary mb-1 fs-16 fw-700">Dr. john Wills</p>
                                                    <span class="text-fade">Orthopaedist</span>
                                                </div>
                                                <div class="text-end fw-500">
                                                    <p class="text-fade mb-0">March 02, 2022</p>
                                                    <a href="doctor_list.html" class="bb-1 border-success text-success">View</a>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center pt-20 pb-1">
                                                <div class="me-15">
                                                    <img src="../images/avatar/avatar-4.png" class="avatar avatar-lg rounded-circle bg-primary-light" alt="">
                                                </div>
                                                <div class="d-flex flex-column flex-grow-1">
                                                    <p class="text-primary hover-primary mb-1 fs-16 fw-700 ">Dr. Angela Summers</p>
                                                    <span class="text-fade">Dentist</span>
                                                </div>
                                                <div class="text-end fw-500">
                                                    <p class="text-fade mb-0">Jan 15, 2022</p>
                                                    <a href="doctor_list.html" class="bb-1 border-success text-success">View</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-lg-6">
                                        <div class="box-body px-0">
                                            <div>
                                                <h5 class="fw-500 text-primary-light m-0 text-uppercase">list of prescriptions</h5>
                                            </div>
                                        </div>
                                        <div class="box box-body py-35">
                                            <button type="button" class="waves-effect waves-light btn btn-outline b-dashed b-2 btn-success mb-35 py-15 fw-600"><i class="ti-plus"></i> Add a prescription</button>
                                            <div class="d-flex align-items-center bb-2 pb-10">
                                                <div class="d-flex flex-column flex-grow-1">
                                                    <h5 class="fw-500 text-primary-light m-0 text-uppercase">Medication</h5>
                                                </div>
                                                <div class="text-end ">
                                                    <h5 class="fw-500 text-primary-light m-0 text-uppercase">past 5 months <i class="fa fa-fw fa-angle-down"></i></h5>
                                                </div>
                                            </div>

                                            <div class="pt-20">
                                                <div class="timeline timeline-single-column timeline-single-full-column">
                                                    <div class="timeline-item timeline-item-arrow-sm">
                                                        <div class="timeline-point timeline-point-success bg-success">
                                                            <i class="fa fa-refresh text-white" aria-hidden="true"></i>
                                                        </div>
                                                        <div>
                                                            <div class="timeline-heading d-flex justify-content-between">
                                                                <h5 class="timeline-title fw-500 mb-0">Nasoclear Spray</h5>
                                                                <p class="text-fade mb-0 fw-500">7 Days</p>
                                                            </div>
                                                            <div class="timeline-body ">
                                                                <p class="text-fade mb-0 fw-500">July 20, 2022</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="timeline-item timeline-item-arrow-sm">
                                                        <div class="timeline-point timeline-point-primary bg-primary">
                                                            <i class="fa fa-check text-white" aria-hidden="true"></i>
                                                        </div>
                                                        <div>
                                                            <div class="timeline-heading d-flex justify-content-between">
                                                                <h5 class="timeline-title fw-500 mb-0">Vicodin</h5>
                                                                <p class="text-fade mb-0 fw-500">10 Days</p>
                                                            </div>
                                                            <div class="timeline-body ">
                                                                <p class="text-fade mb-0 fw-500">May 01, 2022</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="timeline-item timeline-item-arrow-sm">
                                                        <div class="timeline-point timeline-point-primary bg-primary">
                                                            <i class="fa fa-check text-white" aria-hidden="true"></i>
                                                        </div>
                                                        <div>
                                                            <div class="timeline-heading d-flex justify-content-between">
                                                                <h5 class="timeline-title fw-500 mb-0">Vicodin</h5>
                                                                <p class="text-fade mb-0 fw-500">10 Days</p>
                                                            </div>
                                                            <div class="timeline-body ">
                                                                <p class="text-fade mb-0 fw-500">May 01, 2022</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
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
@endsection
