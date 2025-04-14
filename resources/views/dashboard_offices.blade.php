@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            
            
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Dashboard</h5>
                    <form method="GET" action="{{ route('admin.home') }}">
                        <div class="form-group mb-0 d-flex align-items-center">
                            <label for="year" class="mr-2 mb-0">Select Year:</label>
                            <select name="year" id="year" class="form-control" onchange="this.form.submit()">
                                <option value="">All</option>
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <!-- Block 1 -->
                        <div class="col-md-3 mb-1">
                            <div class="card text-white bg-info">
                                <div class="card-body pb-0 d-flex justify-content-between align-items-center mb-4">
                                    <!-- User number on the left -->
                                    <div>
                                        <div class="text-value">{{ number_format($totalPatients) }}</div>
                                        <div>Total Patients</div>
                                    </div>
                                    
                                    <!-- Icon on the right -->
                                    <div>
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Block 2 -->
                        <div class="col-md-3 mb-1">
                            <div class="card text-white bg-dark">
                                <div class="card-body pb-0 d-flex justify-content-between align-items-center mb-4">
                                    <!-- Tasks completed number on the left -->
                                    <div>
                                        <div class="text-value">{{ number_format($totalBurialPatient) }}</div> <!-- Replace 200 with dynamic value -->
                                        <div>Burial Aid Case</div>
                                    </div>
                    
                                    <!-- Icon on the right -->
                                    <div>
                                        <i class="fas fa-dove fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Block 3 -->
                        <div class="col-md-3 mb-1">
                            <div class="card text-white bg-warning">
                                <div class="card-body pb-0 d-flex justify-content-between align-items-center mb-4">
                                    <!-- Ongoing projects number on the left -->
                                    <div>
                                        <div class="text-value">{{ number_format($totalEducationalPatient) }}</div> <!-- Replace 15 with dynamic value -->
                                        <div>Educational Aid Case</div>
                                    </div>
                    
                                    <!-- Icon on the right -->
                                    <div>
                                        <i class="fas fa-book fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Block 4 -->
                        <div class="col-md-3 mb-1">
                            <div class="card text-white bg-danger">
                                <div class="card-body pb-0 d-flex justify-content-between align-items-center mb-4">
                                    <!-- Funds available on the left -->
                                    <div>
                                        <div class="text-value">{{ number_format($totalMedicalPatient) }}</div> <!-- Replace 50000 with dynamic value -->
                                        <div>Medical Aid</div>
                                    </div>
                    
                                    <!-- Icon on the right -->
                                    <div>
                                        <i class="fas fa-hospital fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="row">
                        <!-- Block 5 -->
                        <div class="col-md-3 mb-1">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0 d-flex justify-content-between align-items-center mb-4">
                                    <!-- Progress rate number on the left -->
                                    <div>
                                        <div class="text-value">{{ number_format($totalSubmitted) }}</div> <!-- Replace with dynamic value -->
                                        <div>Total Submitted</div>
                                    </div>
                                    
                                    <!-- Icon on the right -->
                                    <div>
                                        <i class="fas fa-tasks fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Block 6 -->
                        <div class="col-md-3 mb-1">
                            <div class="card text-white bg-secondary">
                                <div class="card-body pb-0 d-flex justify-content-between align-items-center mb-4">
                                    <!-- Agreements made number on the left -->
                                    <div>
                                        <div class="text-value">{{ number_format(50) }}</div> <!-- Replace with dynamic value -->
                                        <div>placeholder</div>
                                    </div>
                    
                                    <!-- Icon on the right -->
                                    <div>
                                        <i class="fas fa-handshake fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Block 7 -->
                        <div class="col-md-3 mb-1">
                            <div class="card text-white bg-dark">
                                <div class="card-body pb-0 d-flex justify-content-between align-items-center mb-4">
                                    <!-- Staff assigned number on the left -->
                                    <div>
                                        <div class="text-value">{{ number_format(30) }}</div> <!-- Replace with dynamic value -->
                                        <div>placeholder</div>
                                    </div>
                    
                                    <!-- Icon on the right -->
                                    <div>
                                        <i class="fas fa-users-cog fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Block 8 -->
                        <div class="col-md-3 mb-1">
                            <div class="card text-white bg-success">
                                <div class="card-body pb-0 d-flex justify-content-between align-items-center mb-4">
                                    <!-- Budget spent number on the left -->
                                    <div>
                                        <div class="text-value">{{ number_format(40) }}%</div> <!-- Replace with dynamic value -->
                                        <div>placeholder</div>
                                    </div>
                    
                                    <!-- Icon on the right -->
                                    <div>
                                        <i class="fas fa-chart-pie fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    Patients per Barangay
                                </div>
                                <div class="card-body">
                                    {!! $barangayChart->renderHtml() !!}
                                </div>
                            </div>
                        </div>
                    
                     <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                Patients Per Month
                            </div>
                            <div class="card-body">
                                {!! $lineChart->renderHtml() !!}
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
@endsection


@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

{!! $barangayChart->renderJs() !!}
{!! $lineChart->renderJs() !!}



@endsection
