@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate.'layouts.breadcrumb')


<section class="padding-top padding-bottom mb-5">
    <div class="container">
        <div class="card">
          <div class="card-body">
            @php echo $policy->data_values->details @endphp
          </div>
        </div>
    </div>
</section>
@endsection