@extends('layouts.app')

@section('page_title') Prayer Analysis @Stop

@section('content')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name')}}</a></li>
        <li class="breadcrumb-item active">@yield('page_title')</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="d-flex flex-grow-1 p-0 shadow-1">
        <!-- left slider panel : must have unique ID-->
        <div id="js-slide-left" class="flex-wrap flex-shrink-0 position-relative slide-on-mobile slide-on-mobile-left bg-primary-100 pattern-0 p-3">
            <div class="panel-tag">
                <h5>Analysis Reports</h3>
            </div>
            <div class="divider mb-5"></div>
            <div class="panel-tag">
                @include('report.analysis.menu')
            </div>
        </div>
        <!-- left slider panel backdrop : activated on mobile, must be place immideately after left slider closing tag -->
        <div class="slide-backdrop" data-action="toggle" data-class="slide-on-mobile-left-show" data-target="#js-slide-left"></div>
        <!-- middle content area -->
        <div class="d-flex flex-column flex-grow-1 bg-white">
            <div class="p-2">
                <div class="row hidden-lg-up mb-g">
                    <div class="col-12">
                        <!-- this button is activated on mobile view and activates the left panel -->
                        <a href="javascript:void(0);" class="btn btn-primary btn-block btn-md" data-action="toggle" data-class="slide-on-mobile-left-show" data-target="#js-slide-left">
                            Slide Right for Analysis Menu <i class="fal fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-tag">
                    <h5>@yield('page_title') <i>(Most occurrence word)</i></h5>
                </div>
                <div class="content-panel">
                    <form method="get" accept-charset="utf-8">
                        <div class="form-group">
                            <div class="input-group input-group-multi-transition">
                                <input type="text" readonly="" class="form-control" aria-label="" placeholder="">
                                <input type="text" readonly="" class="form-control" aria-label="" placeholder="">
                                <input type="text" readonly="" class="form-control" aria-label="" name="">
                                <input type="text" readonly="" class="form-control" name="date_filter" aria-label="Date filter" id="date_filter">
                                <div class="input-group-append">
                                    <button class="btn btn-xs btn-success col-offset-5">
                                        <i class="fal fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div id="prayer" style="width:100%; height:500px;"></div>
                </div>
                <div class="content-panel">
                    <table id="dt-basic-prayers" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th width="3">{{ __('s/N') }}</th>
                                <th>{{ __('Posted On') }}</th>
                                <th>{{ __('Prayer Point') }}</th>
                                <th>{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($prayers as $i => $item)
                                <tr>
                                    <td width="3">{{ ++$i }}</td>
                                    <td>{{ date('d-m-Y', strtotime($item['created_at'])) }}</td>
                                    <td>{{ $item['prayer_point'] }}</td>
                                    <td style="text-align:center;"> 
                                        @if($item['attended'] == '1')
                                            <span class="badge badge-success"> Cleared </span>
                                        @else
                                            <span class="badge badge-success"> Pending </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align:center;">No Record Found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ URL::to('js/datepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ URL::to('css/datagrid/datatables/datatables.bundle.css') }}">
<link rel="stylesheet" href="{{ URL::to('css/anyChart/anychart-ui.min.css') }}" />
@endpush

@push('js')
<script src="{{ URL::to('js/anyChart/anychart-core.min.js') }}"></script>
<script src="{{ URL::to('js/anyChart/anychart-tag-cloud.min.js') }}"></script>
<script>
    anychart.onDocumentReady(function() {
        var prayerData = "{{ $prayerData }}"
        var prayerChart = anychart.tagCloud();

        prayerChart.data(prayerData, {
            mode: "byWord",
            maxItems: 150,
            ignoreItems: ['a', "the",'father', 'my', "and","he","or", "of","in","thy", 'wife', 'husband', 'okechukwu', 'daniel', 'sesughter', 'chidinma', 'gladys', 'to', 'me', 'will', 'you', 'he', 'him', 'for', 'i', 'see', 'let','father', 'please', 'your', 'us', 'with', 'her', 'she', 'said', 'at', 'any', 'call', 'by', 'have', 'has', 'their', 'ieren', 'this', 'all', 'lord', 'as', 'from', 'form', 'name', 'like', 'on', 'into', 'than', 'body', 'ever', 'everyday', 'would', 'own', 'far', 'today', 'human', 'according', 'ones']
        });
        
        prayerChart.angles([0]);

        prayerChart.container('prayer');
        prayerChart.draw();
    });
</script>
<script src="{{ URL::to('js/datagrid/datatables/datatables.bundle.js') }}"></script>
<script src="{{ URL::to('js/datagrid/datatables/datatables.export.js') }}"></script>
<script>
    $(document).ready(function()
    {
        $('#dt-basic-prayers').dataTable(
        {
            responsive: true,
            dom: "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    titleAttr: 'Generate PDF',
                    className: 'btn-outline-danger btn-sm mr-1'
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    titleAttr: 'Generate Excel',
                    className: 'btn-outline-success btn-sm mr-1'
                },
                {
                    extend: 'print',
                    text: 'Print',
                    titleAttr: 'Print Table',
                    className: 'btn-outline-primary btn-sm'
                }
            ]
        });

        $('#dt-basic-birthday').dataTable(
        {
            responsive: true,
            dom: "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    titleAttr: 'Generate PDF',
                    className: 'btn-outline-danger btn-sm mr-1'
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    titleAttr: 'Generate Excel',
                    className: 'btn-outline-success btn-sm mr-1'
                },
                {
                    extend: 'print',
                    text: 'Print',
                    titleAttr: 'Print Table',
                    className: 'btn-outline-primary btn-sm'
                }
            ]
        });

    });

</script>

<script src="{{ URL::to('js/datepicker/moment.min.js') }}"></script>
<script src="{{ URL::to('js/datepicker/daterangepicker.js') }}"></script>

<script>
        $(function() {

            let dateInterval = getQueryParameter('date_filter');
            let end = moment().endOf('day');
            let start = moment().subtract(6, 'days');
            if (dateInterval) {
                dateInterval = dateInterval.split(' - ');
                start = dateInterval[0];
                end = dateInterval[1];
            }
            $('#date_filter').daterangepicker({
                "showDropdowns": true,
                "showWeekNumbers": true,
                startDate: start,
                endDate: end,
                locale: {
                    format: 'YYYY-MM-DD',
                    firstDay: 1,
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                    'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
                }
            });

        });

        function getQueryParameter(name) {
            const url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            const regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
    </script>
@endpush