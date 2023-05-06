@if(\App\Models\Extension::where('act', 'custom-captcha')->where('status', 1)->first())
    <div class="form--group  row ">
        <div class="col-md-12">
            @php echo  loadCustomCaptcha($height = 46, $width = '100%', $bgcolor = '#003', $textcolor = '#abc') @endphp
        </div>
        <div class="col-md-12 mt-4">
            <input type="text" name="captcha" maxlength="6" class="form-control form--control" placeholder="@lang('Enter Code')" >
        </div>
    </div>
@endif
