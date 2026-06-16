@extends('layouts.app')

@section('content')

<div class="container">

    <h1 class="mb-4">
        📂 Import / Export Data
    </h1>

    <div class="row">

        <div class="col-md-6">

            <div class="card mb-3">

                <div class="card-body">

                    <h4>📤 Export Data</h4>

                    <p>
                        Download seluruh transaksi ke file CSV.
                    </p>

                    <a
                        href="{{ route('transactions.export') }}"
                        class="btn btn-success">

                        Export CSV

                    </a>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card mb-3">

                <div class="card-body">

                    <h4>📥 Import Data</h4>

                    <p>
                        Import transaksi dari file CSV.
                    </p>

                    <button
                        class="btn btn-secondary"
                        disabled>

                        Segera Hadir

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection