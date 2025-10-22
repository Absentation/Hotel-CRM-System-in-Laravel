@extends('employee.layouts.app')

@section('title', 'Employee Dashboard')

@section('content')
    <header>
        <h1>Welcome, {{ $employee->name }}</h1>
        <p>Here is a quick overview of property activity.</p>
    </header>

    <section style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem;">
        <article>
            <header><strong>Active Bookings</strong></header>
            <p style="font-size:2rem;font-weight:bold;">{{ $activeBookings }}</p>
        </article>
        <article>
            <header><strong>Arrivals Today</strong></header>
            <p style="font-size:2rem;font-weight:bold;">{{ $arrivalsToday }}</p>
        </article>
        <article>
            <header><strong>Open Alerts</strong></header>
            <p style="font-size:2rem;font-weight:bold;">{{ $alertsPending }}</p>
        </article>
    </section>

    <section style="margin-top:2rem;">
        <a href="{{ route('employee.bookings.index') }}" role="button">Manage Bookings</a>
        <a href="{{ route('employee.services.index') }}" role="button" class="secondary">Manage Services</a>
        <a href="{{ route('employee.alerts.create') }}" role="button" class="contrast">Send Alert</a>
    </section>
@endsection
