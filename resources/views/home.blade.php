@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
    <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
        <h1>Profile</h1>
    </div>

    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="p-6">
                <div class="flex items-center">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <div class="ml-4 text-lg leading-7 font-semibold">Wallet Token</div>
                </div>

                <div class="ml-12">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                        You have {{ auth()->user()->active_wallets_count }} wallet token left.
                    </div>
                    <div>
                        <br />
                        <form action="{{ url('/buy-token') }}" method="post" >
                            @csrf
                            @method('put')
                            <input type="number" name="quantity" class="form-control" placeholder="Quantity" />
                            <button type="submit" class="form-submit">Buy Token</button>
                        </form>
                        <br />
                        @if (auth()->user()->active_wallets_count > 0)
                        <table>
                            <thead class="items-left"><tr><th>Token</th> <th>Action</th></tr></thead>
                            <tbody>
                                @foreach(auth()->user()->active_wallets->get() as $wallet)
                                <tr>
                                    <td>{{ $wallet->token }}</td>
                                    <td>
                                        <form action="{{ url('/use-token') }}" method="post" >
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="token" value="{{ $wallet->token }}" />
                                            <button type="submit" class="form-submit">Use Token</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection