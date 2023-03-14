<div>
    <script src="{{ mix('js/app.js') }}"></script>
    @if(session()->has('message'))
        <div class="alert alert-success">{{session()->get('message')}}</div>
    @elseif(session()->has('error'))
        <div class="alert alert-danger">{{session()->get('error')}}</div>
    @endif
</div>
