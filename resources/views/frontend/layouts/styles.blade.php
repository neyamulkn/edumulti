
<link href="{{ asset('frontend')}}/css/styles.css" rel="stylesheet">

<!-- Custom Color Option -->
<link href="{{ asset('frontend')}}/css/colors.css" rel="stylesheet">
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
