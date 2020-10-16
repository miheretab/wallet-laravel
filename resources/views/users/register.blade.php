@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
    <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
        <h1>Registerq</h1>
    </div>

    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="p-6">

                <div class="ml-12">
                    <form action="{{ url('/register') }}" method="post"/>
                    @csrf
                    <div class="mt-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4">
                        <label class="form-label">Name:</label> <input name="name" class="form-control {{$errors->get('name') ? 'error' : ''}}" value="{{ old('name') }}" type="text"/>
                    </div>

                    <div class="mt-4">
                        <label class="form-label">Email:</label> <input name="email" class="form-control {{$errors->get('email') ? 'error' : ''}}" value="{{ old('email') }}" type="email"/>
                    </div>

                    <div class="mt-4">
                        <label class="form-label">Password:</label> <input name="password" class="form-control {{$errors->get('password') ? 'error' : ''}}" type="password"/>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="form-submit">Submit</button>
                    </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection