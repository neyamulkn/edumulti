<!-- css -->
<link rel="stylesheet" href="{{ asset('frontend') }}/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('frontend') }}/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('frontend') }}/css/line-awesome.css">
<link rel="stylesheet" href="{{ asset('frontend') }}/css/animate.min.css">
<link rel="stylesheet" href="{{ asset('frontend') }}/css/owl.carousel.min.css">
<link rel="stylesheet" href="{{ asset('frontend') }}/css/owl.theme.default.min.css">
<link rel="stylesheet" href="{{ asset('frontend') }}/css/bootstrap-select.min.css">
<link rel="stylesheet" href="{{ asset('frontend') }}/css/fancybox.css">
<link rel="stylesheet" href="{{ asset('frontend') }}/css/tooltipster.bundle.css">
<link rel="stylesheet" href="{{ asset('frontend') }}/css/style.css">
<!-- end css -->

@yield('css')
@yield('extra_css')
<!-- Custom CSS -->
<link href="{{ asset('frontend')}}/css/custom.css" rel="stylesheet">
<link href="{{ asset('frontend')}}/css/toastr.css" rel="stylesheet">

<style type="text/css">
.loadingData-sm
{
    z-index: 9999; 
    width: 100%;
    height: 20px;
    background: url('{{ asset("assets/images/loader.gif")}}') no-repeat center; 
}
#dataLoading
{
    z-index: 99; 
    width: 100%;
    height: 100%;
    top: 0%;
    left: 0%;
    text-align: center;
    display: none;
    min-height: 200px;
    position: absolute;
    background: #ffffffe0 url('{{ asset("assets/images/loading.gif")}}') no-repeat center; 
}
</style>