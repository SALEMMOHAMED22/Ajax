@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name_ar" class="col-md-4 col-form-label text-md-end">{{ __('words.name_ar') }}</label>

                                <div class="col-md-6">
                                    <input id="name_ar" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name[ar]"
                                        value="{{ old('name[ar]') }}" required autocomplete="name" autofocus>

                                    @error('name[ar]')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="name_en" class="col-md-4 col-form-label text-md-end">{{ __('words.name_en') }}</label>

                                <div class="col-md-6">
                                    <input id="name_en" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name[en]"
                                        value="{{ old('name[en]') }}" required autocomplete="name" autofocus>

                                    @error('name[en]')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="governorate"
                                    class="col-md-4 col-form-label text-md-end">{{ __('words.governorate') }}</label>

                                <div class="col-md-6">
                                    <select name="governorate_id" class="form-control" id="governorate">
                                        <option value="">{{ __('words.select_governorate') }}</option>
                                        @foreach ($governorates as $governorate)
                                            <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                                        @endforeach
                                        <!-- Add more options as needed -->
                                    </select>
                                    @error('governorate_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="city"
                                    class="col-md-4 col-form-label text-md-end">{{ __('words.city') }}</label>

                                <div class="col-md-6">
                                    <select name="city_id" class="form-control" id="city">
                                        <option value="">{{ __('words.select_city') }}</option>
                                        {{-- @foreach ($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach --}}
                                        <!-- Add more options as needed -->
                                    </select>
                                    @error('governorate_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>




                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

 <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


<script>
      $(document).on('change', '#governorate', function(e) {
            e.preventDefault();
            var governorate_id = $(this).val();
            $.ajax({
                url: "{{ route('users.cities') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    governorate_id: governorate_id,
                },
                success: function(response) {
                    $('#city').empty();
                    $('#city').append('<option value="">Select City</option>');
                    $.each(response, function(index, city) {
                        $('#city').append('<option value="' + city.id + '">' + city.name +
                            '</option>');
                    });
                },
                error: function(reject) {
                    console.log(reject);
                }


            });
        });
</script>